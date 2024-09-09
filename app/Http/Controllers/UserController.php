<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequests\UserStoreRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Http\Resources\UserResources\UserResource;
use App\Http\Resources\UserResources\UserCollection;
use App\Services\UserServices\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public const NOT_FOUND_MESSAGE = 'user not found.';

    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->getAll($request->all());

        return response()->json(
            new UserCollection($users)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user= $this->userService
            ->create($request->validated());

        return response()->json(
            [
                'message' => __('actions.success'),
                'data' => new UserResource($user)
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
        $user = $this->userService->findById($id, $request->input('with',[]));
        if (! $user) {
            return response()->json(['message' => self::NOT_FOUND_MESSAGE], 404);
        }
        $this->authorize('view', $user);

        return response()->json(new UserResource ($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $this->userService->update( $user, $request->validated());
        return response()->json([
            'message' => __('actions.success'),
            'data' => new UserResource ($user)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(User $user, Request $request): JsonResponse
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return response()->json([ 'message' => __('actions.success')],202);
    }
}
