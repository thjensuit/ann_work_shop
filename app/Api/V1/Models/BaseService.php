<?php
namespace App\Api\V1\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ServerRequestInterface as IRequest;

class BaseService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * BaseService constructor.
     * @param $request
     * @param string $baseUrl
     */
    public function __construct(IRequest $request, $baseUrl = '')
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => $request->getHeader('Authorization')
            ],
        ]);
    }

    /**
     * @param $json
     * @param string $type
     * @return array
     */
    public function responseToArray($json, $type = 'data')
    {
        return \json_decode($json, true)[$type];
    }

    /**
     * GET User Id by token
     *
     * @param string $token
     * @return int
     */
    public function getUserIdByToken($token)
    {
        $authenticationUrl = env('API_AUTHENTICATION') . 'user/token';
        $header = [
            'Authorization' => $token,
        ];
        $options = [
            'headers' => $header
        ];
        $response = $this->client->post($authenticationUrl, $options);
        $responseData = json_decode($response->getBody(), true);
        if ($response->getStatusCode() !== 200 || ! isset($responseData['data']) || empty($responseData['data'])){
            return false;
        }
        return $responseData['data']['user_id'];

    }
}
