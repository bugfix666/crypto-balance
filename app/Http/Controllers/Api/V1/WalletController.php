<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\HttpResponseController;
use App\Http\Requests\ChangeBalanceRequest;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * WalletController
 * php version 8.3
 *
 * @category controllers
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class WalletController extends HttpResponseController
{
    public function __construct(
        private readonly WalletService $walletService
    ) {
    }

    #[OA\Post(
        path: '/api/v1/wallet/add-balance',
        summary: 'Add balance',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(
                    required: ['wallet_uuid', 'amount'],
                    properties: [
                        new OA\Property(
                            property: 'wallet_uuid',
                            description: 'Uuid of the wallet',
                            type: 'string',
                            example: '85949663-786f-30c5-97e5-2193867f2c32',
                        ),
                        new OA\Property(
                            property: 'amount',
                            description: 'Amount to add balance of the wallet',
                            type: 'number',
                            example: '123.45',
                        ),
                    ]
                )
            )
        ),
        tags: ['Wallet'],
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
    public function add(ChangeBalanceRequest $request): JsonResponse
    {
        return $this->response(function () use ($request) {
            return $this->walletService->addBalance(
                amount: $request->get('amount'),
                walletUuid: $request->get('wallet_uuid')
            );
        });
    }

    #[OA\Post(
        path: '/api/v1/wallet/sub-balance',
        summary: 'Subtract from balance',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(
                    required: ['wallet_uuid', 'amount'],
                    properties: [
                        new OA\Property(
                            property: 'wallet_uuid',
                            description: 'Uuid of the wallet',
                            type: 'string',
                            example: '85949663-786f-30c5-97e5-2193867f2c32',
                        ),
                        new OA\Property(
                            property: 'amount',
                            description: 'Amount to add balance of the wallet',
                            type: 'number',
                            example: '123.45',
                        ),
                    ]
                )
            )
        ),
        tags: ['Wallet'],
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
    public function sub(ChangeBalanceRequest $request): JsonResponse
    {
        return $this->response(function () use ($request) {
            $this->walletService->subBalance(
                amount: $request->get('amount'),
                walletUuid: $request->get('wallet_uuid')
            );
        });
    }
}
