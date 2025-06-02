<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\ResponseFailure;
use App\Http\Responses\ResponseSuccess;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Throwable;

/**
 * HttpResponseController
 * php version 8.3
 *
 * @category controllers
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class HttpResponseController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected bool $hasTrace = false;

    /**
     * @param callable $callback
     * @param string $successResponseCassName
     * @return JsonResponse
     */
    public function response(callable $callback, string $successResponseCassName = ResponseSuccess::class): JsonResponse
    {
        try {
            $result = $callback();
        } catch (Throwable $e) {
            return (new ResponseFailure())
                ->fromException(exception: $e, hasTrace: $this->hasTrace)
                ->setStatus(status: HttpFoundationResponse::HTTP_BAD_REQUEST)
                ->asJSON();
        }
        return (new $successResponseCassName())
            ->setData(data: $result)
            ->asJSON();
    }
}
