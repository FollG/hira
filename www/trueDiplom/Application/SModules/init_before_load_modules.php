<?php
self::$Session = new \Models\SSession();
self::$Session->setSession(\Models\SSession::isAuth(), ['is_auth']);


if(\Models\SSession::isAuth()) {
    self::$Session->setSession($_SESSION + [
            'is_auth' => (\Models\SSession::isAuth()),
            'user_id' => $_SESSION['user'],
        ]);
}