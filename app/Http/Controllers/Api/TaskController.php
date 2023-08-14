<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;
            $tasks = Task::where('user_id', $userId)->where('parent_id', 1)->get();
            return response()->json([
                'status' => true,
                'data' => $tasks
            ], 201);
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
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::with(['user', 'childTasks'])->find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found'
                ], 404);
            }
            $userId = $request->user()->id;
            if($task->user_id == $userId){
                return response()->json([
                    'status' => true,
                    'data' => $task
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "You haven't permission"
                ], 403);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        try {

            $data = $request->validated();

            if(isset($validateUser['errors'])){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $userId = $request->user()->id;
            $data += [ 'user_id' => $userId ];

            if( $data['parent_id'] != 1) {
                $parent = Task::find($data['parent_id']);
                if( $parent->user_id == $userId){
                    $task = Task::create($data);
                    return response()->json([
                        'status' => true,
                        'data' => $task
                    ], 201);
                }
            } else {
                $task = Task::create($data);
                return response()->json([
                    'status' => true,
                    'data' => $task
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => "You haven't permission"
            ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param TaskRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, $id): JsonResponse
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found'
                ], 404);
            }

            $data = $request->validated();

            if(isset($validateUser['errors'])){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if( $data['parent_id'] != 1) {
                $parent = Task::find($data['parent_id']);
                $userId = $request->user()->id;
                if( $parent->user_id == $userId){
                    $task->update($data);
                    return response()->json([
                        'status' => true,
                        'data' => $task
                    ], 201);
                }
            } else {
                $task->update($data);
                return response()->json([
                    'status' => true,
                    'data' => $task
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => "You haven't permission"
            ], 403);

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
    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found'
                ], 404);
            }

            if( $task->parentId != 1) {
                $userId = $request->user()->id;
                if( $task->user_id == $userId){
                    $task->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Task deleted'
                    ], 201);
                }
            } else {
                $task->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Task deleted'
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => "You haven't permission"
            ], 403);

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
    public function changeStatus(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found'
                ], 404);
            }

            $userId = $request->user()->id;
            if( $task->user_id == $userId){
                $status = $task->status == 'todo' ? 'done' : 'todo';
                $task->update(['status'=>$status] );
                return response()->json([
                    'status' => true,
                    'data' => $task
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => "You haven't permission"
            ], 403);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

