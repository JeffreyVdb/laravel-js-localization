<?php

use JeffreyVdb\JsLocalization\StaticFileResponse;

Route::get('/jslocalization/{section}/messages.js', 
	'JsLocalizationController@createJsMessages');