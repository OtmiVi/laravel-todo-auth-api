<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tasks = Task::with(['user', 'childTasks'])->get();
            return response()->json($tasks);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $task = Task::with(['user', 'childTasks'])->find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            return response()->json($task);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'status' => 'required|in:todo,done',
                'priority' => 'required|in:1,2,3,4,5',
                'title' => 'required|max:256',
                'description' => 'nullable',
                'parent_id' => 'nullable|exists:tasks,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $task = Task::create($data);

            return response()->json($task, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $data = $request->validate([
                'status' => 'required|in:todo,done',
                'priority' => 'required|in:1,2,3,4,5',
                'title' => 'required|max:256',
                'description' => 'nullable',
                'parent_id' => 'nullable|exists:tasks,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $task->update($data);

            return response()->json($task);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $task->delete();

            return response()->json(['message' => 'Task deleted']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

