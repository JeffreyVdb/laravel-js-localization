<?php
namespace JeffreyVdb\JsLocalization\Facades;

use Illuminate\Support\Facades\Facade;

class CachingService extends Facade
{
    protected static function getFacadeAccessor() {
        return 'JsLocalizationCachingService';
    }
}