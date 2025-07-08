<?php
//\Core\SModulesController::setMiddleWare('*', function () {
//
//    if(empty($_SESSION['user_id']) && true === \Core\SRoute::$CURRENT_ROUTE['is_auth']) {
//        switch(strtolower(\Core\SRoute::$CURRENT_ROUTE['method']))
//        {
//            case 'post':
//                \Core\SModulesController::showJson(
//                    \Core\SModulesController::buildError(
//                        [
//                            'message' => [\Diversen\Lang::t('No session. (AuthIndex1000)')],
//                        ])
//                );
//                break;
//            default:
//                \Core\SRoute::redirect('/auth' . '?request=' . urlencode($_SERVER['REQUEST_URI']));
//
//        }
//    }
//});

