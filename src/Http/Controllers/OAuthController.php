<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:03:54
 */

namespace Diepxuan\Magento\Http\Controllers;

use Diepxuan\Magento\Contracts\OAuth\RequestsAccessToken;
use Diepxuan\Magento\Http\Requests\CallbackRequest;
use Diepxuan\Magento\Http\Requests\IdentityRequest;
use Diepxuan\Magento\OAuth\KeyStore\KeyStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class OAuthController extends Controller
{
    public function callback(CallbackRequest $request, string $connection): Response
    {
        KeyStore::instance()->merge($connection, [
            'callback' => $request->validated(),
        ]);

        return response()->json();
    }

    public function identity(
        IdentityRequest $request,
        RequestsAccessToken $contract,
        string $connection
    ): RedirectResponse {
        $contract->request(
            $connection,
            $request->oauth_consumer_key,
        );

        return redirect()->to($request->success_call_back);
    }
}
