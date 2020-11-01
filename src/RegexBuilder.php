<?php

namespace DarshPhpDev\EasyRegex;

class RegexBuilder{

	public static function resolveFacade()
	{
		return app()->make('easy_regex');
	}

	public static function __callStatic($method, $arguments)
	{
		return $arguments == [] ? (self::resolveFacade())->make() : 
								(self::resolveFacade())->make(implode(',', $arguments));
	}
}
