<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::create(
        '/GetCityStatesameVal', 'POST', ['country_id' => 101, 'selected' => '']
    )
);
echo $response->getContent();
