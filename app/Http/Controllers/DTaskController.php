<?php

namespace App\Http\Controllers;

use App\Enums\UserEnums\RoleEnum;
use App\Http\Requests\DTaskRequests\DTaskRelationshipRequest;
use App\Models\DTask;
use App\Http\Requests\DTaskRequests\DTaskStoreRequest;
use App\Http\Requests\DTaskRequests\DTaskUpdateRequest;
use App\Http\Resources\DTaskResources\DTaskResource;
use App\Http\Resources\DTaskResources\DTaskCollection;
use App\Services\DTaskServices\DTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DTaskController extends Controller
{
    public const NOT_FOUND_MESSAGE = 'Task State not found.';

    public function __construct(private DTaskService $dTaskService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DTaskRelationshipRequest $request)
    {
        $this->authorize('viewAny', DTask::class);
        $dTasks = $this->dTaskService->getAll($request->all());
        return view('dashboard',compact('dTasks'));
    }

    public function updateStatus(DTask $dTask)
    {
        $this->authorize('update', $dTask);
        $dTask = $this->dTaskService->updateStatus($dTask);

        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(DTaskStoreRequest $request)
    {
        $dTask= $this->dTaskService
            ->create($request->validated());
            return redirect()->route('dashboard');

        // return response()->json(
        //     [
        //         'message' => __('actions.success'),
        //         'data' => new DTaskResource($dTask)
        //     ],
        //     201
        // );
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show( $id, DTaskRelationshipRequest $request): JsonResponse
    {
        $dTask = $this->dTaskService->findById($id, $request->input('with',[]));
        if (! $dTask) {
            return response()->json(['message' => self::NOT_FOUND_MESSAGE], 404);
        }
        $this->authorize('view', $dTask);

        return response()->json(new DTaskResource ($dTask));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function edit(dTask $dTask){
       [ $users,$assignedUsers]=$this->dTaskService->getUsers($dTask);
       $pTaskStatuses=$this->dTaskService->getStatus($dTask);
       $user=auth()->user();
       if ($user->role == RoleEnum::admin()->value || $dTask->user_id == $user->id) {
            
           return view('tasks.edit',compact('dTask','users','assignedUsers'));
       }
       return view('tasks.noedit',compact('dTask','users','assignedUsers','pTaskStatuses'));

    }
    public function update(DTaskUpdateRequest $request, DTask $dTask)
    {
        $this->dTaskService->update( $dTask, $request->validated());
        return redirect()->route('dashboard');
        // return response()->json([
        //     'message' => __('actions.success'),
        //     'data' => new DTaskResource ($dTask)
        // ], 200);
    }   

    public function create(){
        $users=$this->dTaskService->getUsers();
        return view('tasks.create',compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(DTask $dTask, Request $request)
    {
        $this->authorize('delete', $dTask);

        $this->dTaskService->delete($dTask);

       return redirect()->route('dashboard');
        // return response()->json([ 'message' => __('actions.success')],202);
    }
}
