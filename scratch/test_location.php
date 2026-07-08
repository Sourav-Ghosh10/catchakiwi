<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create(
        '/GetCityStatesameVal', 'POST', ['country_id' => 101, 'selected' => '']
    )
);
echo $response->getContent();
