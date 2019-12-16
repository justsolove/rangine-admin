<?php
irouter()->middleware('BaseMiddleware')
    ->name('group-upload')
    ->group('/wxapp', function (\W7\Core\Route\Route $route) {
        $route->name('route-wxappUploadImg')->post('/upload/upload', [\W7\App\Controller\Wxapp\UploadController::class, 'upload']);
    });