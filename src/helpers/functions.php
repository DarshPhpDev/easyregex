<?php

if (! function_exists('regexBuilder')) {

	/**
	 * regexBuilder helper function, can be used any where in laravel app
	 *
	 * @return EasyRegex instance
	 */
	function regexBuilder()
	{
	    return app()->make('easy_regex');
	}
}