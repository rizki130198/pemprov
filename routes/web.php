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
Route::get('/userguide', 'HomeController@userguide');
Route::get('/settings', 'SettingsController@index');
Route::post('/settings', array(
    'as' => 'settings',
    'uses' => 'SettingsController@update'
));
Route::post('/delete/akun/{id}', 'SettingsController@delete');

// News
Route::get('/news', 'NewsController@index');
Route::post('/news/new', 'NewsController@create');
Route::get('/baca/{day}/{month}/{years}/{string?}', 'NewsController@singlenews')->where('string', '(.*)');
Route::post('/news/delete/', 'NewsController@deletenews');
Route::post('/news/edit/{id}', 'NewsController@editnews');
Route::post('/news/comment/{id}', 'NewsController@newscomment');
Route::post('/news/deletcomment', 'NewsController@newscommentdelete');
Route::post('/news/likenews/{id}', 'NewsController@likenews');
Route::post('/news/komentar/{id}', 'NewsController@komentar');
Route::post('/news/modal','NewsController@modal');
Route::post('/news/update','NewsController@update');

// Posts
Route::get('/posts/list', 'PostsController@fetch');
Route::post('/posts/new', 'PostsController@create');
Route::post('/posts/delete', 'PostsController@delete');
Route::post('/posts/like', 'PostsController@like');
Route::post('/posts/likes', 'PostsController@likes');
Route::post('/posts/comment', 'PostsController@comment');
Route::post('/posts/comments/delete', 'PostsController@deleteComment');
Route::get('/post/{id}', 'PostsController@single');
Route::Post('/post/modal', 'PostsController@modal');
Route::Post('/post/update', 'PostsController@updatepost');

// Search
Route::get('/search', 'HomeController@search');

//Grup
Route::get('/postgrups/list', 'GrupController@fetch');
Route::post('/postgrups/create', 'GrupController@save');
Route::post('/postgrups/new', 'GrupController@create');
Route::post('/postgrups/update', 'GrupController@updatepost');
Route::post('/postgrups/delete', 'GrupController@delete');
Route::post('/postgrups/like', 'GrupController@like');
Route::post('/postgrups/likes', 'GrupController@likes');
Route::post('/postgrups/comment', 'GrupController@comment');
Route::post('/postgrups/gabung', 'GrupController@gabung');
Route::post('/postgrups/comments/delete', 'GrupController@deleteComment');
Route::post('/postgrups/tambah/{id}', 'GrupController@tambah');
Route::get('/postgrup/{id}', 'GrupController@single');
Route::get('/group/diskusi/postgrup/{id}', 'GrupController@singlepost');

//pengguna
Route::get('/pengguna', 'PenggunaController@index');
Route::post('/pengguna/ubahjabatan', 'PenggunaController@Ubahjabatan');
Route::post('/pengguna/delete', 'PenggunaController@Deleteaccount');

//File
Route::get('/files', 'FilesController@index');
Route::get('/downloads/files/{string}', 'FilesController@Download');
Route::post('/files/uploadfile', 'FilesController@Uploadfile');
Route::post('/files/getFile', 'FilesController@GetFile');

//SPJ
Route::get('/spj', 'SpjController@index');
Route::get('/spj/formSpj', 'SpjController@formSpj');
Route::get('/spj/formVerifikasi/{id}', 'SpjController@formVerifikasi');
Route::get('/spj/print/{id}', 'SpjController@printSpj');
Route::post('/spj/action', 'SpjController@InputForm');
Route::post('/spj/ubah', 'SpjController@AccData');
Route::post('/spj/editsaldo', 'SpjController@UbahSaldo');
Route::post('/spj/ubahform', 'SpjController@UbahFormPengajuan');
Route::post('/spj/tolak', 'SpjController@TolakData');
Route::post('/spj/tolakverif', 'SpjController@Tolakverif');
Route::post('/spj/updateform', 'SpjController@ActionVerif');
Route::post('/spj/Uploadimage', 'SpjController@uploadimage');
Route::post('/spj/kurangisaldo', 'SpjController@Accselesai');

//events
Route::get('/events', 'EventController@index');
Route::post('/events/create', 'EventController@save');
Route::post('/events/update', 'EventController@update');
Route::post('/events/delete', 'EventController@delete');
Route::post('/events/comment', 'EventController@comment');
Route::post('/events/comments/delete', 'EventController@deleteComment');
Route::post('/events/like', 'EventController@like');
Route::post('/events/likes', 'EventController@likes');
Route::get('/events/{id}', 'EventController@single');
Route::post('/events/modal', 'EventController@modals');

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
Route::post('/group/delete/member/{id}/{string}', 'GroupController@deleteMemberGrup');
Route::post('/group/delete/hapusadmin/{id}/{string}', 'GroupController@deleteAdminGrup');
Route::post('/group/addadmin/{id}/{string}', 'GroupController@addAdmin');
Route::post('/group/leavegrup/{id}/{string}', 'GroupController@leaveGrup');
Route::post('/group/editpost/modal', 'GroupController@editpost');
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


Route::post('/notifications', 'HomeController@notifications');
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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
