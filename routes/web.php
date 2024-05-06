<?php

declare(strict_types=1);

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 *
 * © Tran Ngoc Duc <ductn@diepxuan.com>
 *   Tran Ngoc Duc <caothu91@gmail.com>
 */

use Diepxuan\Magento\Http\Controllers\ApiController;
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

Route::match(['GET', 'POST'], '/api/{type}', [ApiController::class, 'token'])->name('api.new');
