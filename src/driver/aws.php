<?php

namespace Uploader\Driver;

use AwsUploader;

class Aws extends Base
{
	protected function store_uploaded_files($files)
	{
		foreach($files as $file)
		{
			$fname = $this->get_fname_from_path($file);
			AwsUploader::upload_to($this->setting('container'), $file, $fname);
		}
	}
}
