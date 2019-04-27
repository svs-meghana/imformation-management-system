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

Route::get('/newRequest', function () {
    return view('newRequest');
});
Route::post('/selectMails','imscontroller_1@selectMails');
Route::post('/addEmps','imscontroller_1@addEmps');
Route::post('/addAlertMails','imscontroller_1@addAlertMails');

Route::get('/track','track@track');

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login','login');
Route::post('/verifylogin','imscontroller_2@verifylogin');
Route::get('/home','imscontroller_2@home1');

Route::get('/responses','imscontroller_2@responses');

Route::post('/view_files','imscontroller_2@view_files');

Route::get('/refresh','imscontroller_2@mail_sent');

Route::get('/history','imscontroller_1@history');

Route::post('/download_files','imscontroller_2@download_files');

Route::get('/updateseen','imscontroller_1@update');

Route::get('/statistics','imscontroller_2@statistics');

Route::get('/profile','imscontroller_2@profile');

Route::get('/logout','imscontroller_2@logout');
