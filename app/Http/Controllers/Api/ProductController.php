<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    /**
     * @var ProductService
     */

    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get (
     *     tags={"Products"},
     *     path="/api/products",
     *     summary="List all products",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        return $this->ok(ProductResource::collection(
            $this
                ->service
                ->getRepository()
                ->getPaginationList(params: $request->all())
        ));
    }

    public function create()
    {
        //
    }

    /**
     * Store a new product.
     *
     * @OA\Post (
     *     tags={"Products"},
     *     path="/api/products",
     *     summary="Create a product",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Product registered successfully"
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
     *             @OA\Property(property="name", type="string", example="Skoll 200ML"),
     *             @OA\Property(property="merchant_id", type="integer", example="1"),
     *             @OA\Property(property="price", type="integer", example="100.00"),
     *             @OA\Property(property="status", type="string", example="Ativo"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request)
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
     * Show a Products.
     *
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/products/{id}",
     *     summary="Get information about an products",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the products to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Products retrieved successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Products not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to retrieve the products"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param string $id
     * @return JsonResponse
     */

    public function show(string $id): JsonResponse
    {
        return $this->ok($this->service->getRepository()->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        //
    }

    /**
     * Update a product.
     *
     * @OA\Put (
     *     tags={"Products"},
     *     path="/api/products/{id}/",
     *     summary="Update a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Product updated successfully"
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
     *             @OA\Property(property="name", type="string", example="Skoll 200ML"),
     *             @OA\Property(property="price", type="number", format="float", example="100.00"),
     *             @OA\Property(property="status", type="string", example="Ativo"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @param int id
     * @return JsonResponse
     */


    public function update(Request $request, string $id): JsonResponse
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
     * Delete a product.
     *
     * @OA\Delete (
     *     tags={"Products"},
     *     path="/api/products/{id}/",
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Product deleted successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to delete the product"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param string $id
     * @return JsonResponse
     */

    public function destroy(string $id): JsonResponse
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
