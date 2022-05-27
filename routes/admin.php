<?php
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::prefix('admin')->middleware('theme:admin')->name('admin.')->group(function(){
Route::view('/login', 'auth.login')->middleware('guest:admin')->name('login');
Route::view('/home', 'home')->name('login')->middleware('auth:admin')->name('home');

// Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//             ->middleware(['guest:'.config('fortify.guard')])
//             ->name('login');

$limiter = config('fortify.limiters.login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                // 'guest:'.config('fortify.guard'),
                'guest:admin',
                $limiter ? 'throttle:'.$limiter : null,
            ]));
    
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth:admin')
            ->name('logout');

             
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:admin'])
                ->name('register');
        

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:admin']);

});