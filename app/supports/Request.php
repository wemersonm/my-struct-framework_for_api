<?php

namespace app\supports;

class Request
{

    public static function all()
    {
        $requestMethods = ['PUT', 'DELETE', 'PATCH', 'OPTIONS'];
        if (in_array(self::getRequestMethod(), $requestMethods)) {
            return file_get_contents('php://input');
        }
        if (self::getContentType() == 'application/json') {
            return self::getRequestMethod() == 'POST' ? file_get_contents('php://input') : null;
        }
        return self::getRequestMethod() == 'GET' ? $_GET : (self::getRequestMethod() == "POST" ? $_POST : null);
    }
    public static function input(string $key)
    {
        if (self::getContentType() == 'application/json') {
            $data = self::json_decode(file_get_contents('php://input'));
            return $data[$key];
        }

        return isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : null);
    }
    public static function only(array $keys)
    {
        $data = self::all() ?? null;
        if ($data != null) {
            $dataKeys = array_keys($data);
            foreach ($dataKeys as $index => $key) {
                if (!in_array($key, $keys)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }
    public static function except(array $keys)
    {
        $allData = self::all();
        $allData = self::is_json($allData) != null ? self::json_decode($allData, true) : $allData;
        foreach ($keys as $key) {
            if (isset($allData[$key])) {
                unset($allData[$key]);
            }
        }
        return $allData;
    }
    public static function hasFile(string $file)
    {
        if (gettype(($_FILES[$file]['tmp_name'])) == 'array') {
            foreach ($_FILES[$file]['error'] as $error) {
                if ($error === UPLOAD_ERR_NO_FILE) {
                    return false;
                }
            }
            return true;
        } else {
            return isset($_FILES[$file]) && $_FILES[$file]['error'] !== UPLOAD_ERR_NO_FILE && $_FILES[$file]['error'] === UPLOAD_ERR_OK;
        }
    }
    public static function file(string $file)
    {
        return isset($_FILES[$file]) ? $_FILES[$file] : null;
    }
    private static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    private static function getContentType()
    {
        return isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : "";
    }
    public static function json_decode(string $json)
    {
        return json_decode($json, true);
    }
    private static function is_json(mixed $json)
    {
        if (!is_string($json)) {
            return false;
        }
        return json_decode($json) != null;
    }
}
