<?php

namespace DarshPhpDev\EasyRegex;

use Illuminate\Support\ServiceProvider;

class EasyRegexServiceProvider extends ServiceProvider{


	public function boot()
	{
		//
	}

	public function register()
	{
		app()->bind('easy_regex', function($app){
		    return new \DarshPhpDev\EasyRegex\EasyRegex();
		});
	}
}