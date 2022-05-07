<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//read stories after authentication - routes
Route::middleware(['auth'])->group(function(){
    // Route::get('/stories', [App\Http\Controllers\StoriesController::class, 'index'])->name('stories.index');
    // Route::get('/stories/{story}', [App\Http\Controllers\StoriesController::class, 'show'])->name('stories.show');
    Route::resource('stories', 'App\Http\Controllers\StoriesController');

    //profile -routes
    Route::get('/edit-profile', 'App\Http\Controllers\ProfilesController@edit')->name('profiles.edit');
    Route::put('/edit-profile/{user}', 'App\Http\Controllers\ProfilesController@update')->name('profiles.update');
});

Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
Route::get('/story/{activeStory:slug}', 'App\Http\Controllers\DashboardController@show')->name('dashboard.show');

Route::get('/email', 'App\Http\Controllers\DashboardController@email')->name('dashboard.email');


//admin privilages routes
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->middleware(['auth', CheckAdmin::class])->group( function() {
    Route::get('/deleted_stories', 'StoriesController@index')->name('admin.stories.index');
    Route::put('/stories/restore/{id}', 'StoriesController@restore')->name('admin.stories.restore');
    Route::delete('/stories/delete/{id}', 'StoriesController@delete')->name('admin.stories.delete');

});


//image upload routes
Route::get('/image', function(){
    $imagePath = public_path('storage/image1.jpg');//access current image
    $writePath = public_path('storage/thumbnail.jpg'); //rename image and save it with different size

    $img = Image::make($imagePath)->resize(225, 100); // image resizing before save it as thumbnail - using intervention
    $img->save($writePath);//save thumbnail
    return $img->response('jpg');

});
