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

Route::get('/', 'PagesController@index');
Route::get('/pages/{kost}', 'PagesController@show')->name('get.kost');
Route::get('/pages/{kost}/pesan', 'PagesController@pesan')->name('pesan.kost');
Route::post('/pages/{kost}/pesan', 'PagesController@storePesanan')->name('pesan.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/panel', 'UserPanelController@index');

Route::resource('/kost', 'KostController');
Route::get('/kost/addimg/{kost}', 'KostController@addImg')->name('create.img');
Route::post('/kost/saveimg', 'KostController@saveImg')->name('kost.saveimg');
Route::delete('kost/img/{kost}/{img}', 'KostController@destroyImg')->name('destroy.img');
Route::get('kost/gallery/{kost}', 'KostController@Gallery');
Route::get('kost/{kost}/harga', 'KostController@createHarga')->name('create.harga');
Route::post('kost/{kost}/harga', 'KostController@storeHarga')->name('store.harga');
Route::post('kost/{kost}/fasilitas', 'KostController@storeFasilitas')->name('store.fasilitaskost');

Route::resource('/fasilitas', 'FasilitasController');

// Admin
Route::get('/admin', 'AdminController@index');
Route::get('/admin/{user}/editUser', 'AdminController@editUser');
Route::put('/admin/{user}', 'AdminController@updateRole')->name('admin.updateRole');
Route::post('/admin/{user}', 'AdminController@updateUser')->name('updateUser');
Route::delete('/admin/{user}', 'AdminController@deleteUser')->name('admin.deleteUser');
Route::get('/admin/create/fasilitas', 'AdminController@createFasilitas')->name('create.fasilitas');
Route::post('/admin/store/fasilitas', 'AdminController@storeFasilitas')->name('fasilitasStore');
Route::delete('/admin/{fasilitas}/fasilitas', 'AdminController@deleteFasilitas')->name('delete.fasilitas');
Route::get('/admin/create/kecamatan', 'AdminController@createKecamatan')->name('create.kecamatan');
Route::post('/admin/store/kecamatan', 'AdminController@storeKecamatan')->name('store.kecamatan');
Route::delete('/admin/{kecamatan}/kecamatan', 'AdminController@destroyKecamatan')->name('destroy.kecamatan');
Route::get('/admin/{kecamatan}/kelurahan', 'AdminController@showKelurahan')->name('show.kecamatan');
Route::get('/admin/{kecamatan}/create/kelurahan', 'AdminController@createKelurahan')->name('create.kelurahan');
Route::post('/admin/{kecamatan}/store/kelurahan', 'AdminController@storeKelurahan')->name('store.kelurahan');
Route::delete('/admin/{kecamatan}/kelurahan', 'AdminController@destroyKelurahan')->name('destroy.kelurahan');
