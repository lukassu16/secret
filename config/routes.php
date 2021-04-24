<?php

use Slim\App;

return function (App $app) {
    // $app->post(
    //     '/api/v1/secret/{identyfikator}',
    //      \App\Action\SecretReadAction::class
    // );

    $app->post(
        '/api/v1/secret',
         \App\Action\SecretCreateAction::class
    );

    $app->delete(
        '/api/v1/cron/deleted_expired',
         \App\Action\ExpiredSecretDeleteAction::class
    );
};
