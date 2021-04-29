<?php

use Slim\App;

return function (App $app) {
    $app->post(
        '/api/v1/secret/{identyfikator}',
         SecretReadAction::class
    );

    $app->post(
        '/api/v1/secret',
         SecretCreateAction::class
    );

    $app->delete(
        '/api/v1/cron/deleted_expired',
         ExpiredSecretDeleteAction::class
    );

    $app->get(
        '/',
         MainViewAction::class
    );

    $app->get(
        '/secret/{identyfikator}',
         LoadSecretAction::class
    );
};
