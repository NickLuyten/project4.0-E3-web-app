<?php
/**
 * Created by PhpStorm.
 * User: Xiang
 * Date: 21/10/2019
 * Time: 15:10
 */

namespace App\Helpers;


class Json
{
    public function dump($data = null, $onlyInDebugMode = true)
    {
        $show = ($onlyInDebugMode === true && env('APP_DEBUG') === false) ? false : true;
        if (array_key_exists('json', app('request')->query()) && $show) {
            header('Content-Type: application/json');
            die(json_encode($data));
        }
    }
}