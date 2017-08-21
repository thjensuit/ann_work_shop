<?php
namespace App\Api\V1\Models;

use App\Api\V1\Models\BaseService;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use GuzzleHttp\Exception\RequestException;

class SampleService extends BaseService
{
    private $userId;

    public function __construct(IRequest $request, $userId, $baseUrl = '')
    {
        $api = $baseUrl ?: env('API_SAMPLE');
        parent::__construct($request, $api);
        $this->userId = $userId;
    }

    public function sampleMethod($params)
    {
        $uri = env('API_SAMPLE');
        try {
            // $this->client : Guzzle Client
            $response = $this->client->get($uri);
            return $response;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
            return false;
        }
    }
}
