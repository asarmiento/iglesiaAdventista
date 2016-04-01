<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/




	'mailgun' => [
		'domain' => env('MAIL_USERNAME'),
		'secret' => env('MAIL_PASSWORD'),
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => 'your-ses-key',
		'secret' => 'your-ses-secret',
		'region' => 'ses-region',  // e.g. us-east-1
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

];
