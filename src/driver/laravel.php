<?php

namespace Uploader\Driver;

use File;

class Laravel extends Base
{
	protected function upload_fpath($file)
	{
		return $this->setting('upload_dir') . $this->get_fname_from_path($file);
	}

	protected function store_uploaded_files($files)
	{
		$upload_dir = $this->setting('upload_dir');

		foreach($files as $file)
		{
			File::put($this->upload_fpath($file), File::get($file));
			unlink($file);
		}
	}
}