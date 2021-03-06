<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
		\App\Http\Middleware\TrimStrings::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			// \Illuminate\Session\Middleware\AuthenticateSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,

			//Specific Middleware
			\App\Http\Middleware\SetApplicationLanguage::class,
			\App\Http\Middleware\SetCurrency::class,
			\Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
		],

		'api' => [
//			\App\Http\Middleware\EncryptCookies::class,
//			\Illuminate\Session\Middleware\StartSession::class,
//			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			'throttle:60,1',
			'bindings',
		],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'                  => \Illuminate\Auth\Middleware\Authenticate::class,
		'auth.basic'            => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings'              => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'can'                   => \Illuminate\Auth\Middleware\Authorize::class,
		'guest'                 => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle'              => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'confirmed-email'       => \App\Http\Middleware\ConfirmedEmail::class,
		'admin'                 => \App\Http\Middleware\OnlyAdminAccess::class,

		// Sell
		'seller'                => \App\Http\Middleware\Seller::class,
		'has-profile-name'      => \App\Http\Middleware\HasProfileName::class,
		'has-completed-profile' => \App\Http\Middleware\HasCompletedProfile::class,
		'has-seller-artworks'   => \App\Http\Middleware\HasSellerArtworks::class,

		// CartCheckout
		'has-primary-address'   => \App\Http\Middleware\HasPrimaryAddress::class,
		'has-payment-method'    => \App\Http\Middleware\HasPaymentMethod::class,
		'has-shopping-cart'     => \App\Http\Middleware\HasShoppingCart::class,

	];
}
