<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContentRequest;
use App\Services\Content as ContentService;
use App\Models\Content as ContentModel;

class ContentController extends Controller
{

    protected ContentService $contentService;
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contents = $this->contentService->type($request->type ?? null)->index($request);

        $start = request()->input('start', 0); 
        $length = request()->input('length', 10);
        
        $page = intval($start / $length) + 1;
        
        $contents->withTexts();
        $contents->adminSort();
        $contents->filter();
        $contents->adminSearch();

        $custom = collect([
            'recordsFiltered' => $contents->count(),
            'recordsTotal' => $contents->count()
        ]);
        
        $data = $custom->merge($contents->paginate($length, ['*'], 'page', $page));
        return $this->withoutMessage()->res($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentRequest $request)
    {
        $content = $this->contentService->create($request->validated());
        return $this->res($content->show());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->res($this->contentService->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreContentRequest $request, ContentModel $content)
    {
        return $this->res($this->contentService->update($content, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentModel $content)
    {
		$this->contentService->delete($content->id);
        return response()->json($content);
    }
}
