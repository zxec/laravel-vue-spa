<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     */
    public function current(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->user());
    }
}
