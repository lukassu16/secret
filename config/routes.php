<?php

use Slim\App;

return function (App $app) {
    $app->post('/api/v1/secret', \App\Action\SecretCreateAction::class);
};
