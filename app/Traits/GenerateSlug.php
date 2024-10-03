<?php

namespace App\Traits;

trait GenerateSlug
{
    public function productSlug($str)
    {
        $str = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $str);  
        $str = preg_replace("/[\/_|+ -]+/", '-', $str);
        return strtolower($str);
    }
}
