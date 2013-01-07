<?php

return [
	'drivers' => [
		'aws' => [
			'class' => 'Uploader\\Driver\\Aws',
			'container' => 'musejam-files',
			'base_url' => AwsUploader::aws_url() . 'musejam-files/'
		],
		'laravel' => [
			'class' => 'Uploader\\Driver\\Laravel',
			'upload_dir' => path('public').'uploads'.DS,
			'base_url' => URL::base().'/uploads/',
		],
	],

	'default_driver' => 'laravel',

	'field_types' => [
		'image' => [
			'formats' => [
				'icon' 	  => [50,50, 'crop'],
				'thumb'   => [200, 200, 'crop'],
				'display' => [400, 250, 'auto'],
				'std'     => [700, 400, 'auto'],
			],

			'default_format' => 'std',

			'handler' => 'Uploader\\Handler\\Image'
		],

		'audio' => [
			'handler' => 'Uploader\\Handler\\Audio'
		]
	],

	'temp_dir' => path('storage').'temp'.DS
];