<?php

namespace AirLST\CoreSdk\Api\Abstracts;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiWorker
 *
 * @package AirLST\CoreSdk\Api\Abstracts
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
abstract class ApiWorker
{

    /**
     * @var string|null
     */
    protected ?string $authorizationToken = null;

    /**
     * @var array
     */
    protected array $extendedHeaders = [];

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $lastResponse = null;

    /**
     * ApiWorker constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseUri()
        ]);
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return rtrim(config('airlst-sdk.api.base_uri'), '/') . '/';
    }

    /**
     * @return array
     */
    public function getExtendedHeaders(): array
    {
        return $this->extendedHeaders;
    }

    /**
     * @param  array  $extendedHeaders
     */
    public function setExtendedHeaders(array $extendedHeaders): void
    {
        $this->extendedHeaders = $extendedHeaders;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    /**
     * @param  string  $path
     * @param  string  $method
     * @param  array  $parameters
     * @param  array  $extendedHeaders
     * @return bool
     */
    protected function doRequest(
        string $path,
        string $method = 'GET',
        array $parameters = [],
        array $extendedHeaders = []
    ): bool {
        $method = Str::upper($method);
        $requestOptions = [
            'headers' => $this->prepareRequestHeaders($extendedHeaders)
        ];

        if ($method === 'GET') {
            $requestOptions['query'] = $parameters;
        } else {
            $requestOptions['json'] = $parameters;
        }

        try {
            $response = $this->client->request(
                $method,
                trim(ltrim($path, '/')),
                $requestOptions
            );

            $this->lastResponse = $response;
        } catch (\Throwable $e) {
            if ($e instanceof ServerException) {
                $this->lastResponse = $e->getResponse();
            }

            if (config('airlst-sdk.api.debug')) {
                throw $e;
            }
            return false;
        }

        return true;
    }

    /**
     * @param  array  $extendedHeaders
     * @return array
     */
    protected function prepareRequestHeaders(array $extendedHeaders): array
    {
        $out = $this->extendedHeaders;
        if ($this->getAuthorizationToken()) {
            $out['Authorization'] = 'Bearer ' . $this->getAuthorizationToken();
        }

        return array_merge(
            $out,
            $extendedHeaders
        );
    }

    /**
     * @return string|null
     */
    public function getAuthorizationToken(): ?string
    {
        return $this->authorizationToken;
    }

    /**
     * @param  string|null  $authorizationToken
     */
    public function setAuthorizationToken(?string $authorizationToken): void
    {
        $this->authorizationToken = $authorizationToken;
    }

    /**
     * @param  bool  $returnFullResponse
     * @return array|null
     */
    protected function extractDataFromLastResponse(bool $returnFullResponse = false)
    {
        $content = $this->lastResponse->getBody()->getContents();

        switch (Arr::first($this->lastResponse->getHeader('Content-Type'))) {
            case 'application/json':
                $responseData = json_decode($content, true);

                if (!$returnFullResponse) {
                    $responseData = Arr::get($responseData, 'data', null);
                }

                return $responseData;
            default:
                return $content;
        }
    }
}
