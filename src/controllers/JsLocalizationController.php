<?php

use JeffreyVdb\JsLocalization\Facades\CachingService;

class JsLocalizationController extends Controller
{
    
    public function createJsMessages ($section)
    {
        $contents  = 'Lang.setLocale("'.Lang::locale().'");';
        $messages = CachingService::getMessagesJson($section);
        $contents .= 'Lang.addMessages('.$messages.');';
        
        $lastModified = new DateTime();
        $lastModified->setTimestamp(CachingService::getLastRefreshTimestamp($section));

        return Response::make($contents)
                ->header('Content-Type', 'text/javascript')
                ->header('Last-Modified', $lastModified->format('D, d M Y H:i:s T'));
    }

}