<?php
Route::filter('role', function($route, $request, $value){  
    
    if(is_null(Auth::user())){
        $error[] = "You must be logged in";
        return Redirect::to( '/login' )->withErrors($error);
    }

    if(Auth::user()->id > 0 && Auth::user()->active == 0 ){
        $error[] = "User is inactive";
        return Redirect::to( '/login' )->withErrors($error);
    }

    switch ($value) {
        case "logged":
            if( Auth::user()->id < 1 ){
                $error[] = "You have to be logged in";
                $data["redirect_path"]    = Request::url();
                return Redirect::to('/')->withErrors($error);
            }
            break;
        case "admin":
            if( Auth::user()->is_admin <> 1 ){
                $error[] = "You have no permissions to access";
                return Redirect::to('/')->withErrors($error);
            }
            break;
    }
});

Route::get('/', 'WelcomeController@index');

Route::group(array('before'=>'auth|role:admin'), function(){  
    Route::get('/private-polls', 'QuestionController@privateQuestions');
    Route::get('/archived-polls', 'QuestionController@archivedQuestions');
    Route::get('/users/{id}/admin', 'UserController@admin');
    Route::get('/users/{id}/regular', 'UserController@regular');
    Route::get('/users/{id}/activate', 'UserController@activate');
    Route::get('/users/{id}/deactivate', 'UserController@deactivate');
    Route::resource('/users', 'UserController');
    Route::get('/profile/{email}', 'UserController@profile');
    Route::get('/poll/{id}/archive', 'QuestionController@archive');
    Route::get('/poll/{id}/activate', 'QuestionController@activate');
    Route::resource('/poll', 'QuestionController'); 
});

Route::group(array('before'=>'auth|role:logged'), function(){ 
	Route::get('/public-polls', 'QuestionController@publicQuestions');
	Route::get('/logout', 'Auth\AuthController@getLogout');
    Route::get('/polls/{slug}', 'QuestionController@show');
    Route::get('/unanswered', 'QuestionController@unanswered');
    Route::get('/answered', 'QuestionController@answered');
    Route::post('/vote/{id}', 'QuestionController@vote')->name('vote');
    Route::get('/poll/{id}', 'QuestionController@show'); 
});



Route::get('/auth/confirmation/{data}', 'UserController@emailConfirmation');

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');

Route::get('/join', 'Auth\AuthController@getRegister');
Route::post('/join', 'Auth\AuthController@postRegister');
