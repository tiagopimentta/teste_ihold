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
     * @param Request $request
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
     * @param Request $request
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
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        return $this->ok($this->service->getRepository()->find($id));
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
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
