<?php
@session_start();
$_SESSION['customer']['authValidated'] = false;
$_SESSION['customer'] = array();
unset($_COOKIE);
unset($_SESSION);

//http://durak.org/sean/pubs/software/php-5.4.6/function.session-destroy.html
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();
$_COOKIE = array();
$_SESSION = array();

session_unset();
session_write_close();
setcookie(session_name(), '', 0, '/');
session_regenerate_id(true);


header("Location: /login" . $random);