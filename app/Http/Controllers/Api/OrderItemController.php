<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderItemResource;
use App\Services\OrderItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderItemController extends Controller
{
    /**
     * @var OrderItemService
     */
    protected OrderItemService $service;

    public function __construct(OrderItemService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get (
     *     tags={"Order Item"},
     *     path="/api/orders/{id}/items",
     *     summary="List all items of orders",
     *     @OA\Parameter(
     *         description="Order id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function index(Request $request, int $orderId): JsonResponse
    {
        $request->merge(['order_id' => $orderId]);
        return $this->ok(OrderItemResource::collection(
            $this
                ->service
                ->getRepository()
                ->getPaginationList(params: $request->all())
        ));
    }

    /**
     *
     * @OA\Post (
     *     tags={"Order Item"},
     *     path="/api/orders/{id}/items",
     *     summary="Create a order Item",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Order registered successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     security={{ "jwt": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="order_id", type="integer", example="1"),
     *             @OA\Property(property="product_id", type="integer", example="1"),
     *             @OA\Property(property="quantity", type="integer", example="10"),
     *         )
     *     )
     * )
     *
     * @param  Request  $request
     * @return JsonResponse
     */

    public function store(StoreOrderItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $response = $this->service->save($request->all());
            DB::commit();
            return $this->success($this->messageSuccessDefault,
                $response,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/api/orders/{id}",
     *     summary="Get information about an order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Order retrieved successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to retrieve the order"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param  int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        return $this->ok($this->service->getRepository()->find($id));
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $response = $this->service->update($id, $request->all());
            DB::commit();
            return $this->success(
                $this->messageSuccessDefault,
                $response,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * @OA\Delete (
     *     tags={"Order Item"},
     *     path="/api/orders/{orderId}/items/{id} ",
     *     summary="Delete a orderItem",
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the orderItem to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="OrderItem deleted successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="OrderItem not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to delete the order Item"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param  int $orderId
     * @param  int $id
     * @return JsonResponse
     */

    public function destroy(int $orderId ,int $id): JsonResponse
    {
        try {
            $this->service->getRepository()->find($id);
            $this->service->delete($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
