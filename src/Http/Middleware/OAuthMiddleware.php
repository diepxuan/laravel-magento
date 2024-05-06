<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:47:38
 */

namespace Diepxuan\Magento\Http\Middleware;

use Diepxuan\Magento\Enums\AuthenticationMethod;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This middleware will prevent any OAuth routes from being accessible when OAuth is not active on any of the connections.
 */
class OAuthMiddleware
{
    /**
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        /** @var array $connections */
        $connections = config('magento.connections');

        foreach ($connections as $connection) {
            /** @var string $method */
            $method = $connection['authentication_method'];
            if (AuthenticationMethod::OAuth === AuthenticationMethod::from($method)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
