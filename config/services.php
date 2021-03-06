<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, SparkPost and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => env( 'MAILGUN_DOMAIN' ),
		'secret' => env( 'MAILGUN_SECRET' ),
	],

	'ses' => [
		'key'    => env( 'SES_KEY' ),
		'secret' => env( 'SES_SECRET' ),
		'region' => 'us-east-1',
	],

	'sparkpost' => [
		'secret' => env( 'SPARKPOST_SECRET' ),
	],

	'stripe' => [
		'model'  => App\User::class,
		'key'    => env( 'STRIPE_KEY' ),
		'secret' => env( 'STRIPE_SECRET' ),
	],

	'braintree' => [
		'model'  => App\User::class,
		'environment' => env('BRAINTREE_ENV'),
		'merchant_id' => env('BRAINTREE_MERCHANT_ID'),
		'public_key' => env('BRAINTREE_PUBLIC_KEY'),
		'private_key' => env('BRAINTREE_PRIVATE_KEY'),
	],

	'paypal' => [
		'key'    => env( 'PAYPAL_KEY' ),
		'secret' => env( 'PAYPAL_SECRET' )
	],

	'facebook' => [
		'client_id'     => env( 'FACEBOOK_CLIENT_ID' ),
		'client_secret' => env( 'FACEBOOK_CLIENT_SECRET' ),
		'redirect'      => env( 'APP_URL' ) . '/login/facebook-callback',
	],

	'google' => [
		'api_key'       => env( 'GOOGLE_API_KEY' ),
		'client_id'     => env( 'GOOGLE_CLIENT_ID' ),
		'client_secret' => env( 'GOOGLE_CLIENT_SECRET' ),
		'redirect'      => env( 'APP_URL' ) . '/login/google-callback',
	],
//
//	'twitter' => [
//		'client_id'     => env( 'TWITTER_CLIENT_ID' ),
//		'client_secret' => env( 'TWITTER_CLIENT_SECRET' ),
//		'redirect'      => url( 'login/twitter-callback' ),
//	]

];
