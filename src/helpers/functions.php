<?php

if (! function_exists('setOptionsArray')) {

	/**
	 * regex helper function, can be used any where
	 *
	 * @return EasyRegex instance
	 */
	function regex()
	{
	    return app()->make('easy_regex');
	}
}