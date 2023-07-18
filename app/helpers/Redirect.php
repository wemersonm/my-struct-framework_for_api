<?php

namespace app\helpers;

class Redirect
{
    public static function to(string $to){
        return header("Location:".$to);
        die;
    }
}
