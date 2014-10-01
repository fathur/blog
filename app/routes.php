<?php

/**
 * -------------------------
 * Extending Blade Template
 * -------------------------
 */

/**
 * In blade we write {? ... ?}
 * and will returning tag <?php ... ?>
 */
Blade::extend(function ($value)
{
	return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});*/
 
Route::resource('posts', 'PostsController');

Route::controller('auth', 'AuthenticationController');
