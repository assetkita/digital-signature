<?php

namespace Assetku\DigitalSignature;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\UploadedFile;
use Psr\Http\Message\RequestInterface;

class HTTPClient
{
    /**
     * @var string
     */
    const POST_FORM_PARAMS = 'form_params';

    /**
     * @var string
     */
    const POST_MULTIPART = 'multipart';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * HTTPClient constructor.
     *
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $stack = new HandlerStack;
        $stack->setHandler(new CurlHandler);
        $stack->push($this->addHeaders($config['headers']));

        $config['handler'] = $stack;

        $this->client = new Client($config);
    }

    /**
     * Get client
     *
     * @return object
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set request
     *
     * @param  RequestInterface  $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Get request
     *
     * @return object
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Do a get request
     *
     * @param  string  $uri
     * @param  array  $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $uri, array $params = [])
    {
        $queryParams = $this->formatQueryParams($params);

        try {
            return $this->client->request('GET', $uri, $queryParams);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Do a post request
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  string  $option
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function post(string $uri, array $data, $option = self::POST_FORM_PARAMS)
    {
        $formData = $this->formatFormData($data, $option);

        try {
            return $this->client->request('POST', $uri, $formData);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Format the given data as form data
     *
     * @param  array  $data
     * @param  string  $option
     * @return array
     */
    protected function formatFormData(array $data, string $option)
    {
        $formData = $data;

        if ($option === static::POST_MULTIPART) {
            $formData = collect($data)
                ->map(function ($item, $key) {
                    $type = gettype($item);

                    $result = [
                        'name' => $key
                    ];

                    $result['contents'] = $item;

                    if ($type === 'array') {
                        $result['contents'] = json_encode($item, JSON_UNESCAPED_SLASHES);
                    }

                    if ($type === 'object') {
                        if ($item instanceof UploadedFile) {
                            $result['contents'] = fopen($item->getRealPath(), 'r');
                        }
                    }

                    return $result;
                })
                ->toArray();
        }

        return [
            $option => $formData
        ];
    }

    /**
     * Format the given parameters as query parameters
     *
     * @param  array  $params
     * @return array
     */
    protected function formatQueryParams(array $params)
    {
        return [
            'query' => $params
        ];
    }

    /**
     * Add headers to the request
     *
     * @param  array  $headers
     * @return \Closure
     */
    protected function addHeaders(array $headers)
    {
        return function (callable $handler) use ($headers) {
            return function (RequestInterface $request, array $options) use ($handler, $headers) {
                foreach ($headers as $header => $value) {
                    $request = $request->withHeader($header, $value);
                }

                $this->setRequest($request);

                return $handler($request, $options);
            };
        };
    }
}
