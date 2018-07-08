<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => true,
    'allowedOrigins' => ['*'],

    'allowedHeaders' => ['Origin', 'Content-Type', 'Accept', 'Authorization', 'X-Request-With'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE', 'OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],


];
