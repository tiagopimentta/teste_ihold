<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }


    /**
     * @OA\Get (
     *     tags={"Order"},
     *     path="/api/orders",
     *     summary="List all orders",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->ok(OrderResource::collection(
            $this
                ->service
                ->getRepository()
                ->getPaginationList(params: $request->all(), with: ['items'])
        ));
    }


    /**
     * Store a new Order.
     *
     * @OA\Post (
     *     tags={"Order"},
     *     path="/api/orders",
     *     summary="Create a orders",
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
     *             @OA\Property(property="user_id", type="integer", example="1"),
     *         )
     *     )
     * )
     *
     * @param  Request  $request
     * @return JsonResponse
     */

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request['status'] = 'Pendente';
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
     * Update a Order.
     *
     * @OA\Put (
     *     tags={"Order"},
     *     path="/api/orders/{id}",
     *     summary="Order a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Order of the order to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Order updated successfully"
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
     *             @OA\Property(property="status", type="string", example="Finalizado"),
     *         )
     *     )
     * )
     *
     * @param  Request  $request
     * @param  string   $id
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
     * Show an order.
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/api/orders/{id}/",
     *     summary="Get information about an order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Order",
     *         @OA\Schema(type="string")
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
     * @param  string $id
     * @return JsonResponse
     */

    public function show(string $id): JsonResponse
    {
        return $this->ok($this->service->getRepository()->find($id));
    }

    /**
     * Delete a Order.
     *
     * @OA\Delete (
     *     tags={"Order"},
     *     path="/api/orders/{id}/",
     *     summary="Delete a order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Order of the order to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Order deleted successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to delete the Order"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param  string  $id
     * @return JsonResponse
     */

    public function destroy(int $id): JsonResponse
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
