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
   
<<<<<<< HEAD
    'supportsCredentials' => false,
    'allowedOrigins' => [''],
    'allowedHeaders' => [''],
=======
  /*  'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'maxAge' => 0,
*/
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['*'],
>>>>>>> ddecb60260a5abe60f52a1d3e936713b346e5771
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE', 'OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
<<<<<<< HEAD

=======
>>>>>>> ddecb60260a5abe60f52a1d3e936713b346e5771
];
