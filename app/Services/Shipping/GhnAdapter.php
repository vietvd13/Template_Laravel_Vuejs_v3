<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/24/2020
 * Time: 16:15
 */

namespace App\Services\Shipping;


use App\Services\Contracts\ShippingSystem;
use Psr\Http\Message\ResponseInterface;

class GhnAdapter extends AbstractAdapter implements ShippingSystem
{
    protected $apiKey;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
        parent::__construct();
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function formatResponse(ResponseInterface $response)
    {
        $jsonResponse = [
            'success' => $response->getStatusCode() === 200,
        ];
        $data = json_decode($response->getBody()->getContents(), true);
        return array_merge($jsonResponse, $data);
    }

    /**
     * @param null $url
     * @return \Illuminate\Config\Repository|mixed
     */
    public function setApiUrl($url = null)
    {
        return $url ?: config('shipping.ghn.api_url');
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
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
        $headers['token'] = $this->apiKey;
        return parent::doRequest($method, $endPoint, $params, $headers);
    }

    /**
     * @param $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createStore($params)
    {
//        $response = $this->doRequest('post', 'shop/register', [
//            'name' => 'test',
//            'phone' => '0389338965',
//            'address' => '123 bb',
//            'district_id' => 1550,
//            'ward_code' => '420112'
//        ]);
//        return $response;
    }

    /**
     * @param $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStores($params = null)
    {
        $response = $this->doRequest('get', 'shop/all', [
            'offset' => data_get($params, 'offset', 0),
            'limit' => data_get($params, 'limit', 50),
        ]);
        return $response;
    }

}