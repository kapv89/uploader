<?php

namespace Uploader\Handler;

use Resizer;

class Image extends Base
{
	public function process_uploaded_file()
	{
		$path = $this->move_uploaded_file();


		$result = [];

		$default_size = $this->field()->setting('default_format');
		list($x, $y, $mode) = $this->field()->setting('formats.'.$default_size);
		Resizer::open($path)->resize($x, $y, $mode)->save($path);

		$result[] = $path;

		foreach($this->field()->setting('formats') as $name => $setting)
		{
			if($name === $default_size)
				continue;

			$save_path = $this->temp_dir() . $name . '-' . $this->field()->upload_name;

			list($x, $y, $mode) = $setting;
			Resizer::open($path)->resize($x, $y, $mode)->save($save_path);
			$result[] = $save_path;
		}

		return $result;
	}
}