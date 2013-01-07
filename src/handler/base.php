<?php

namespace Uploader\Handler;
use Config, Input;

abstract class Base
{
	protected $_field = null;
	protected $_uploaded_file_path = null;
	
	public function __construct($field)
	{
		$this->_field = $field;
	}

	public function field()
	{
		return $this->_field;
	}

	public function temp_dir()
	{
		return Config::get('uploader::settings.temp_dir');
	}

	public function move_uploaded_file()
	{
		Input::upload($this->field()->name, $this->temp_dir(), $this->field()->upload_name);
		return $this->_uploaded_file_path = $this->temp_dir() . $this->field()->upload_name;
	}

	abstract public function process_uploaded_file();
}