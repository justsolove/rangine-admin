<?php
irouter()->middleware('BaseMiddleware')
    ->middleware('BeforeMiddleware')
    ->middleware('AfterMiddleware')
    ->name('group-message')
    ->group('/admin2', function (\W7\Core\Route\Route $route) {
        $route->name('route-authlist')->post('/auth/authList', [\W7\App\Controller\Admin\AuthController::class, 'authList']);
        $route->name('route-authsave')->post('/auth/authSave', [\W7\App\Controller\Admin\AuthController::class, 'authSave']);
        $route->name('route-authSortSave')->post('/auth/authSortSave', [\W7\App\Controller\Admin\AuthController::class, 'authSortSave']);
        $route->name('route-authAdd')->post('/auth/authAdd', [\W7\App\Controller\Admin\AuthController::class, 'authAdd']);
        $route->name('route-authDel')->post('/auth/authDel', [\W7\App\Controller\Admin\AuthController::class, 'authDel']);
        $route->name('route-authStatusSave')->post('/auth/authStatusSave', [\W7\App\Controller\Admin\AuthController::class, 'authStatusSave']);

        //菜单
        $route->name('route-menuList')->post('/menu/getMenuList', [\W7\App\Controller\Admin\MenuController::class, 'getMenuList']);
        $route->name('route-setMenuItem')->post('/menu/setMenuItem', [\W7\App\Controller\Admin\MenuController::class, 'setMenuItem']);
        $route->name('route-addMenuItem')->post('/menu/addMenuItem', [\W7\App\Controller\Admin\MenuController::class, 'addMenuItem']);
        $route->name('route-setMenuStatus')->post('/menu/setMenuStatus', [\W7\App\Controller\Admin\MenuController::class, 'setMenuStatus']);
        //delMenuItem
        $route->name('route-delMenuItem')->post('/menu/delMenuItem', [\W7\App\Controller\Admin\MenuController::class, 'delMenuItem']);
        $route->name('route-setMenuIndex')->post('/menu/setMenuIndex', [\W7\App\Controller\Admin\MenuController::class, 'setMenuIndex']);

        //权限规则
        $route->name('route-authRuleList')->post('/authrule/authRuleList', [\W7\App\Controller\Admin\AuthRuleController::class, 'getAuthRuleList']);
        $route->name('route-setAuthRuleItem')->post('/authrule/setAuthRuleItem', [\W7\App\Controller\Admin\AuthRuleController::class, 'setAuthRuleItem']);
        $route->name('route-addAuthRuleItem')->post('/authrule/addAuthRuleItem', [\W7\App\Controller\Admin\AuthRuleController::class, 'addAuthRuleItem']);
        $route->name('route-setAuthRuleStatus')->post('/authrule/setAuthRuleStatus', [\W7\App\Controller\Admin\AuthRuleController::class, 'setAuthRuleStatus']);
        //delAuthRuleList
        $route->name('route-delAuthRuleList')->post('/authrule/delAuthRuleList', [\W7\App\Controller\Admin\AuthRuleController::class, 'delAuthRuleList']);
        $route->name('route-setAuthRuleIndex')->post('/authrule/setAuthRuleIndex', [\W7\App\Controller\Admin\AuthRuleController::class, 'setAuthRuleIndex']);

        //管理员管理
        $route->name('route-adminList')->post('/admin/list', [\W7\App\Controller\Admin\AdminController::class, 'getAdminList']);//addAdminItem
        $route->name('route-addAdminItem')->post('/admin/addAdminItem', [\W7\App\Controller\Admin\AdminController::class, 'addAdminItem']);//setAdminItem
        $route->name('route-setAdminItem')->post('/admin/setAdminItem', [\W7\App\Controller\Admin\AdminController::class, 'setAdminItem']);
        $route->name('route-resetAdminItem')->post('/admin/resetAdminItem', [\W7\App\Controller\Admin\AdminController::class, 'resetAdminItem']);//delAdminList
        $route->name('route-delAdminList')->post('/admin/delAdminList', [\W7\App\Controller\Admin\AdminController::class, 'delAdminList']);//setAdminStatus
        $route->name('route-setAdminStatus')->post('/admin/setAdminStatus', [\W7\App\Controller\Admin\AdminController::class, 'setAdminStatus']);
        $route->name('route-setAdminPassword')->post('/admin/setAdminPassword', [\W7\App\Controller\Admin\AdminController::class, 'setAdminPassword']);


        //文章分类管理
        $route->name('route-articleCatList')->post('/articleCat/articleCatList', [\W7\App\Controller\Admin\ArticleCatController::class, 'getArticleCatList']);
        $route->name('route-setArticleCatItem')->post('/articleCat/setArticleCatItem', [\W7\App\Controller\Admin\ArticleCatController::class, 'setArticleCatItem']);//addArticleCatItem
        $route->name('route-addArticleCatItem')->post('/articleCat/addArticleCatItem', [\W7\App\Controller\Admin\ArticleCatController::class, 'addArticleCatItem']);
        $route->name('route-delArticleCatList')->post('/articleCat/delArticleCatList', [\W7\App\Controller\Admin\ArticleCatController::class, 'delArticleCatList']);

        //文章管理
        $route->name('route-getArticleList')->post('/article/getArticleList', [\W7\App\Controller\Admin\ArticleController::class, 'getArticleList']);
        $route->name('route-getArticleItem')->post('/article/getArticleItem', [\W7\App\Controller\Admin\ArticleController::class, 'getArticleItem']);//setArticleStatus
        $route->name('route-setArticleStatus')->post('/article/setArticleStatus', [\W7\App\Controller\Admin\ArticleController::class, 'setArticleStatus']);//setArticleTop
        $route->name('route-setArticleTop')->post('/article/setArticleTop', [\W7\App\Controller\Admin\ArticleController::class, 'setArticleTop']);//delArticleList
        $route->name('route-delArticleList')->post('/article/delArticleList', [\W7\App\Controller\Admin\ArticleController::class, 'delArticleList']);//setArticleItem
        $route->name('route-setArticleItem')->post('/article/setArticleItem', [\W7\App\Controller\Admin\ArticleController::class, 'setArticleItem']);//addArticleItem
        $route->name('route-addArticleItem')->post('/article/addArticleItem', [\W7\App\Controller\Admin\ArticleController::class, 'addArticleItem']);

        //消息
        $route->name('route-getMessageUserList')->post('/message/getMessageUserList', [\W7\App\Controller\Admin\MessageController::class, 'getMessageUserList']);
        $route->name('route-setMessageUserRead')->post('/message/setMessageUserRead', [\W7\App\Controller\Admin\MessageController::class, 'setMessageUserRead']);
        $route->name('route-setMessageUserAllRead')->post('/message/setMessageUserAllRead', [\W7\App\Controller\Admin\MessageController::class, 'setMessageUserAllRead']);
        $route->name('route-delMessageUserList')->post('/message/delMessageUserList', [\W7\App\Controller\Admin\MessageController::class, 'delMessageUserList']);
        $route->name('route-delMessageUserAll')->post('/message/delMessageUserAll', [\W7\App\Controller\Admin\MessageController::class, 'delMessageUserAll']);//addMessageItem
        $route->name('route-addMessageItem')->post('/message/addMessageItem', [\W7\App\Controller\Admin\MessageController::class, 'addMessageItem']);
        $route->name('route-getMessageList')->post('/message/getMessageList', [\W7\App\Controller\Admin\MessageController::class, 'getMessageList']);//getMessageItem
        $route->name('route-getMessageItem')->post('/message/getMessageItem', [\W7\App\Controller\Admin\MessageController::class, 'getMessageItem']);//setMessageItem
        $route->name('route-setMessageItem')->post('/message/setMessageItem', [\W7\App\Controller\Admin\MessageController::class, 'setMessageItem']);
        $route->name('route-delMessageList')->post('/message/delMessageList', [\W7\App\Controller\Admin\MessageController::class, 'delMessageList']);
        $route->name('route-setMessageStatus')->post('/message/setMessageStatus', [\W7\App\Controller\Admin\MessageController::class, 'setMessageStatus']);//getMessageUserItem
        $route->name('route-getMessageUserItem')->post('/message/getMessageUserItem', [\W7\App\Controller\Admin\MessageController::class, 'getMessageUserItem']);

        //清缓存
        $route->name('route-clearCacheAll')->post('/index/clearCacheAll', [\W7\App\Controller\Admin\IndexController::class, 'clearCacheAll']);
        //图片列表
        $route->name('route-imgList')->post('/storage/imgList', [\W7\App\Controller\Admin\StorageController::class, 'imgList']);
        $route->name('route-delImg')->post('/storage/delImg', [\W7\App\Controller\Admin\StorageController::class, 'delImg']);


    });
