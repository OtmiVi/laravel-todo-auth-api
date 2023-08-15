<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TaskControllerInterface
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse;

    /**
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse;

    /**
     * @param TaskRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, $id): JsonResponse;

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id): JsonResponse;

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function changeStatus(Request $request, $id): JsonResponse;
}
