<?php

use JeffreyVdb\JsLocalization\CachingService;
use JeffreyVdb\JsLocalization\Helper;
use JeffreyVdb\JsLocalization\Output;

App::singleton('JsLocalizationHelper', function()
{
    return new Helper;
});

App::singleton('JsLocalizationCachingService', function()
{
    return new CachingService;
});

App::singleton('JsLocalizationOutput', function()
{
	return new Output;
});