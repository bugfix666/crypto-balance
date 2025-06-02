<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * MainController
 * php version 8.3
 *
 * @category controllers
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class MainController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }
}
