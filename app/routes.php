<?php

// Welcome Page

Route::get('/','HomeController@showWelcome');


// Login Process

Route::get('login',[
	'as'	=>	'login',
	'uses'	=>	'UserController@login'
]);

// Yoda Page

Route::get('yoda',[
	'as'	=>	'yoda',
	'uses'	=>	'YodaController@view'
]);

// Logout

Route::get('logout',[
	'as'	=>	'logout',
	'uses'	=>	'UserController@logout'
]);



// Post Comment

Route::post('comment/add',[
	'as'	=>	'addComment',
	'uses'	=>	'CommentController@add'
]);


// Like

Route::get('comment/{id}/like/add',[
	'as'	=>	'addLike',
	'uses'	=>	'CommentController@addLike'
]);

Route::get('comment/{id}/like/remove',[
	'as'	=>	'removeLike',
	'uses'	=>	'CommentController@removeLike'
]);

// Dislike

Route::get('comment/{id}/dislike/add',[
	'as'	=>	'addDislike',
	'uses'	=>	'CommentController@addDislike'
]);

Route::get('comment/{id}/dislike/remove',[
	'as'	=>	'removeDislike',
	'uses'	=>	'CommentController@removeDislike'
]);