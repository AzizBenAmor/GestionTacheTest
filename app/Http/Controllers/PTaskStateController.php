<?php

namespace App\Http\Controllers;

use App\Models\PTaskState;
use App\Http\Requests\PTaskStateRequests\PTaskStateStoreRequest;
use App\Http\Requests\PTaskStateRequests\PTaskStateUpdateRequest;
use App\Http\Resources\PTaskStateResources\PTaskStateResource;
use App\Http\Resources\PTaskStateResources\PTaskStateCollection;
use App\Services\PTaskStateServices\PTaskStateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PTaskStateController extends Controller
{
    public const NOT_FOUND_MESSAGE = 'Task State not found.';

    public function __construct(private PTaskStateService $pTaskStateService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', PTaskState::class);

        $pTaskStates = $this->pTaskStateService->getAll($request->all());

        return response()->json(
            new PTaskStateCollection($pTaskStates)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(PTaskStateStoreRequest $request): JsonResponse
    {
        $pTaskState= $this->pTaskStateService
            ->create($request->validated());

        return response()->json(
            [
                'message' => __('actions.success'),
                'data' => new PTaskStateResource($pTaskState)
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show( $id, Request $request): JsonResponse
    {
        $pTaskState = $this->pTaskStateService->findById($id, $request->input('with',[]));
        if (! $pTaskState) {
            return response()->json(['message' => self::NOT_FOUND_MESSAGE], 404);
        }
        $this->authorize('view', $pTaskState);

        return response()->json(new PTaskStateResource ($pTaskState));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(PTaskStateUpdateRequest $request, PTaskState $pTaskState): JsonResponse
    {
        $this->pTaskStateService->update( $pTaskState, $request->validated());
        return response()->json([
            'message' => __('actions.success'),
            'data' => new PTaskStateResource ($pTaskState)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(PTaskState $pTaskState, Request $request): JsonResponse
    {
        $this->authorize('delete', $pTaskState);

        $this->pTaskStateService->delete($pTaskState);

        return response()->json([ 'message' => __('actions.success')],202);
    }
}
