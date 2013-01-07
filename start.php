<?php

Autoloader::namespaces([
	'Uploader' => Bundle::path('uploader') . 'src'
]);

Autoloader::alias('Uploader\\Uploader', 'Uploader');
Autoloader::alias('Uploader\\Locator', 'Locator');