<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\UserResource;
use Bugfix666\CryptoBalanceWallet\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use SoftInvest\Http\Controllers\HttpResponseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * UserController
 * php version 8.3
 *
 * @category controllers
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class UserController extends HttpResponseController
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    #[OA\Get(
        path: '/api/v1/users ',
        summary: 'Users',
        tags: ['Users'],
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
    public function index(): JsonResponse
    {
        return $this->response(function () {
            return UserResource::collection($this->userService->getList());
        });
    }
}
