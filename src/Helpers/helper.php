<?php

use AbdurRahaman\RedxCourier\Redx;

if(!function_exists('redx')){
    function redx(): Redx{
        return app('redx-courier');
    }
}

if(!function_exists('ensureCountryCode')){
    function ensureCountryCode(string $number): string {       
        $number = ltrim($number, '+');
        return preg_match('/^88/', $number) ? $number : '88' . $number;
    }

}
