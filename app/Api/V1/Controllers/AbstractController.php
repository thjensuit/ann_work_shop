<?php
/**
 * Created by PhpStorm.
 * User: tungchung
 * Date: 5/24/16
 * Time: 8:36 AM
 */

namespace App\Api\V1\Controllers;

use App\Api\V1\Models\AuthorizationService;
use App\Api\V1\Models\BaseService;
use Laravel\Lumen\Routing\Controller;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Illuminate\Http\Response as LumenResponse;

/**
 * Class BaseController
 * @package App\Api\V1\Controllers
 *
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="seldat.seldat-wms20.menu.dev",
 *     basePath="/",
 *     definitions={},
 *     @SWG\Info(
 *         version="WMS 2.0.0",
 *         title="Dynamic Menu APIs",
 *         description="Total Dynamic menu APIs",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="dai.ho@seldatinc.com"
 *         ),
 *         @SWG\License(
 *             name="WMS2.0",
 *             url="seldatinc.com"
 *         )
 *     ),
 *     @SWG\Definition(
 *         definition="data",
 *         type="object",
 *         properties={
 *             @SWG\Property(property="menu_group_id", type="integer"),
 *             @SWG\Property(property="name", type="string"),
 *             @SWG\Property(property="description", type="string"),
 *         },
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="",
 *         url=""
 *     )
 * )
 */
abstract class AbstractController extends Controller
{
    protected $userId;

    public function __construct(IRequest $request, BaseService $service = null)
    {
        $token = $request->getHeader('Authorization');
        if(empty($token[0])) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        $result = $service->getUserIdByToken($request->getHeader('Authorization'));
        if (! $result) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
        $this->userId = $result;
    }
    /**
     * Check permission for every action request
     *
     * @param $request
     * @param $permission
     */
    public function checkPermission(IRequest $request, $permission, $data = [])
    {
        $token = $request->getHeader('Authorization');
        if(empty($token[0])) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        $client = new AuthorizationService($request);
        $client->check($permission, $data);
    }

    protected function convertResponse(IResponse $response)
    {
        $luResponse = new LumenResponse($response->getBody(), $response->getStatusCode(), $response->getHeaders());
        return $luResponse;
    }

//    public function ()
//    {
//
//    }
}
