<?php

namespace Uploader;

use Exception;
use Config;

class LocatorException extends Exception { }

class Locator
{
	protected $_upload_driver = null;
	protected $_prefix = null;
	protected $_resource = null;

	protected static $_drivers = [];

	public static function driver($slug)
	{
		if(@static::$_drivers[$slug])
			return @static::$_drivers[$slug];

		return static::$_drivers[$slug] = new static($slug);
	}

	public function __construct($slug = null)
	{
		if($slug === null)
		{
			$slug = Config::get('uploader::settings.default_driver');
			$class = Config::get('uploader::settings.drivers.'.$slug.'.class');
			$this->_upload_driver = new $class($slug);
		}
		else
		{
			$class = Config::get('uploader::settings.drivers.'.$slug.'.class');
			$this->_upload_driver = new $class($slug);
		}
	}

	public function locate($name)
	{
		$this->_resource = $name;
		return $this;
	}

	public function format($format)
	{
		$this->_prefix = $format;
		return $this;
	}

	public function path()
	{
		if($this->_upload_driver->name() === 'aws')
			throw new LocatorException('Invalid Path attempt');

		$dir = $this->_upload_driver->setting('upload_dir');
		$file = $this->_prefix === null ? $this->_resource : $this->_prefix.'-'.$this->_resource;

		return $dir . $file;
	}

	public function url()
	{
		$base_url = $this->_upload_driver->setting('base_url');
		$file = $this->_prefix === null ? $this->_resource : $this->_prefix.'-'.$this->_resource;

		return $base_url . $file;
	}

	public static function __callStatic($func, $args)
	{
		if( in_array($func, array_keys(Config::get('uploader::settings.drivers'))) )
			return static::driver($func);
	}
}