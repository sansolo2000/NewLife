<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Route::get('/', 'HomeController@index')->name('home');
//Route::get('post/{post}', 'Client\PageController@postDetail');


Auth::routes(['register' => false]);

//Route::get('/{area?}', 'Admin\DashBoardController@index');
//Route::get('/admin', 'Admin\DashBoardController@index');
//Route::get('/admin/{area?}', 'Admin\DashBoardController@index');


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth']
], function () {
    
    // Route::group(['middleware' => ['can:isAdminOrAuthor']], function() {

    Route::get('/envioestados/{jira_id}/{tiaj_id}', 'EnvioCorreoController@EnvioCorreo');


    Route::get('/tipoestado', 'TipoEstadoController@index');
    Route::get('/tipoestado/create', 'TipoEstadoController@create');
    Route::post('/tipoestado', 'TipoEstadoController@store');
    Route::get('/tipoestado/{id}', 'TipoEstadoController@show');
    Route::get('/tipoestado/{id}/edit', 'TipoEstadoController@edit');
    Route::post('/tipoestado/{id}/edit', 'TipoEstadoController@update');
    Route::get('/tipoestado/{id}/delete', 'TipoEstadoController@destroy');

    Route::get('/tipoaccionjira', 'TipoAccionJiraController@index');
    Route::get('/tipoaccionjira/create', 'TipoAccionJiraController@create');
    Route::post('/tipoaccionjira', 'TipoAccionJiraController@store');
    Route::get('/tipoaccionjira/{id}', 'TipoAccionJiraController@show');
    Route::get('/tipoaccionjira/{id}/edit', 'TipoAccionJiraController@edit');
    Route::post('/tipoaccionjira/{id}/edit', 'TipoAccionJiraController@update');
    Route::get('/tipoaccionjira/{id}/delete', 'TipoAccionJiraController@destroy');    
    // N3 / Jiras
    Route::get('/jira', 'JiraController@index');
    Route::get('/jira/create', 'JiraController@create');
    Route::post('/jira', 'JiraController@store');
    Route::get('/jira/{id}', 'JiraController@show');
    Route::get('/jira/{id}/edit', 'JiraController@edit');
    Route::post('/jira/{id}/edit', 'JiraController@update');
    Route::get('/jira/{id}/delete', 'JiraController@destroy');
    // Accion Jira
    Route::get('/jiraaccion/create/{jira_id}', 'JiraAccionController@create');
    Route::post('/jiraaccion/{jira_id}', 'JiraAccionController@store');
    Route::get('/jiraaccion/{id}', 'JiraAccionController@show');
    Route::get('/jiraaccion/{id}/edit', 'JiraAccionController@edit');
    Route::post('/jiraaccion/{id}/edit', 'JiraAccionController@update');
    Route::get('/jiraaccion/{id}/delete', 'JiraAccionController@destroy');
    Route::get('/jiraaccion/{id}/download', 'JiraAccionController@download');

    Route::get('/version', 'VersionController@index');
    Route::get('/version/create', 'VersionController@create');
    Route::post('/version', 'VersionController@store');
    Route::get('/version/{id}', 'VersionController@show');
    Route::get('/version/{id}/edit', 'VersionController@edit');
    Route::post('/version/{id}/edit', 'VersionController@update');
    Route::get('/version/{id}/delete', 'VersionController@destroy');

    Route::get('/versionaccion/create/{vers_id}', 'VersionAccionController@create');
    Route::post('/versionaccion/{vers_id}', 'VersionAccionController@store');
    Route::get('/versionaccion/{vers_id}/{veac_id}', 'VersionAccionController@show');
    Route::get('/versionaccion/{vers_id}/{veac_id}/edit', 'VersionAccionController@edit');
    Route::post('/versionaccion/{vers_id}/{veac_id}/edit', 'VersionAccionController@update');
    Route::get('/versionaccion/{vers_id}/{veac_id}/delete', 'VersionAccionController@destroy');
    Route::get('/versionaccion/{vers_id}/{veac_id}/download', 'VersionAccionController@download');
    Route::get('/versionaccion/{vers_id}/toassign', 'VersionAccionController@toassign');
    Route::post('/versionaccion/{vers_id}/toassign', 'VersionAccionController@assigned');

    Route::get('/incidente/{id}', 'IncidenteController@index');


    
    // User Routes
    Route::get('/user', 'UserController@index');
    Route::get('/user/create', 'UserController@create');
    Route::post('/user', 'UserController@store');
    Route::get('/user/{id}', 'UserController@show');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::post('/user/{id}/edit', 'UserController@update');
    Route::get('/user/{id}/delete', 'UserController@destroy');    

    // Role Routes
    Route::resource('role', 'RoleController');
    // Profile Routes
    Route::view('profile', 'admin.profile.index')->name('profile.index');;
    Route::view('profile/edit', 'admin.profile.edit')->name('profile.edit');
    Route::put('profile/edit', 'ProfileController@update')->name('profile.update');
    Route::view('profile/password', 'admin.profile.edit_password')->name('profile.edit.password');
    Route::post('profile/password', 'ProfileController@updatePassword')->name('profile.update.password');

    Route::get('/{area?}', 'DashBoardController@index');
    Route::get('/admin', 'DashBoardController@index');
    Route::get('/admin/{area?}', 'DashBoardController@index');

});

