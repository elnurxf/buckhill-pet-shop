<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * * @OA\Get(
     * path="/api/v1/brands",
     * operationId="allUsers",
     * tags={"Users"},
     * summary="List all Users",
     * description="List all Users",
     *      @OA\Parameter(
     *           name="page",
     *           in="query",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *      @OA\Parameter(
     *           name="limit",
     *           in="query",
     *           @OA\Schema(
     *           type="integer"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="sortBy",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *      @OA\Parameter(
     *           name="desc",
     *           in="query",
     *           @OA\Schema(
     *               type="boolean"
     *           )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="User logout"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit') ? (int) $request->get('limit') : 10;
        $limit = abs(min($limit, 50));

        return UserResource::collection(
            User::sortable($request)->paginate($limit)->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/brand/create",
     * operationId="CreateUser",
     * security={{"bearer_token": {}}},
     * tags={"Users"},
     * summary="Create User",
     * description="Create new User",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"title"},
     *               @OA\Property(property="title", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Display created brand"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $brand = User::create($validated);

        return UserResource::make($brand);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     * path="/api/v1/brand/{uuid}",
     * operationId="singleUser",
     * tags={"Users"},
     * summary="Display fetched brand",
     * description="Display fetched brand",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Display fetched brand"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function show(User $brand)
    {
        return UserResource::make($brand);
    }

    public function update(UpdateUserRequest $request, User $brand)
    {
        $validated = $request->validated();

        $brand->update($validated);

        return UserResource::make($brand);
    }

    public function destroy(User $brand)
    {
        $brand->delete();

        return new JsonResponse([
            'success' => true,
            'error'   => null,
            'errors'  => [],
            'extra'   => [],
        ], Response::HTTP_OK);
    }

    public function orders(Request $request)
    {

    }

    public function forgot_password(Request $request)
    {

    }

    public function reset_password_token(Request $request)
    {

    }

}
