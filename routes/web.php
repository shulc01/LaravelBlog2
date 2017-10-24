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

Route::group(['prefix' => 'admin'], function()
{

    Route::get('/', 'AdminController@showAdmin')->name('Admin');

    Route::get('new-article', 'AdminController@createArticle')->name('CreateArticle');

    Route::post('new-article', 'AdminController@storeArticle')->name('StoreArticle');

    Route::get('edit/article/{id}', 'AdminController@editArticle')->name('EditArticle');

    Route::get('edit/deleteImage/{imid}/{id}', 'AdminController@deleteImagesArticle')->name('DeleteImagesArticle');

    Route::get('edit/deleteMainFoto/{imid}/{id}', 'AdminController@deleteMainFotoArticle')->name('DeleteMainFotoArticle');

    Route::post('edit', 'AdminController@updateArticle')->name('UpdateArticle');

    Route::get('new-category', 'AdminController@createCategory')->name('CreateCategory');

    Route::post('new-category', 'AdminController@saveCategory')->name('SaveCategory');

    Route::delete('/{id}', 'AdminController@deleteArticle')->name('DeleteArticle');

});

Route::get('articles', 'FrontController@showAllArticles')->name('ShowAllArticles');

Route::get('article/{id}', 'FrontController@showArticle')->name('ShowArticle');

Route::get('categories', 'FrontController@showAllCategories')->name('ShowAllCategories');

Route::get('category/{id}', 'FrontController@showArticlesFromCategory')->name('ShowArticlesFromCategory');

Route::get('tags/{id}', 'FrontController@showArticleWithTags')->name('ShowArticleWithTags');

Route::delete('categories/{id}', 'FrontController@deleteCategory')->name('DeleteCategory');


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
