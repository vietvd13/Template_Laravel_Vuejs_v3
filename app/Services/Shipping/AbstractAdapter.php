<?php
/**
 * Created by PhpStorm.
 * User: Cuongnt
 * Date: 11/24/2020
 * Time: 16:17
 */

namespace App\Services\Shipping;


use App\Services\Contracts\ShippingAdapterInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAdapter implements ShippingAdapterInterface
{
    protected $apiUrl;

    public function __construct()
    {
        $this->makeApiUrl();
    }

    /**
     * @return mixed
     */
    abstract public function setApiUrl();

    /**
     *
     */
    protected function makeApiUrl()
    {
        $this->apiUrl = $this->setApiUrl();
    }

    /**
     * @param $method
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest($method, $endPoint, $params = [], $headers = [])
    {
        $client = new Client();
        $headers['Content-Type'] = 'application/json';
        $response = $client->request($method, $this->apiUrl . $endPoint, [
            'http_errors' => false,
            'json' => $params,
            'headers' => $headers,
        ]);
        return $this->formatResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function formatResponse(ResponseInterface $response)
    {
        $jsonResponse = [
            'success' => $response->getStatusCode() === 200,
            'code' => $response->getStatusCode(),
            'data' => json_decode($response->getBody()->getContents(), true)
        ];
        return $jsonResponse;
    }
}