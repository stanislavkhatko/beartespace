<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* List of used routes
confirm-email
subscription
search
login
home
auction
artwork
article
artist
contact-form
lead
page
language
currency
cart
checkout
address
about
rules
shipping
dashboard

 */

Route::group( [ 'middleware' => 'web' ], function () {

	Auth::routes();

	Route::get( 'confirm-email/activate/{token}', 'Auth\ConfirmEmailController@confirm' )->name( 'confirm-email.activate' );
	Route::get( 'confirm-email/verify', 'Auth\ConfirmEmailController@verify' )->name( 'confirm-email.verify' )->middleware( 'auth' );
	Route::get( 'confirm-email/resend', 'Auth\ConfirmEmailController@resend' )->name( 'confirm-email.resend' )->middleware( 'auth' );

	Route::get( 'subscription/update', 'SubscriptionController@updatePlan' )->name( 'subscription.update' )->middleware( 'auth' );
	Route::post( 'subscription/stripe', 'SubscriptionController@payWithStripe' )->name( 'subscription.stripe' )->middleware( 'auth' );

	// Search
	Route::get( 'search/{query?}', 'HomeController@search' )->name( 'search' );

	Route::group( [ 'prefix' => 'login' ], function () {
		//Social login route
		Route::get( 'facebook', 'SocialLogin@redirectFacebook' )->name( 'facebook-redirect' );
		Route::get( 'facebook-callback', 'SocialLogin@callbackFacebook' );

		Route::get( 'google', 'SocialLogin@redirectGoogle' )->name( 'google-redirect' );
		Route::get( 'google-callback', 'SocialLogin@callbackGoogle' );

		Route::get( 'twitter', 'SocialLogin@redirectTwitter' )->name( 'twitter-redirect' );
		Route::get( 'twitter-callback', 'SocialLogin@callbackTwitter' );
	} );


	Route::get( '/', 'HomeController@index' )->name( 'home' );
	Route::get( '/home', 'HomeController@index' );

	// Sell
	Route::get( '/sell', 'SellController@sell' );
//	Route::get( '/sell/profile-name/{usertype?}', 'SellController@profileName' )->name('sell.profile-name')->middleware('auth');
//	Route::post( '/sell/profile-name', 'SellController@postProfileName' )->middleware('auth');
//	Route::get( '/sell/profile', 'SellController@profile' )->middleware('auth', 'has-profile-name');
	Route::get( '/sell/profile/{sellerType}', 'SellController@profile' );
//	Route::get( '/sell/artwork', 'SellController@artworks' )->name('sell.artwork')->middleware(['auth', 'has-profile-name']);
//	Route::get( '/sell/artwork/{id}/edit', 'SellController@editArtwork' )->name('sell.artwork.edit')->middleware(['auth', 'has-profile-name']);
//	Route::get( '/sell/artwork/create', 'SellController@createArtwork' )->name('sell.artwork.create')->middleware(['auth', 'has-profile-name']);
	Route::get( '/sell/apply', 'SellController@apply' )->middleware(['auth', 'has-profile-name', 'has-seller-artworks']);

	// General routes
	Route::get( '/auction', 'AuctionController@index' )->name( 'auctions' );
	Route::get( '/auction/{id}', 'AuctionController@show' )->name( 'auction' );

	Route::get( '/artworks', 'ArtworkController@artworks' )->name( 'artworks' );
	Route::get( '/artworks/{id}/{slug?}', 'ArtworkController@artwork' )->name( 'artwork' );

	Route::get( '/people', 'UserController@people' )->name( 'people' );
	Route::get( '/people/{id}', 'UserController@person' )->name( 'person' );
	Route::get( '/people/{id}/{slug?}', 'UserController@user' )->name( 'user' );

	Route::get( '/articles', 'ArticleController@articles' )->name( 'articles' );
	Route::get( '/articles/{id}/{slug?}', 'ArticleController@article' )->name( 'article' );

	Route::get( '/selection/artist', 'HomeController@selectedArtists' )->name( 'selected-artists' );
	Route::get( '/selection/artwork', 'HomeController@selectedArtworks' )->name( 'selected-artworks' );

	// Contact us page
	Route::get( 'contact-form', 'HomeController@contactForm' )->name( 'contact-form' );
	Route::post( 'contact-form', 'HomeController@contactFormPost' )->name( 'contact-form' );

	// Leads
	Route::post( 'lead/add-lead', 'LeadController@addLead' )->name( 'add-lead' );

	// Page
//	Route::get( 'page/{slug}', 'PageController@show' )->name( 'page' );
	Route::get( 'pages/{id}/{slug?}', 'PageController@page' )->name( 'page' );

	Route::get( 'language/{lang}', 'LanguageController@switchLang' )->name( 'switch-language' );
	Route::get( 'currency/{code}', 'CurrencyController@switchCurrency' )->name( 'switch-currency' );

	// Shopping Cart
	Route::get( 'cart', 'CartController@index' )->name( 'cart' );
	Route::get( 'cart/item/{id}/toggle', 'CartController@apiToggleCart' );
	Route::get( 'cart/item/{id}/buy-now', 'CartController@buyNow' )->name( 'cart.item.buy-now' );
	Route::post( 'cart/item/{id}/add', 'CartController@addItem' )->name( 'cart.item.add' );
	Route::get( 'cart/item/{id}/remove', 'CartController@removeItem' )->name( 'cart.item.remove' );

	// Shipping
	Route::get( 'cart/shipping', 'CartCheckoutController@shipping' )->middleware( ['auth','has-shopping-cart'] )->name( 'cart.shipping' );
	Route::post( 'cart/shipping/{id}', 'CartCheckoutController@setPrimaryShippingAddress' )->middleware( 'auth', 'has-shopping-cart' );

	// Cart Checkout
	Route::middleware( [ 'auth', 'has-shopping-cart', 'has-primary-address' ] )->group( function () {
//		Route::get( 'checkout/{transaction_id}', 'PaymentController@checkout' );
		Route::get('cart/payment', 'CartCheckoutController@payment')->name('cart.payment');
		Route::post( 'cart/payment', 'CartCheckoutController@savePaymentMethod' );
		Route::get( 'cart/checkout', 'CartCheckoutController@checkout' )->name( 'cart.checkout' )->middleware('has-payment-method');
		Route::post( 'cart/checkout', 'CartCheckoutController@postCheckout' )->middleware('has-payment-method');
	} );

	Route::get('cart/checkout/success', 'CartCheckoutController@checkoutSuccess')->name('cart.checkout.success')->middleware('auth');
	Route::get('cart/checkout/failure', 'CartCheckoutController@checkoutSuccess')->name('cart.checkout.failure')->middleware('auth');

	//Dashboard Route
	Route::group( [ 'prefix'     => 'dashboard', 'middleware' => [ 'auth', ] ], function () {
		// Not user (admin, sellers)
		Route::group( [ 'middleware' => ['seller'] ], function () {
			// Artworks
			Route::get( 'artworks', 'ArtworkController@index' )->name( 'dashboard.artworks' );
			Route::get( 'artworks/create', 'ArtworkController@create' )->name( 'dashboard.artworks.create' );
			Route::get( 'artworks/{id}/edit', 'ArtworkController@edit' )->name( 'dashboard.artworks.edit' );

			// Sales
			Route::get( 'sale/', 'SaleController@index' )->name( 'dashboard.sale' );
		} );

		// All users access
		Route::get( '/', 'DashboardController@dashboard' )->name( 'dashboard' );
		Route::get( 'profile', 'UserController@profile' )->name( 'dashboard.profile' );
		Route::post( 'change-password', 'UserController@changePasswordPost' )->name( 'dashboard.change-password' );
		Route::get( 'account', 'UserController@accountSettings')->name('dashboard.account');
		Route::get( 'orders', 'UserController@orders' )->name( 'dashboard.orders' );
		Route::get( 'favorites/{category?}', 'UserController@favoriteArtworks' )->name( 'dashboard.favorites' );

		// Admin only
		Route::group( [ 'middleware' => ['auth', 'admin'] ], function () {
			Route::get( 'payments', 'PaymentController@index' )->name( 'admin.payments' );

			Route::get( 'users', 'UserController@index' )->name( 'admin.users' );
			Route::get( 'users/{id}', 'UserController@show' )->name( 'admin.users.show' );
			Route::get( 'users/{id}/edit', 'UserController@edit' )->name( 'admin.users.edit' );
			Route::get( 'translations', 'TranslationController@index' )->name( 'admin.translations' );
			Route::get( 'languages', 'LanguageController@index' )->name( 'admin.languages' );

			Route::get( 'pages', 'PageController@index' )->name( 'admin.pages' );
			Route::get( 'pages/create', 'PageController@create' )->name( 'admin.pages.create' );
			Route::get( 'pages/{id}/edit', 'PageController@edit' )->name( 'admin.pages.edit' );

			Route::get( 'messages', 'MessageController@index' )->name( 'admin.messages' );
			Route::get( 'settings', 'SettingController@index' )->name( 'admin.settings' );

			Route::get( 'articles', 'ArticleController@index' )->name( 'admin.articles' );
			Route::get( 'articles/create', 'ArticleController@create' )->name( 'admin.articles.create' );
			Route::get( 'articles/{id}/edit', 'ArticleController@edit' )->name( 'admin.articles.edit' );
		} );

		Route::group( [ 'prefix' => 'u' ], function () {
			Route::group( [ 'prefix' => 'posts' ], function () {
				//bids
				Route::get( 'bids/{ad_id}', [ 'as' => 'auction_bids', 'uses' => 'BidController@index' ] );
				Route::post( 'bids/action', [ 'as' => 'bid_action', 'uses' => 'BidController@bidAction' ] );
				Route::get( 'bidder_info/{bid_id}', [ 'as' => 'bidder_info', 'uses' => 'BidController@bidderInfo' ] );
			} );
		} );

	} );

	// Test routes
	Route::get('/test/auth', 'TestController@testAuth');
	Route::get('/test/auth/view', 'TestController@testAuthView');

	// Global user profile search
	Route::get( '{id}/{profilename?}', 'UserController@seller' )->name( 'seller' );
	Route::get( '{user}/artworks', 'ArtworkController@userArtworks' )->name( 'user.artworks' );
	Route::get( '{user}/artworks/{id}/{slug?}', 'ArtworkController@userArtwork' )->name( 'user.artworks' );


} );

//Post bid
Route::post( '{id}/post-new', [ 'as' => 'post_bid', 'uses' => 'BidController@postBid' ] );


