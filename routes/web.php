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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('layouts.guest');
    });
});

 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'SettingsController@index');
Route::post('/settings', array(
    'as' => 'settings',
    'uses' => 'SettingsController@update'
));
Route::post('/delete/akun/{id}', 'SettingsController@delete');


// Posts
Route::get('/posts/list', 'PostsController@fetch');
Route::post('/posts/new', 'PostsController@create');
Route::post('/posts/delete', 'PostsController@delete');
Route::post('/posts/like', 'PostsController@like');
Route::post('/posts/likes', 'PostsController@likes');
Route::post('/posts/comment', 'PostsController@comment');
Route::post('/posts/comments/delete', 'PostsController@deleteComment');
Route::get('/post/{id}', 'PostsController@single');

// Search
Route::get('/search', 'HomeController@search');

//Grup

Route::get('/postgrups/list', 'GrupController@fetch');
Route::post('/postgrups/create', 'GrupController@save');
Route::post('/postgrups/new', 'GrupController@create');
Route::post('/postgrups/delete', 'GrupController@delete');
Route::post('/postgrups/like', 'GrupController@like');
Route::post('/postgrups/likes', 'GrupController@likes');
Route::post('/postgrups/comment', 'GrupController@comment');
Route::post('/postgrups/gabung', 'GrupController@gabung');
Route::post('/postgrups/comments/delete', 'GrupController@deleteComment');
Route::post('/postgrups/tambah/{id}', 'GrupController@tambah');
Route::get('/postgrup/{id}', 'GrupController@single');


//events
Route::get('/events', 'EventController@index');
Route::post('/events/create', 'EventController@save');
Route::post('/events/delete', 'EventController@delete');
Route::post('/events/comment', 'EventController@comment');
Route::post('/events/comments/delete', 'EventController@deleteComment');
Route::post('/events/like', 'EventController@like');
Route::post('/events/likes', 'EventController@likes');
// Groups
Route::get('/groups', 'GroupController@index');
Route::get('/group/{id}', 'GroupController@group');
Route::get('/group/diskusi/{id}', 'GroupController@group');
Route::get('/group/anggota/{id}', 'GroupController@group');
Route::get('/group/foto/{id}', 'GroupController@group');
Route::get('/group/pengaturan_group/{id}', 'GroupController@group');
Route::post('/group/edit/{id}', 'GroupController@edit');
Route::get('/group/{id}/stats', 'GroupController@stats');
Route::post('/group/new', 'GroupController@create');
Route::post('/group/delete', 'GroupController@delete');
Route::post('/group/like', 'GroupController@like');
Route::post('/group/likes', 'GroupController@likes');
Route::post('/group/comment', 'GroupController@comment');
Route::post('/group/comments/delete', 'GroupController@deleteComment');
Route::post('/group/delete/{id}', 'GroupController@deleteGrup');
Route::post('upload/cover_grup/{id}', 'GroupController@uploadCover');


// Follow
Route::post('/follow', 'FollowController@follow');
Route::get('/followers/pending', 'FollowController@pending');
Route::post('/follower/request', 'FollowController@followerRequest');
Route::post('/follower/denied', 'FollowController@followDenied');

// Relatives
Route::get('/relatives/pending', 'RelativesController@pending');
Route::post('/relative/delete', 'RelativesController@delete');
Route::post('/relative/request', 'RelativesController@relativeRequest');


// Nearby
Route::get('/nearby', 'NearbyController@index');

// Messages
Route::get('/direct-messages', 'MessagesController@index');
Route::get('/direct-messages/show/{id}', 'MessagesController@index');
Route::post('/direct-messages/chat', 'MessagesController@chat');
Route::post('/direct-messages/send', 'MessagesController@send');
Route::post('/direct-messages/new-messages', 'MessagesController@newMessages');
Route::post('/direct-messages/people-list', 'MessagesController@peopleList');
Route::post('/direct-messages/delete-chat', 'MessagesController@deleteChat');
Route::post('/direct-messages/delete-message', 'MessagesController@deleteMessage');
Route::post('/direct-messages/notifications', 'MessagesController@notifications');

// Find Location
Route::get('/find-my-location', 'FindLocationController@index');
Route::get('/save-my-location', 'FindLocationController@save');
Route::get('/save-my-location2', 'FindLocationController@save2');

// Profile
Route::get('/{username}', 'ProfileController@index');
Route::post('/{username}/upload/profile-photo', 'ProfileController@uploadProfilePhoto');
Route::post('/{username}/upload/cover', 'ProfileController@uploadCover');
Route::post('/{username}/save/information', 'ProfileController@saveInformation');
Route::get('/{username}/following', 'ProfileController@following');
Route::get('/{username}/followers', 'ProfileController@followers');
Route::post('/{username}/save/hobbies', 'ProfileController@saveHobbies');
Route::post('/{username}/save/relationship', 'ProfileController@saveRelationship');

