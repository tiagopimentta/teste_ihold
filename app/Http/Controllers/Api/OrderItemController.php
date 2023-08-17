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
     *     path="/api/orders/{orderId}/items",
     *     summary="List all items of orders",
     *     @OA\Parameter(
     *         description="Order id",
     *         in="path",
     *         name="orderId",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @param Request $request
     * @param int $orderId
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
     * @param StoreOrderItemRequest $request
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
     * @param UpdateOrderRequest $request
     * @param int $id
     * @return JsonResponse
     */
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
     * @param int $orderId
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $orderId, int $id): JsonResponse
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
