<?php

namespace Uploader;

use Config;

class Uploader
{
	public static function fields($fields)
	{
		return static::driver()->fields($fields);
	}

	public static function driver($slug = null)
	{
		if($slug === null)
		{
			$slug = Config::get('uploader::settings.default_driver');
			$class = Config::get('uploader::settings.drivers.'.$slug.'.class');
			return new $class($slug);
		}
		else
		{
			$class = Config::get('uploader::settings.drivers.'.$slug.'.class');
			return new $class($slug);
		}
	}
}