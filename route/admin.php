<?php
irouter()->middleware('BaseMiddleware')
    ->middleware('BeforeMiddleware')
    ->middleware('AfterMiddleware')
    ->name('group-admin')
    ->group('/admin', function (\W7\Core\Route\Route $route) {
        $route->name('route-menu')->post('/menu/authList', [\W7\App\Controller\Admin\MenuController::class, 'authList']);
        $route->name('route-login')->post('/login/logout', [\W7\App\Controller\Admin\LoginController::class, 'logout']);
        $route->name('region-list')->post('/region/list', [\W7\App\Controller\Admin\RegionController::class, 'regionList']);
        $route->name('region-add')->post('/region/add', [\W7\App\Controller\Admin\RegionController::class, 'regionAdd']);
        $route->name('region-set')->post('/region/set', [\W7\App\Controller\Admin\RegionController::class, 'regionSet']);
        $route->name('region-delete')->post('/region/delete', [\W7\App\Controller\Admin\RegionController::class, 'regionDel']);
        $route->name('region-index')->post('/region/index', [\W7\App\Controller\Admin\RegionController::class, 'regionIndex']);
        $route->name('paylog-list')->post('/payment/log', [\W7\App\Controller\Admin\PaymentLogController::class, 'paymentlogList']);
    });

irouter()->middleware('BaseMiddleware')
    ->middleware('AfterMiddleware')
    ->name('group-login')
    ->group('/admin', function (\W7\Core\Route\Route $route) {
        $route->name('route-login')->get('/login/index', [\W7\App\Controller\Admin\LoginController::class, 'index']);
        $route->name('route-login')->post('/help/router', [\W7\App\Controller\Admin\HelpController::class, 'router']);
        $route->name('route-login')->post('/login/chack', [\W7\App\Controller\Admin\LoginController::class, 'chack']);
        $route->name('route-login')->get('/login/test', [\W7\App\Controller\Admin\LoginController::class, 'test']);
        $route->name('route-login')->post('/login/test', [\W7\App\Controller\Admin\LoginController::class, 'test']);
    });

// 文件上传
irouter()->middleware('BaseMiddleware')
    ->middleware('AfterMiddleware')
    ->name('group-login')
    ->group('/admin', function (\W7\Core\Route\Route $route) {
        $route->name('upload-upload')->post('/upload/upload', [\W7\App\Controller\Admin\UploadController::class, 'upload']);
        $route->name('upload-thumb')->get('/upload/thumb', [\W7\App\Controller\Admin\UploadController::class, 'thumb']);
    });


irouter()->middleware('BaseMiddleware')
    ->middleware('BeforeMiddleware')
    ->middleware('AfterMiddleware')
    ->name('group-message')
    ->group('/admin', function (\W7\Core\Route\Route $route) {
        $route->name('route-message')->post('/message/unread', [\W7\App\Controller\Admin\MessageController::class, 'unread']);
        $route->name('route-level')->post('/level/list', [\W7\App\Controller\Admin\LevelController::class, 'levelList']);
        $route->name('level-delete')->post('/level/delete', [\W7\App\Controller\Admin\LevelController::class, 'levelDelete']);
        $route->name('route-authlist')->post('/auth/authList', [\W7\App\Controller\Admin\AuthController::class, 'authList']);
        $route->name('route-user')->post('/user/list', [\W7\App\Controller\Admin\UserController::class, 'userList']);
        $route->name('user-status')->post('/user/status', [\W7\App\Controller\Admin\UserController::class, 'userStatus']);
        $route->name('user-delete')->post('/user/delete', [\W7\App\Controller\Admin\UserController::class, 'userDelete']);
        $route->name('payment-list')->post('/payment/list', [\W7\App\Controller\Admin\PaymentController::class, 'paymentList']);
        $route->name('transaction-list')->post('/transaction/list', [\W7\App\Controller\Admin\TransactionController::class, 'transactionList']);
        $route->name('qrcode-callurl')->post('/qrcode/callurl', [\W7\App\Controller\Admin\QrcodeController::class, 'callurl']);
        $route->name('draw-list')->post('/withdraw/list', [\W7\App\Controller\Admin\WithdrawController::class, 'drawList']);
        $route->name('ask-list')->post('/ask/list', [\W7\App\Controller\Admin\AskController::class, 'askList']);
        $route->name('ask-delete')->post('/ask/delete', [\W7\App\Controller\Admin\AskController::class, 'askDelete']);
        $route->name('ask-item')->post('/ask/item', [\W7\App\Controller\Admin\AskController::class, 'askItem']);
        $route->name('setting-list')->post('/setting/list', [\W7\App\Controller\Admin\SettingController::class, 'settingList']);
        $route->name('setting-set')->post('/setting/set', [\W7\App\Controller\Admin\SettingController::class, 'setSystem']);
        $route->name('setting-setupload')->post('/setting/upload', [\W7\App\Controller\Admin\SettingController::class, 'setUpload']);
        $route->name('setting-wxapp')->post('/setting/wxapp', [\W7\App\Controller\Admin\SettingController::class, 'setWxapp']);
        $route->name('setting-webapp')->post('/setting/webapp', [\W7\App\Controller\Admin\SettingController::class, 'setWebapp']);
        $route->name('upload-module')->post('/upload/module', [\W7\App\Controller\Admin\UploadController::class, 'uploadModule']);
        $route->name('upload-token')->post('/upload/token', [\W7\App\Controller\Admin\UploadController::class, 'getToken']);

        $route->name('storage-select')->post('/storage/select', [\W7\App\Controller\Admin\StorageController::class, 'directorySelect']);

    });