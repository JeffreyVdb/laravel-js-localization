<?php

namespace JeffreyVdb\JsLocalization;

use JeffreyVdb\JsLocalization\Facades\CachingService;
use Lang;

class Output
{
	protected $section;

	public function __construct()
	{
		$this->section = 'default';
	}

	public function forSection($section)
	{
		$this->section = $section;
		return $this;
	}

	public function inlineScript()
	{
		echo '<script type="text/javascript">';
		echo $this->getScriptContents();
		echo '</script>';
	}

	private function getScriptContents()
	{
        $contents  = 'Lang.setLocale("'.Lang::locale().'");';
        $messages = CachingService::getMessagesJson($this->section);
        $contents .= 'Lang.addMessages('.$messages.');';
		return $contents;
	}
}