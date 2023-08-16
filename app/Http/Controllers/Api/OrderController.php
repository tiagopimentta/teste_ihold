<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    /**
     * @OA\Get (
     *     tags={"Order"},
     *     path="/api/orders",
     *     summary="List all orders",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return OrderResource::collection(
            $this
                ->orderService
                ->getRepository()
                ->getPaginationList(params: $request->all(), with: ['items'])
        );
    }
}
