<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CustomersMembershipsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\MembershipsController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TypesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Customers

Route::get('customers', [CustomersController::class, 'index'])
    ->name('customers')
    ->middleware('auth');

Route::get('customers/create', [CustomersController::class, 'create'])
    ->name('customers.create')
    ->middleware('auth');

Route::post('customers', [CustomersController::class, 'store'])
    ->name('customers.store')
    ->middleware('auth');

Route::get('customers/{customer}/edit', [CustomersController::class, 'edit'])
    ->name('customers.edit')
    ->middleware('auth');

Route::put('customers/{customer}/membership', [CustomersMembershipsController::class, 'store'])
    ->name('customers.membership')
    ->middleware('auth');

Route::put('customers/{customer}', [CustomersController::class, 'update'])
    ->name('customers.update')
    ->middleware('auth');

Route::delete('customers/{customer}', [CustomersController::class, 'destroy'])
    ->name('customers.destroy')
    ->middleware('auth');

Route::put('customers/{customer}/restore', [CustomersController::class, 'restore'])
    ->name('customers.restore')
    ->middleware('auth');

// Membership
Route::get('memberships', [MembershipsController::class, 'index'])
    ->name('memberships')
    ->middleware('auth');

Route::get('memberships/create', [MembershipsController::class, 'create'])
    ->name('memberships.create')
    ->middleware('auth');

Route::post('memberships', [MembershipsController::class, 'store'])
    ->name('memberships.store')
    ->middleware('auth');

Route::get('memberships/{membership}/edit', [MembershipsController::class, 'edit'])
    ->name('memberships.edit')
    ->middleware('auth');

Route::put('memberships/{membership}', [MembershipsController::class, 'update'])
    ->name('memberships.update')
    ->middleware('auth');

Route::delete('memberships/{membership}', [MembershipsController::class, 'destroy'])
    ->name('memberships.destroy')
    ->middleware('auth');

Route::put('memberships/{membership}/restore', [MembershipsController::class, 'restore'])
    ->name('memberships.restore')
    ->middleware('auth');

// Types
Route::get('types', [TypesController::class, 'index'])
    ->name('types')
    ->middleware('auth');

Route::get('types/create', [TypesController::class, 'create'])
    ->name('types.create')
    ->middleware('auth');

Route::post('types', [TypesController::class, 'store'])
    ->name('types.store')
    ->middleware('auth');

Route::get('types/{type}/edit', [TypesController::class, 'edit'])
    ->name('types.edit')
    ->middleware('auth');

Route::put('types/{type}', [TypesController::class, 'update'])
    ->name('types.update')
    ->middleware('auth');

Route::delete('types/{type}', [TypesController::class, 'destroy'])
    ->name('types.destroy')
    ->middleware('auth');

Route::put('types/{type}/restore', [TypesController::class, 'restore'])
    ->name('types.restore')
    ->middleware('auth');

// Products
Route::get('products', [ProductsController::class, 'index'])
    ->name('types')
    ->middleware('auth');

Route::get('products/create', [ProductsController::class, 'create'])
    ->name('products.create')
    ->middleware('auth');

Route::post('products', [ProductsController::class, 'store'])
    ->name('products.store')
    ->middleware('auth');

Route::get('products/{product}/edit', [ProductsController::class, 'edit'])
    ->name('products.edit')
    ->middleware('auth');

Route::put('products/{product}', [ProductsController::class, 'update'])
    ->name('products.update')
    ->middleware('auth');

Route::delete('products/{product}', [ProductsController::class, 'destroy'])
    ->name('products.destroy')
    ->middleware('auth');

Route::put('products/{product}/restore', [ProductsController::class, 'restore'])
    ->name('products.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
