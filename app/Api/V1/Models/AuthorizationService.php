<?php
namespace App\Api\V1\Models;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ServerRequestInterface as IRequest;

class AuthorizationService extends BaseService
{

    /**
     * AuthorizationService constructor.
     * @param $request
     * @param string $baseUrl
     */
    public function __construct(IRequest $request, $baseUrl = '')
    {
        $api = $baseUrl ?: env('API_AUTHORIZATION');
        parent::__construct($request, $api);
    }

    /**
     * @param $permission
     * @param $data
     * @return array
     */
    public function check($permission, $data)
    {
        $body = [
            'form_params' => [
                'permission' => $permission,
                'data' => $data,
            ]
        ];

        $response = $this->client->post('authorize', $body);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        $responseBody = $response->getBody()->getContents();
        $permission = $this->responseToArray($responseBody);

        if (! array_get($permission, 'permission', false)) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
        return $permission;
    }
}
