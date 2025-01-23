<?php

return [
    'auth' => \App\Middlewares\AuthenticatedMiddleware::class,
    'noAuth' => \App\Middlewares\NoAuthenticatedMiddleware::class,

];