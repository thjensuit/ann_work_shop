<?php
namespace App\Api\V1\Models;

use App\Api\V1\Models\BaseService;
use Psr\Http\Message\ServerRequestInterface as IRequest;

class AuthenticationService extends BaseService
{
    const USER_TOKEN_URI = 'user/token';

    /**
     * AuthorizationService constructor.
     * @param $request
     * @param string $baseUrl
     */
    public function __construct(IRequest $request, $baseUrl = '')
    {
        $api = $baseUrl ?: env('API_AUTHENTICATION');
        parent::__construct($request, $api);
    }

    public function getUserIdByToken($token)
    {
        $options = [
            'headers' => [
                'Authorization' => $token
            ]
        ];
        try {
            $response = $this->client->post(self::USER_TOKEN_URI, $options);
            if ($response->getStatusCode() != 200) {
                return false;
            }
            $responseData = json_decode($response->getBody(), true);
            if (empty($responseData['data']) || empty($responseData['data']['user_id'])) {
                return false;
            }
            return $responseData['data']['user_id'];
        } catch (\Exception $e) {
            return false;
        }

    }
}
