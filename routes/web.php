<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Pages;
// use DB;
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

Route::get("/", "PagesController@index");
// Route::post("/test", "PagesController@tst");

// Route::get("/test", function (Request $request){
//     $uri = $request->upload;
//     $posts = DB::select("SELECT * FROM postcodes WHERE 'upload'='{$uri}'");
//     $pos = Storage::get($uri);
//     return view("pages.test")->with("uri", $pos);

// });
Route::get("/create", "PagesController@create");

Route::post("/create", "PagesController@parseFile");



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::match(['get', "post"],'/hello', function () {
//     return "numberwang";
// });

Route::resource('pages', "PagesController");

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
