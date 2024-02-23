<?php

use App\Http\Controllers\API\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('companies', CompanyController::class);

Route::get('/companies/my-companies/{id}', [CompanyController::class, 'myCompanies']);

Route::get('/companies/search/{cep}', [CompanyController::class, 'searchByCep']);
