<?php

Route::get('', 'HomeController@index');
Route::post('postal', 'HomeController@validPostalCode');
Route::get('om-oss', function () {
    return view('page.about');
});
Route::get('sa-funkar-det','HomeController@howItWorks');
Route::get('melanders', ['uses' => 'HomeController@getBags']);
Route::get('ulla-winbladh', ['uses' => 'HomeController@getBags']);
Route::get('lidingosaluhall', ['uses' => 'HomeController@getBags']);
Route::get('villkor', 'HomeController@getConditions');
Route::get('veckomenyer', 'HomeController@getWeeklyBags');

// Handle subscription and user information
Route::get('mina-sidor', ['before' => 'auth', 'uses' => 'ProfileController@show']);
Route::post('mina-sidor', ['before' => 'auth', 'uses' => 'ProfileController@updateProfile']);
Route::get('mina-sidor/{any}', ['before' => 'auth', 'uses' => 'ProfileController@show']);
Route::post('mina-sidor/{page}', ['before' => 'auth', 'uses' => 'ProfileController@updateProfile']);

// Handles displaying and shopping extra products
Route::get('tillaggsprodukter', ['middleware' => 'auth', 'uses' => 'ProfileController@getProducts']);
Route::post('tillaggsprodukter/betala', ['middleware' => 'auth', 'uses' => 'PayexController@payExtraProducts']);
Route::post('tillaggsprodukter/summering', ['middleware' => 'auth', 'uses' => 'OrderController@getSummary']);

// User and admin pages
Route::get('logga-ut', 'UserController@doLogout');
Route::get('logga-in', function () {
    return view('auth.login');
});
Route::post('logga-in', ['uses' => 'UserController@doLogin']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Create customer pages
Route::post('bli-kund', 'OrderController@customerInformation');
Route::get('bli-kund', 'HomeController@getBags');
Route::get('bli-kund/betala', 'PayexController@createAgreement3');
Route::post('bli-kund/betala', 'OrderController@validateForm');
Route::get('bli-kund/complete', 'PayexController@complete');

/*********************************************
 *    CRON JOBS
 *********************************************/
Route::get('ZJeRDPwyqW', 'PayexController@subscriptionMultipleUsers');
Route::get('QEsHFchduk', 'BudbeeController@create');
Route::get('AEfkEsHFch', 'PayexController@clearPayedUsers');
Route::get('UMeRDPiyqW', 'PayexController@subscriptionTryAgainPayment');



//Route::get('test', 'PayexController@test');
