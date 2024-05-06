<?php

declare(strict_types=1);

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 *
 * © Tran Ngoc Duc <ductn@diepxuan.com>
 *   Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace Diepxuan\Magento\Api;

use Diepxuan\Magento\Exceptions\LaravelMagentoTwoException;
use Diepxuan\Magento\Magento2 as Magento;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class AbstractApi
{
    /**
     * This is not in the original package.
     * At present, the value should be 1 for almost all ID purposes because we only have the one store.
     * This seems like it should be a config, though, rather than a class constant.
     * Per response from `/rest/default/V1/store/websites`, website_id 0 is Magento admin, 1 is storefront.
     */
    const WEBSITE_ID = 1;

    /**
     * The Magento Client instance.
     *
     * @var Magento
     */
    public $magento;

    /**
     * The API request Uri builder.
     *
     * @var string
     */
    public $apiRequest;

    public function __construct(Magento $magento)
    {
        $this->magento    = $magento;
        $this->apiRequest = $this->constructRequest();
    }

    /**
     * The initial API request before the builder.
     */
    protected function constructRequest(): string
    {
        $request = $this->magento->baseUrl;
        $request .= '/' . $this->magento->basePath;

        // Allow "none" to bypass the inclusion of the store code
        // This is to allow API calls with full access to work on any store or guest/admin
        if ('none' !== $this->magento->storeCode) {
            $request .= '/' . $this->magento->storeCode;
        }

        if ($this->magento->versionIncluded) {
            $request .= '/' . $this->magento->version;
        }

        return $request;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $parameters
     *
     * @throws \Exception
     */
    protected function get(string $path, $parameters = []): Response
    {
        return $this->call('get', $path, $parameters);
    }

    /**
     * Send a POST request with query parameters.
     *
     * @param string $parameters
     *
     * @throws \Exception
     */
    protected function post(string $path, $parameters = []): Response
    {
        return $this->call('post', $path, $parameters);
    }

    /**
     * Send a PUT request.
     *
     * @param mixed $path
     *
     * @throws \Exception
     */
    protected function put($path, array $parameters = []): Response
    {
        return $this->call('put', $path, $parameters);
    }

    /**
     * Send a DELETE request.
     *
     * @param mixed $path
     *
     * @throws \Exception
     */
    protected function delete($path, array $parameters = []): Response
    {
        return $this->call('delete', $path, $parameters);
    }

    /**
     * Check for any type of invalid API Responses.
     *
     * @throws LaravelMagentoTwoException
     */
    protected function checkExceptions(Response $response, string $endpoint, array $parameters): Response
    {
        if ($response->serverError()) {
            throw new LaravelMagentoTwoException($response['message'] ?? $response);
        }

        if (!$response->successful()) {
            if (config('magento.log_failed_requests')) {
                Log::debug('[MAGENTO API][STATUS] ' . $response->status() . ' [ENDPOINT] ' . $endpoint . ' [PARAMETERS]  ' . json_encode($parameters) . ' [RESPONSE] ' . json_encode($response->json()));
            }
        }

        return $response;
    }

    /**
     * Validates the usage of the store code as needed.
     *
     * @throws \Exception
     */
    protected function validateSingleStoreCode(): self
    {
        if ('all' === $this->magento->storeCode) {
            throw new \Exception(__('You must pass a single store code. "all" cannot be used.'));
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function call(string $method, string $path, array $parameters): Response
    {
        return $this->checkExceptions(
            Http::withOptions([
                'debug' => config('magento.debug', true),
                // for non-production environments, don't worry about verifying ssl
                'verify' => (bool) ('production' === config('app.env')),
            ])
                ->withToken($this->magento->token)
                ->asJson()
                ->acceptJson()
                ->{$method}($this->apiRequest . $path, $parameters),
            $this->apiRequest . $path,
            $parameters
        );
    }
}
