<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('plan', [PlanController::class, 'index'])->name('plan.index');

    // Resource controller : https://laravel.com/docs/8.x/controllers#resource-controllers
    Route::resources([
        'documents' => DocumentController::class,
        'projects' => ProjectController::class,
    ]);
    Route::get('projects/generateApprovalDocument/{project}', [ProjectController::class, 'generateApprovalDocument'])->name('projects.generateApprovalDocument');
});
