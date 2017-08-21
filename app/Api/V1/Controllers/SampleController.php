<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\SampleTransformer;
use App\Api\V1\Models\AuthenticationService;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use App\Api\V1\Models\SampleService;

class SampleController extends AbstractController
{
    protected $service;

    public function __construct(IRequest $request)
    {
        parent::__construct($request, new AuthenticationService($request));
        $this->service = new SampleService($request, $this->userId);
    }

    public function getListAction(IRequest $request)
    {
        // Check permission - Throw 401 if not permission
        $this->checkPermission($request, 'permissionName');

        $result = $this->service->sampleMethod();
        // Convert Guzzle response to Lumen/Laravel response
        $response = $this->convertResponse($result);
        return $response;
    }
}
