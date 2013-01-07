<?php

namespace Uploader;

use Config, BadMethodCallException, File, Input;

class Field
{
	protected $_name = null;
	protected $_type = null;
	protected $_alias = null;
	protected $_fname = null;
	protected $_upload_name = null;

	public function __construct($name, $type, $alias)
	{
		$this->_name = $name;
		$this->_type = $type;
		$this->_alias = $alias;
		$this->_fname = Input::file($this->_name.'.name');
		$this->_upload_name = $this->random_name();
	}

	protected function random_name()
	{
		$ext = File::extension($this->_fname);
		
		return md5($this->_fname . microtime(true)) . '.' . $ext;
	}

	protected function settings()
	{
		return Config::get('uploader::settings.field_types.'.$this->_type);
	}

	public function setting($slug)
	{
		return Config::get('uploader::settings.field_types.'.$this->_type.'.'.$slug);
	}

	public  function handler()
	{
		$class = array_get($this->settings(), 'handler');

		return new $class($this);
	}

	public function __get($prop)
	{
		if( in_array($prop, ['name', 'type', 'alias', 'upload_name']) )
			return $this->{'_'.$prop};
	}

	public function __call($method, $args)
	{
		if($method !== 'settings')
			throw new BadMethodCallException($method);

		$settings = $this->settings();
		unset($settings['handler']);
		return $settings;
	}
}