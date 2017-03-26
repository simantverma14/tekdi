<?php

if (!defined('_VALID_PHP'))
    die('Direct access to this location is not allowed.');

class security {

    public static $CSRF_token;

    public static function getCSRF_token() {
        return md5(session_id() . '-' . $_SERVER['REMOTE_ADDR'] . '-' . $_SERVER['HTTP_USER_AGENT']);
    }

    public static function checkCSRF_token($input_token) {
        if ((self::$CSRF_token != $input_token) || (strpos(@$_SERVER['HTTP_REFERER'], BASE_URL) !== 0)) {
            header('HTTP/1.0 400 Bad Request');
            die('400 Bad Request');
        }
    }

}

security::$CSRF_token = security::getCSRF_token();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !defined('PREVENT_CSRF_CHECK')) {
    security::checkCSRF_token(@(string) $_POST['CSRF_token']);
}
?>