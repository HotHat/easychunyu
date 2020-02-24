<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyChunYu\Kernel\Support;

use ChunYuYiSheng\Application;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class BaseClient
{
    protected $app;
    protected $client;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->client = $this->app['http_client'];
    }

    /**
     * Extra request params.
     *
     * @return array
     */
    protected function prepends()
    {
        return [];
    }

    protected function request(string $endpoint, array $params = [], $method = 'post', array $options = [], $returnResponse = false)
    {
        $base = [
            'partner' => $this->app['config']['partner'],
            'atime' => time()
        ];

        $params = array_filter(array_merge($base, $this->prepends(), $params), 'strlen');
        $params['sign'] = substr(md5($this->app['config']['partner_key'].$base['atime'].$params['user_id']), 8, 16);;

        // $this->app['logger']->debug(json_encode($params));
        $response = $this->client->request($method, $endpoint,  [
            'json' => $params
        ]);

        return $returnResponse ? $response : $this->castResponseToType($response);
    }

    protected function castResponseToType($response) {
        $response->getBody()->rewind();
        $contents = $response->getBody()->getContents();

        $content =  \preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', $contents);
        $array = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

        if (JSON_ERROR_NONE === json_last_error()) {
            return (array) $array;
        }
        return [];
    }

    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware()
    {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ?? MessageFormatter::DEBUG);

        return Middleware::log($this->app['logger'], $formatter);
    }

    /**
     * Make a request and return raw response.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     *
     * @return ResponseInterface
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function requestRaw(string $endpoint, array $params = [], $method = 'post', array $options = [])
    {
        /** @var ResponseInterface $response */
        $response = $this->request($endpoint, $params, $method, $options, true);

        return $response;
    }

    /**
     * Make a request and return an array.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function requestArray(string $endpoint, array $params = [], $method = 'post', array $options = []): array
    {
        $response = $this->requestRaw($endpoint, $params, $method, $options);

        return $this->castResponseToType($response, 'array');
    }

    /**
     * Request with SSL.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function safeRequest($endpoint, array $params, $method = 'post', array $options = [])
    {
        $options = array_merge([
            'cert' => $this->app['config']->get('cert_path'),
            'ssl_key' => $this->app['config']->get('key_path'),
        ], $options);

        return $this->request($endpoint, $params, $method, $options);
    }

    /**
     * Wrapping an API endpoint.
     *
     * @param string $endpoint
     *
     * @return string
     */
    protected function wrap(string $endpoint): string
    {
        return $this->app->inSandbox() ? "sandboxnew/{$endpoint}" : $endpoint;
    }
}
