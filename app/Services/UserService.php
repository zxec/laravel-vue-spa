<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $request): \Illuminate\Http\JsonResponse
    {
        $request['password'] = Hash::make($request['password']);
        return response()->json(User::create($request));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $request, User $user): \Illuminate\Http\JsonResponse
    {
        if (empty($request['password'])) {
            unset($request['password']);
        } else {
            $request['password'] = Hash::make($request['password']);
        }
        $user->update($request);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        if(auth()->user()->id === $id) {
            return response()->json(['error' => __('auth.fail_delete_user')]);
        }
        return response()->json(User::destroy($id));
    }
}
