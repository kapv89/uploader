<?php

namespace Uploader\Handler;

use Input;
use mp3file;

class Audio extends Base
{
	public function process_uploaded_file()
	{
		$fpath = $this->move_uploaded_file();

		$metadata = (new mp3file($fpath))->get_metadata();

		Input::merge(['duration' => @$metadata['Length']]);

		return [$fpath];
	}
}