<?php
namespace App\Api\V1\Controllers;

use App\Api\V1\Controllers\AbstractController;
use App\Api\V1\Models\AuthenticationService;
use App\Api\V1\Models\MenuService;
use GuzzleHttp\Psr7\Request;

class AuthenticationController extends AbstractController
{
    protected $service;

    public function __construct(Request $request)
    {

    }

    public function actionLogin(Request $request)
    {
        // TODO: login action will be here
    }
}