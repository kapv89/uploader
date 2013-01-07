This bundle sets up a convention for uploads so that they are handled in a standardized manner
and are capable of dealing with different storage systems.

This bundle also comes with a Locator which basically allows you to locate your uploaded resources in different
storage systems.

Usage:

Uploader needs an array of $fields which it looks for and uploads.
The format of $fields array is given below:

	[
		$field => [$type, $alias],
		$another_field => [$f_type, $f_alias]
	]

once you have the $fields array, and the driver you want to use run the uploader like this:

	$files = Uploader::driver($driver)->run();

	/**
	* This method returns an array of the form
	* [
	*	'alias' => 'resource_for_uploaded_field'
	* ]
	* 
	* You can then just use the returned array to save the location to your uploaded assets.
	* Or you can do
	*/

	files = Uploader::driver($driver)->run();

	/**
	* In order to attach the uploaded files to current request's input, just replace run with attach
	*/

	Uploader::driver($driver)->attach();

	/**If you have a default driver set in config, you can just do**/

	Uploader::fields($fields)->run();


The uploader looks at Input::file() to check if $field has been updloaded. If it is, the Upload driver
uploads the file to 'storage/temp'. It then calls the handler for $type, which processes the uploaded file, 
stores the processed files in 'storage/temp', and returns the array of all the files generated while processing.

This array of files is then provided to the upload driver, which uses it to store the files in its corresponding
storage system.

Locator usage:

Locator::aws()->locate($resource)->format($whatever)->url();