<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\FindOperationsRequest;
use App\Http\Resources\OperationResource;
use Bugfix666\CryptoBalanceWallet\Services\OperationService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use SoftInvest\Http\Controllers\HttpResponseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * OperationController
 * php version 8.3
 *
 * @category controllers
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class OperationController extends HttpResponseController
{
    public function __construct(
        private readonly OperationService $operationService
    ) {
    }

    #[OA\Post(
        path: '/api/v1/operations ',
        summary: 'List of operations',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(
                    required: ['user_uuid'],
                    properties: [
                        new OA\Property(
                            property: 'user_uuid',
                            description: 'Uuid of the user',
                            type: 'string',
                            example: '85949663-786f-30c5-97e5-2193867f2c32',
                        )
                    ]
                )
            )
        ),
        tags: ['Operations'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successfully response',
                content: new OA\JsonContent()
            ),
            new OA\Response(
                response: Response::HTTP_INTERNAL_SERVER_ERROR,
                description: 'Error: Internal Server Error'
            ),
        ]
    )]
    public function index(FindOperationsRequest $request): JsonResponse
    {
        return $this->response(function () use ($request) {
            return OperationResource::collection(
                $this->operationService->findByUserUuid($request->get('user_uuid'))
            );
        });
    }
}
