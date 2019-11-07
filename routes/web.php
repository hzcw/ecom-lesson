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

Route::get('/',[
    'uses'=>'FrontendController@getWelcome',
    'as'=>'/'

]);
Route::get('/descrease/cart/{id}',[
   'uses'=>'FrontendController@getDecrease',
    'as'=>'decrease.cart'
]);

Route::get('/increase/cart/{id}',[
   'uses'=>'FrontendController@getIncrease',
   'as'=>'increase.cart'
]);
Route::get('/post-image/{file_name}',[
   'uses'=>'FrontendController@getImage',
   'as'=>'image'
]);
Route::get('/category/id/{cat_id}/posts',[
   'uses'=>'FrontendController@getPostsByCategory',
   'as'=>'posts.by.category'
]);
Route::get('/search/posts',[
   'uses'=>'FrontendController@getSearchPost',
   'as'=>'search.posts'
]);
Route::get('/add/to/cart/{id}',[
    'uses'=>'FrontendController@addToCart',
    'as'=>'add.to.cart'
]);
Route::get('/shopping/cart/',[
    'uses'=>'FrontendController@getShoppingCart',
    'as'=>'shopping.cart'

    ]);
Auth::routes();

Route::group(['prefix'=>'user','middleware'=>'auth'],function (){
    Route::get('/dashboard', [
        'uses'=>'HomeController@index',
        'as'=>'dashboard'
    ]);
    Route::post('/checkout',[
       'uses'=>'FrontendController@getCheckout',
       'as'=>'checkout'
    ]);

});

Route::group(['prefix'=>'post','middleware'=>'role:Admin'],function (){
    Route::get('/deliver/{id}',[
       'uses'=>'OrderController@getDeliver',
       'as'=>'deliver'
    ]);
    Route::get('/filer/by/date',[
        'uses'=>'OrderController@getOrders',
        'as'=>'filer_by_date'
    ]);
    Route::get('/filer/by/month',[
        'uses'=>'OrderController@getOrders',
        'as'=>'filer_by_month'
    ]);
   Route::get('/categories',[
       'uses'=>'PostController@getCategories',
       'as'=>'post.categories'
   ]) ;
   Route::post('/new/category',[
       'uses'=>'PostController@newPostCategories',
       'as'=>'new.category'
   ]);
   Route::get('/delete/category/id/{id}',[

       'uses'=>'PostController@getDeleteCategory',
       'as'=>'delete.category'

   ]);
   Route::post('/update/category',[
       'uses'=>'PostController@postUpdateCategory',
       'as'=>'update.category'
   ]);
   Route::get('/all',[
       'uses'=>'PostController@getPosts',
       'as'=>'posts'
   ]);
   Route::get('/new/post',[
      'uses'=>'PostController@newPost',
      'as'=>'post.new'
   ]);
   Route::post('/add/post',[
        'uses'=>'PostController@postNewPost',
       'as'=>'post.add'
   ]);
   Route::get('/posts-image,{file_name}',[
      'uses'=>'PostController@getImage',
      'as'=>'posts.image'
   ]);
   Route::get('/drop/post/{id}',[
      'uses'=>'PostController@getDropPost',
       'as'=>'post.drop'
   ]);
   Route::get('/post/id/{id}/edit',[
      'uses'=>'PostController@getEditPost',
      'as'=>'edit.post'
   ]);
   Route::post('/post/update',[
       'uses'=>'PostController@getUpdatePost',
       'as'=>'update.post'
   ]);
   Route::get('/search/post',[
      'uses'=>'PostController@getSearchPost',
      'as'=>'search.post'
   ]);

});

Route::group(['prefix'=>'admin','middleware'=>'role:Admin'],function (){
   Route::get('/users',[
       'uses'=>'UserController@getUsers',
       'as'=>'users'
   ]) ;
   Route::post('/assign/user/role',[
      'uses'=>'UserController@postAssignUserRole',
      'as'=>'assign.user.role'
   ]);
   Route::get('/delete/user/{id}',[
      'uses'=>'UserController@getDeleteUser',
      'as'=>'user.drop'
   ]);
    Route::post('/update/user',[
        'uses'=>'UserController@getUpdateUser',
        'as'=>'update.user'
    ]);
    Route::get('/orders',[
       'uses'=>'OrderController@getOrders',
       'as'=>'orders'
    ]);

});


