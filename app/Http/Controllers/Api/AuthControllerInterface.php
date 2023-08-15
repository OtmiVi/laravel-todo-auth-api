<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

interface AuthControllerInterface
{
    /**
     * Create User
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse;

    /**
     * Login The User
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse;

    /**
     * Logout The User
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse;
}
