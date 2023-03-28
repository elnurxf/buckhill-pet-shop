<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderStatusResource;
use App\Models\OrderStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit') ? (int) $request->get('limit') : 10;
        $limit = abs(min($limit, 50));

        return OrderStatusResource::collection(
            OrderStatus::sortable($request)->paginate($limit)->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderStatusRequest $request)
    {
        $validated = $request->validated();

        $orderStatus = OrderStatus::create($validated);

        return OrderStatusResource::make($orderStatus);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus)
    {
        return OrderStatusResource::make($orderStatus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusRequest $request, OrderStatus $orderStatus)
    {
        $validated = $request->validated();

        $orderStatus->update($validated);

        return OrderStatusResource::make($orderStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return new JsonResponse([
            'success' => true,
            'error'   => null,
            'errors'  => [],
            'extra'   => [],
        ], Response::HTTP_OK);
    }
}
