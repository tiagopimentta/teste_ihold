<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MerchantResource;
use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MerchantController extends Controller
{
    /**
     * @var MerchantService
     */
    protected MerchantService $service;

    public function __construct(MerchantService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get (
     *     tags={"Merchants"},
     *     path="/api/merchants",
     *     summary="List all merchants",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     security={{ "jwt": {} }}
     * )
     * @param Request $id
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->ok(MerchantResource::collection(
            $this
                ->service
                ->getRepository()
                ->getPaginationList(params: $request->all(), with: ['products', 'admin'])
        ));
    }

    /**
     *
     * @OA\Post (
     *     tags={"Merchants"},
     *     path="/api/merchants",
     *     summary="Create a merchants",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Merchants registered successfully"
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
     *             @OA\Property(property="merchant_name", type="string", example="Zé delivery"),
     *             @OA\Property(property="admin_id", type="integer", example="1"),
     *         )
     *     )
     * )
     *
     * @param  Request  $request
     * @return JsonResponse
     */

    public function store(Request $request): JsonResponse
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
     * @OA\Get(
     *     tags={"Merchants"},
     *     path="/api/merchants/{id}",
     *     summary="Get information about an merchants",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the merchants to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Merchants retrieved successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Merchants not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to retrieve the merchants"
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

    /**
     *
     * @OA\Put (
     *     tags={"Merchants"},
     *     path="/api/merchants/{id}/",
     *     summary="Update a Merchants",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the merchants to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Merchants updated successfully"
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
     *             @OA\Property(property="merchant_name", type="string", example="João"),
     *         )
     *     )
     * )
     *
     * @param  Request  $request
     * @param  int   $id
     * @return JsonResponse
     */

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $response = $this->service->update($id, $request->only(['merchant_name', 'admin_id']));
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
     *     tags={"Merchants"},
     *     path="/api/merchants/{id}/",
     *     summary="Delete a merchants",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the merchants to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Merchant deleted successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You do not have permission to delete the Merchants"
     *     ),
     *     security={{ "jwt": {} }}
     * )
     *
     * @param  int  $id
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
