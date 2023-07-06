<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Middleware\AuthenticateWithSanctum;
use App\Http\Middleware\canDeleteOrUpdate;
use App\Http\Middleware\Admin;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/posts', [PostController::class,'index']);
    Route::prefix('Home')->group(function () {
        Route::post('/posts/create', [PostController::class,'store']);
        Route::put('/posts/edit/{id}',[PostController::class,'update']);
        Route::delete('/posts/delete/{id}', [PostController::class,'destroy'])->middleware(['canDeleteOrUpdate']);
        Route::post('/comments/create/{pid}', [CommentController::class, 'add']);
        Route::get('/comments/show/{pid}', [CommentController::class, 'show']);
        Route::post('/comments/{id}/{comment}/like', [LikeController::class, 'store']);
        Route::post('/posts/{id}/{post}/like', [LikeController::class, 'store']);
    });
    Route::prefix('Dashboard')->middleware(['admin'])->group(function (){
        Route::get('/posts/deleted', [PostController::class, 'softPosts']);
        Route::get('/posts/restore/{id}', [PostController::class, 'restorePost']);
        Route::get('/posts/restoreAll', [PostController::class, 'restoreAll']);
        Route::get('/Roles/All', [UserRoleController::class, 'index']);
        Route::post('/Roles/addRole/{uid}/{rid}', [UserRoleController::class, 'addRole']);
        Route::delete('/Roles/destroy/{uid}/{rid}', [UserRoleController::class, 'destroy']);
    });
    Route::middleware(['check:editor'])->group(function (){
        Route::put('/Home/posts/edit/{id}', [PostController::class,'update']);
    });
});





