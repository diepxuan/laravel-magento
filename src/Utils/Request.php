<?php

declare(strict_types=1);

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 *
 * © Tran Ngoc Duc <ductn@diepxuan.com>
 *   Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace Diepxuan\Magento\Utils;

use Diepxuan\Magento\Exceptions\MagentoClientException;
use Diepxuan\Magento\Exceptions\MagentoRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\HandlerStack;

class Request
{
    /**
     * @var Client
     */
    public $client;

    /**
     * Request constructor.
     *
     * @param null  $token
     * @param array $options
     * @param array $headers
     */
    public function __construct($token = [], $options = [], $headers = [])
    {
        //     $this->baseUrl   = $baseUrl ?: config('magento.base_url');
        //     $this->token     = $token ?: config('magento.token');
        //     $this->version   = $version ?: config('magento.version') ?: 'V1';
        //     $this->basePath  = $basePath ?: config('magento.base_path') ?: 'rest';
        //     $this->storeCode = $storeCode ?: config('magento.store_code') ?: 'all';
        $token = array_replace([
            'consumer_key'    => 'anonymous',
            'consumer_secret' => 'anonymous',
            'token'           => 'anonymous',
            'token_secret'    => 'anonymous',

            'signature_method' => Oauth1::SIGNATURE_METHOD_HMACSHA256,
        ], $token);
        $middleware = new Oauth1($token);
        $stack      = HandlerStack::create();
        $stack->push($middleware);

        $headers = array_merge([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $headers);

        $options = array_merge([
            'headers' => $headers,
            'handler' => $stack,
            'auth'    => 'oauth',
        ], $options);

        $this->client = new Client($options);
    }

    /**
     * @param mixed $callback
     *
     * @return mixed
     *
     * @throws MagentoClientException
     * @throws MagentoRequestException
     */
    public function handleWithExceptions($callback)
    {
        try {
            return $callback();
        } catch (ClientException $exception) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ($exception->hasResponse()) {
                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new MagentoRequestException($message, $code);
        } catch (ServerException $exception) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ($exception->hasResponse()) {
                $message = (string) $exception->getResponse()->getBody();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new MagentoRequestException($message, $code);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            throw new MagentoClientException($message, $code);
        }
    }
}
