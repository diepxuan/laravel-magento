<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:55:09
 */

use Diepxuan\Magento\Http\Controllers\ApiController;
use Diepxuan\Magento\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['GET', 'POST'], '/magento/api/{type}', [ApiController::class, 'token'])->name('api.new');

Route::post('callback/{connection}', [OAuthController::class, 'callback'])
    ->name('magento.oauth.callback')
;

Route::get('identity/{connection}', [OAuthController::class, 'identity'])
    ->middleware(config('magento.oauth.middleware'))
    ->name('magento.oauth.identity')
;
