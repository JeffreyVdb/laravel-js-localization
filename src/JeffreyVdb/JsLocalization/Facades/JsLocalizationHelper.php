<?php
namespace JeffreyVdb\JsLocalization\Facades;

use Illuminate\Support\Facades\Facade;

class JsLocalizationHelper extends Facade
{
    protected static function getFacadeAccessor() {
        return 'JsLocalizationHelper';
    }
}