<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\User as UserService;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->index($request);
        return DataTables::of($users)->make(true);
    }

    public function store(StoreUserRequest $request)
    {
        return $this->res($this->userService->store($request->validated()));
    }

    public function show(User $user){
        return $this->res($user);
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        return $this->res($this->userService->update($user, $request->validated()));
    }

    public function destroy(User $user){
        return $this->res($this->userService->destroy($user));
    }
}
