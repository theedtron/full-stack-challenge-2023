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

use App\Mail\PGPMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
	return view('default');
});

Auth::routes();

Route::get('/home', 'ReferralController@index')->name('home');

//Routes for Posts
Route::get('posts', 'PostsController@index');
Route::post('posts', 'PostsController@store');
Route::get('posts/create', 'PostsController@create');
Route::get('posts/{post}', 'PostsController@show');

//Routes for Referrals
Route::get('referrals/upload', 'ReferralController@upload')->middleware('role:admin,supervisor');
Route::post('referrals/upload', 'ReferralController@processUpload');
Route::get('referrals/create', 'ReferralController@create')->name('add-referral')->middleware('role:admin,supervisor');
Route::get('referrals', 'ReferralController@index');
Route::post('referrals', 'ReferralController@store');

//Logged in Users
Route::get('my-posts', 'AuthorsController@posts')->name('my-posts');

//Routes for Authors
Route::get('authors', 'AuthorsController@index');
Route::get('authors/{author}', 'AuthorsController@show');

Route::middleware('role:admin')->prefix('users')->group( function () {
	Route::get('/', 'UserController@index');
	Route::get('create', 'UserController@create');
	Route::post('post', 'UserController@post');
	Route::get('delete/{id}', 'UserController@delete');
	Route::get('ban/{id}', 'UserController@ban');
	Route::get('unban/{id}', 'UserController@unban');
});

Route::middleware('role:admin,executive')->prefix('comments')->group( function () {
	Route::get('/', 'CommentController@index');
	Route::get('referral/{referral_id}', 'CommentController@referralComments');
	Route::get('create/{referral_id}', 'CommentController@create');
	Route::post('post', 'CommentController@post');
	Route::get('delete/{id}', 'CommentController@delete');
});

Route::get('send/mail', function(){
	$name = 'Cecile';
	$message = 'I am available to interview on Monday 30th October at 2pm GMT+3';
	$mail = new PGPMail($name,$message);
	Mail::send($mail);
});

Route::get('test/encrypt', function(){
	$message = 'I am available to interview on Monday at 2pm GMT+3';
	$gpg = new GPG();
    $key = new GPG_Public_Key(file_get_contents(storage_path('resultpubkey.asc')));
    $data = $gpg->encrypt($key,$message);

	$filename = storage_path('result-'.Carbon::now()->toDateTimeString().'.asc');  // Name of the new file

	// Create and open the file for writing (use 'w' for write mode)
	$file = fopen($filename, 'w');

	if ($file) {
		// Write data to the file
		fwrite($file, $data);

		// Close the file to save changes
		fclose($file);

		$res = "File '$filename' has been created and written to.";
	} else {
		$res = "Unable to create or open the file.";
	}
	return $res;
});

Route::get('test/sign', function(){
	
    // Set the path to your private key and passphrase
    $passphrase = env('GPG_PASSPHRASE');
	$message = 'This is my awesome signed message again';
	$user_id = env('GPG_USER_ID');

    // Use shell_exec to sign the message
    $command = "echo '$message' | gpg --armor --sign --local-user '$user_id' --pinentry-mode loopback --passphrase '$passphrase'";
    $signedMessage = shell_exec($command);

	$filename = storage_path('result-'.Carbon::now()->toDateTimeString().'.asc');  // Name of the new file

	// Create and open the file for writing (use 'w' for write mode)
	$file = fopen($filename, 'w');

	// Write data to the file
	fwrite($file, $signedMessage);

	// Close the file to save changes
	fclose($file);

    return $signedMessage;
    
});