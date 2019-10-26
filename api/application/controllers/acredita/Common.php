<?php
class Common {
    public static function not_empty($param) {
        return (null !== $param && $param != '');
    }
    public static function not_empty_values($params) {
        foreach ($params as $param) {
            if (!self::not_empty($param)) {
                return false;
            }
        }
        return true;
    }
    public static function basic_response($error, $msg) {
        $response = array (
            'error' => $error,
            'msg' => $msg
        );
        return $response;
    }
    public static function data_response($error, $msg, $head, $data) {
        $response = array (
            'error' => $error,
            'msg' => $msg,
            $head => $data
        );
        return $response;
    }
}