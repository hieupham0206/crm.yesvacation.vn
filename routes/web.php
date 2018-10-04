<?php
Auth::routes();

Route::get('/otp/{phone}/{username}', 'Auth\LoginController@formOtp')->name('otp');
Route::post('/resend-otp/{phone}/{username}', 'Auth\LoginController@resendOtp')->middleware('throttle:1,5')->name('resend_otp');
Route::post('/login-otp', 'Auth\LoginController@loginOtp')->name('login_otp');

//home route
Route::get('/', 'HomeController@index')->middleware(['auth', 'active'])->name('home');

//language route
Route::get('/js/lang.js', 'HomeController@lang')->name('lang');

//QUICKSEARCH
Route::get('/quicksearch', 'HomeController@quickSearch');

$routeArr = getRouteConfig();
foreach ($routeArr as $key => $routes) {
    $namespace = ucfirst($key);
    $prefix    = $key;

    // ROUTE CHUNG
    Route::namespace($namespace)->prefix($prefix)->group(function () use ($routes) {
        foreach ($routes as $route) {
            $ucTable         = ucfirst(studly_case($route));
            $ucTableSingular = str_singular($ucTable);
            $varRouteName    = lcfirst(studly_case($route));

            if (class_exists("App\\Models\\{$ucTableSingular}")) {
                Route::resource($route, "{$ucTable}Controller");
                Route::get("/{$route}/lists/list", "{$ucTable}Controller@{$varRouteName}")->name("{$route}.list");
                Route::post("/{$route}/lists/table", "{$ucTable}Controller@table")->name("{$route}.table");

                Route::delete("/{$route}/action/deletes", "{$ucTable}Controller@destroys")->name("{$route}.destroys");
                Route::post("/{$route}/action/edits", "{$ucTable}Controller@edits")->name("{$route}.edits");
                Route::put("/{$route}/action/updates", "{$ucTable}Controller@updates")->name("{$route}.updates");
            }
        }
    });
}
//ROUTE CHI TIẾT
Route::namespace('Admin')->prefix('admin')->group(base_path('routes/modules/admin.php'));