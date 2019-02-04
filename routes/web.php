<?php
//Route::get('/', function () {
//    return view('pages.main');
//})->middleware('auth');
//
//Route::get('/main', function (){
//    return view('pages.main');
//})->middleware('auth');


//Authentication
Route::get                              ('/login',                      'UsersController@authUser');
Route::post                             ('/login',                      'UsersController@authUser');

//Logout
Route::get                              ('/logout',                     'UsersController@logout');

Route::resource('cal', 'gCalendarController');
Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'gCalendarController@oauth']);
Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'users'], function(){
        //User Listing
        Route::get                      ('/list/{page?}/{async?}',                    'UsersController@index')->name('userList');
        Route::get                      ('/index',                                    'UsersController@indexJson');
    Route::get                      ('/validate/{type}/{data?}',                  'UsersController@customValidation');
        Route::get                      ('/json/{member_id}',                         'UsersController@userJson');
        Route::get                      ('/search/{query}',                           'UsersController@search');
        Route::get                      ('/listsearch/{page}/{query?}',         'UsersController@listSearch');
        //Registration
        Route::match    (['get','post'], '/register',                   'UsersController@registerUser');

        //Profile VIEWING
        Route::get                      ('/{member_id}',                'UsersController@profile');

        Route::match    (['get','post'], '/img/edit/{member_id}',       'UsersController@editImage');
        Route::get                      ('/img/get',                    'UsersController@getImage');
    });

    Route::group(['prefix' => 'bio'], function(){
        Route::get                      ('/{member_id?}',               'BiosController@showBioPage')->name('bioPage');
        Route::get                      ('/generate-pdf/{member_id}',   'BiosController@generatePdf')->name('BioPDF');

        Route::match    (['get','post'], '/notes/edit/{member_id}',     'BiosController@editNotes');
        Route::get                      ('/notes/get/{member_id}',                  'BiosController@getNotes');

        Route::match    (['get','post'], '/biography/edit/{member_id}', 'BiosController@editBio');
        Route::get                      ('/biography/get/{member_id}',              'BiosController@getBiography');

        Route::match    (['get','post'], '/base/edit/{member_id}',      'BiosController@editBase');
        Route::get                      ('/base/get/{member_id}',                   'BiosController@getBase');

        Route::match    (['get','post'], '/assoc/edit/{member_id}',     'BiosController@editAssoc');
        Route::get                      ('/assoc/get/{member_id}',                  'BiosController@getAssoc');

        Route::match    (['get','post'], '/family/edit/{member_id}',    'BiosController@editFamily');
        Route::get                      ('/family/get/{member_id}',                 'BiosController@getFamily');

        Route::match    (['get','post'], '/roles/edit/{member_id}',     'BiosController@setRoles');
        Route::get                      ('/roles/get/{member_id}',                  'BiosController@getRoles');
    });

    Route::group(['prefix' => 'workplace'], function(){
        Route::get                      ('/index/{member_id}',          'WorkplacesController@index');
        Route::post                     ('/store',                      'WorkplacesController@store');
        Route::get                      ('/add/{member_id}',            'WorkplacesController@add');
        Route::match    (['get','post'], '/edit/{id}',                  'WorkplacesController@edit');
        Route::match    (['get','post'], '/delete/{id}',                'WorkplacesController@delete');
    });

    Route::group(['prefix' => 'study'], function(){
        Route::get                      ('/index/{member_id}',          'StudiesController@index');
        Route::post                     ('/store',                      'StudiesController@store');
        Route::get                      ('/add/{member_id}',            'StudiesController@add');
        Route::match    (['get','post'], '/edit/{id}',                  'StudiesController@edit');
        Route::match    (['get','post'], '/delete/{id}',                'StudiesController@delete');
    });

    Route::group(['prefix' => 'residence'], function(){
        Route::get                      ('/index/{member_id}',          'ResidencesController@index');
        Route::post                     ('/store',                      'ResidencesController@store');
        Route::get                      ('/add/{member_id}',            'ResidencesController@add');
        Route::match    (['get','post'], '/edit/{id}',                  'ResidencesController@edit');
        Route::match    (['get','post'], '/delete/{id}',                'ResidencesController@delete');
    });
    Route::group(['prefix' => 'rolehistory'], function (){
        Route::get                      ('/index/{member_id}',          'RoleHistoryController@index');
        Route::post                     ('/store',                      'RoleHistoryController@store');
        Route::get                      ('/add/{member_id}',            'RoleHistoryController@add');
        Route::match    (['get','post'], '/edit/{id}',                  'RoleHistoryController@edit');
        Route::match    (['get','post'], '/delete/{id}',                'RoleHistoryController@delete');
        Route::match    (['get','post'], '/report/add/{id}',            'RoleHistoryController@editReport');
        Route::match    (['get','post'], '/report/delete/{id}',         'RoleHistoryController@deleteReport');
        Route::get                      ('/generate-pdf/{member_id}/{id}',   'RoleHistoryController@generatePdf')->name('RoleHistoryPDF');
        Route::match    (['get','post'], '/report/upload/{id}',         'RoleHistoryController@uploadFile');
    });
    Route::group(['prefix'  =>  'admin'], function (){

        Route::get                      ('/main',                       'AdministrationController@AdministrationPanel');
        Route::get                      ('/roles',                      'AdministrationController@RoleManager');
        Route::match    (['get','post'], '/roles/edit',                 'AdministrationController@RoleEditor');

        Route::match    (['get','post'], '/roles/add',                  'AdministrationController@RoleCreator');

        Route::get                      ('/statuses',                      'StatusesController@StatusManager');
        Route::match    (['get','post'], '/statuses/edit',                 'StatusesController@StatusEditor');
        Route::match    (['get','post'], '/statuses/edit/{member_id}',     'StatusesController@StatusAttach');
        Route::match    (['get','post'], '/statuses/add',                  'StatusesController@StatusCreator');
        Route::match    (['get','post'], '/statuses/default/{status_id}',  'StatusesController@StatusDefaulter');
        Route::match    (['get','post'], '/statuses/delete/{status_id}',  'StatusesController@StatusDeleter');
    });

    Route::group(['prefix'  =>  'money'], function(){
        Route::view('/upload',"fragments.samaksat");
        Route::post('payments', 'FileController@payments')->name('payments');
        Route::post('/store','FileController@store');
        Route::get                      ('/add',                                    'RepForGroups@index');
        Route::resource('add', 'RepForGroups');
        Route::get                      ('/create',                                 'RepForGroupsController@index');
        Route::resource('create','RepForGroupsController');
        Route:: match   (['get','post'], '/edit/{member_id}/{year}/{month}',        'RepatriationController@editMonth');
        Route:: match   (['get','post'], '/listload/{member_id}/{year}/{month}',    'RepatriationController@listMonth');
        Route:: match   (['get','post'], '/edit/{repatriation_id?}',                'RepatriationController@editEntry');
        Route:: match   (['get','post'], '/delete/{repatriation_id}',               'RepatriationController@deleteEntry');
        Route:: match   (['get','post'], '/xml',                                    'RepatriationController@XMLReaderTest');
        Route::get                      ('/listsearch/{year}/{page}/{query?}',      'RepatriationController@listSearch');
        Route::get                      ('/{page?}/{year?}/{async?}',               'RepatriationController@index');

    });

    Route::group(['prefix'  =>  'news'], function(){
       Route::get                       ('/index/{page?}',                             'NewsController@index');
       Route:: match    (['get','post'], '/add',                                       'NewsController@add');
    });

    Route::group(['prefix'  =>  'mail'], function(){
//        Route::any('/test', 'HomeController@mailTest');
    });

//    Route::any ('/image/upload',    'FileController@uploadImage');

    Route::get                          ('/map/{location}',             'MapController@index');

    Route::get                          ('/home',                       'HomeController@index')->name('home');
    Route::get                          ('/main',                       'HomeController@index')->name('home');
    Route::get                          ('/',                           'HomeController@index')->name('home');



});

Route::any                              ('/access-denied',              'HomeController@accessDenied')->name('accessDenied');
Route::any                              ('/server-down',                'HomeController@serverDown')->name('serverDown');
Route::get                              ('/activate/{userId}/{activationCode}',  'UsersController@activateUser')->name('activateUser');
Route::post                         ('/activate/{userId}/{activationCode}',  'UsersController@activateUser');




