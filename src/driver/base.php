<?php

namespace Uploader\Driver;

use Uploader\Field;

use Config, Input;

abstract class Base
{
	protected $_name = null;
	protected $_fields = [];
	protected $_fields_list = [];

	public function __construct($name)
	{
		$this->_name = $name;
	}

	public function name()
	{
		return $this->_name;
	}

	public function fields($fields)
	{
		$this->_fields_list = $fields;
		return $this;
	}

	public function field($name)
	{
		if(isset($this->_fields[$name]))
			return $this->_fields[$name];

		if(! array_key_exists($name, $this->_fields_list) )
			return null;

		list($type, $alias) = array_get($this->_fields_list, $name);
		
		return $this->_fields[$name] = new Field($name, $type, $alias);
	}

	public function setting($slug)
	{
		return Config::get('uploader::settings.drivers.'.$this->_name.'.'.$slug);
	}

	protected function get_fname_from_path($path)
	{
		$arr = explode(DS, $path);
		return end($arr);
	}

	protected function is_uploaded($name)
	{
		return Input::file($name.'.size') > 0;
	}

	public function run()
	{
		$result = [];

		foreach($this->_fields_list as $name => $field)
		{
			if(! $this->is_uploaded($name) )
				continue;

			$field = $this->field($name);
			
			$files = $field->handler()->process_uploaded_file();
			$this->store_uploaded_files($files);
			$result[$field->alias] = $field->upload_name;
		}
		return $result;
	}

	public function attach()
	{
		Input::merge($this->run());
	}

	abstract protected function store_uploaded_files($files);
}