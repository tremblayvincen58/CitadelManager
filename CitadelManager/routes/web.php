<?php

/*
 * Copyright © 2017 Jesse Nicholson
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

use App\Role;

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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    Route::get('/', function () {
        $roles =  Role::all();
        return view('adminhome')->with('roles', $roles);
    });
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin');
    } else {
        return redirect('/login');
    }
});

Route::get('/update/win{platform}/update.xml', function ($platform) {
    return response()
        ->view('update.windows.update_xml',
            [
                'platform' => $platform,
                'app_name' => 'CloudVeil',
                'file_name' => 'CloudVeil',
                'version_name' => '1.0.5 Release',
                'version_number' => '1.0.5',
                'changes' =>
                    [
                        'App and app library versions now bumped above default value of 1.0.0.0 to enforce installation of updated binaries',
                    ],
                'date' => 'Sat, 9 Sep 2017 20:33:00 MST'

            ]
        )
        ->header('Content-Type', 'text/xml');
});

Route::get('/download/latest/64', function() {
  return redirect('/releases/CloudVeil-1.0.3-x64.msi');
});

Route::get('/download/latest/32', function() {
  return redirect('/releases/CloudVeil-1.0.3-x86.msi');
});

