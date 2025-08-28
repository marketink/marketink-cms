<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\File;
class FileController extends Controller
{
    protected File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|in:' . collect(types())->pluck('type')->values()->join(','),
            'type' => [
                'required_if:content,true',
                function ($attribute, $value, $fail) use ($request) {
                    $typeData = collect(types())->where('type', $request->content)->first();
                    if (!$typeData) {
                        return $fail(trans("message.content_invalid"));
                    }
                    if (!isset($typeData['media']) || $typeData['media'] == false) {
                        return $fail(trans("message.content_invalid"));
                    }
                    $validTypes = collect($typeData['files'])->join(',');
                    if (!in_array($value, explode(',', $validTypes))) {
                        return $fail(trans("message.type_invalid"));
                    }
                }
            ]
        ]);

        $file = $this->file->file($request->file('file'))->type($request->type)->store();
        return response()->json($file->result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = $this->file->destroy($id);
        return response()->json($file->result);
    }
}
