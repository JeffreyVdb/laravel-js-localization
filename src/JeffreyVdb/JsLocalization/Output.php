<?php

namespace JeffreyVdb\JsLocalization;

use JeffreyVdb\JsLocalization\Facades\CachingService;
use Lang;

class Output
{
	protected $section;
    protected $app;

	public function __construct()
	{
		$this->section = 'default';
        $this->app = app('app');
	}

	public function forSection($section)
	{
		$this->section = $section;
		return $this;
	}

	public function inlineScript($withTags = true)
	{
        if ($withTags) {
            return "<script>{$this->getScriptContents()}</script>";
        }
        else {
            return $this->getScriptContents();
        }
	}

	private function getScriptContents()
	{
        $messages = CachingService::getMessagesJson($this->section);
        return 'Lang.setLocale("'. $this->app->getLocale() . '");Lang.addMessages('.$messages.');';
	}
}