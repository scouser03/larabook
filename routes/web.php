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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return auth::user()->test();
});

Auth::routes();

Route::group(['middleware' => 'auth'], function (){
	#home view
	Route::get('/home', 'HomeController@index')->name('home');
	#profile view by slug
	Route::get('/profile/{slug}', 'ProfileController@index');
	#profile photo change view
	Route::view('/profile/photo/change', 'profile/pic')->name('profilePhoto');
	#upload profile image
	Route::post('/upload/profile/image','ProfileController@uploadImage')->name('uploadImage');

	#edit profile view with auth user data 
	Route::get('/edit/profile', function () {
	    return view('profile/editProfile')->with('data', Auth::user()->profile);
	});	

	#update profile data 
	Route::post('/updateProfile','ProfileController@updateProfile');

	#find friends 
	Route::get('/find-friends','ProfileController@findFriends');

	#add friend function 
	Route::get('/addFriend/{id}', 'ProfileController@sendFriend');

	#see  requests
	Route::get('/requests', 'ProfileController@requests');

	#accept friend request
	Route::get('/accept/{name}/{id}', 'ProfileController@accept');

	#friends 
	Route::get('/friends', 'ProfileController@friends');

	#Remove users for my request list
	Route::get('/remove/accept/{id}', 'ProfileController@removeAccept');

	#notifications view with id 
	Route::get('/notifications/{id}', 'ProfileController@notifications');
	
});

