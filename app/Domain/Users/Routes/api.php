<?php

declare(strict_types=1);

namespace App\Domain\Users\Routes;

use App\Domain\Users\Http\Controllers\Authentication\ForgotPassword;
use App\Domain\Users\Http\Controllers\Authentication\LoginController;
use App\Domain\Users\Http\Controllers\Authentication\LogoutController;
use App\Domain\Users\Http\Controllers\Authentication\RefreshToken;
use App\Domain\Users\Http\Controllers\Authentication\ResetPassword;
use App\Domain\Users\Http\Controllers\Authentication\RetrieveUserProfile;
use App\Domain\Users\Http\Controllers\Authentication\SwitchUserController;
use App\Domain\Users\Http\Controllers\Department\AssignProfileDepartmentController;
use App\Domain\Users\Http\Controllers\Department\AssignRoleDepartmentController;
use App\Domain\Users\Http\Controllers\Department\CreateDepartmentController;
use App\Domain\Users\Http\Controllers\Department\DeleteDepartmentController;
use App\Domain\Users\Http\Controllers\Department\RemoveProfileDepartmentController;
use App\Domain\Users\Http\Controllers\Department\RetrieveCollectionDepartmentController;
use App\Domain\Users\Http\Controllers\Department\RetrieveDepartmentController;
use App\Domain\Users\Http\Controllers\Department\RevokeRoleDepartmentController;
use App\Domain\Users\Http\Controllers\Department\UpdateDepartmentController;
use App\Domain\Users\Http\Controllers\Gender\RetrieveCollectionGendersController;
use App\Domain\Users\Http\Controllers\Permission\AssignRoleProfileController;
use App\Domain\Users\Http\Controllers\Permission\CreateRoleController;
use App\Domain\Users\Http\Controllers\Permission\DeleteRoleController;
use App\Domain\Users\Http\Controllers\Permission\RetrieveCollectionPermission;
use App\Domain\Users\Http\Controllers\Permission\RetrieveCollectionRole;
use App\Domain\Users\Http\Controllers\Permission\RetrieveRoleController;
use App\Domain\Users\Http\Controllers\Permission\RetrieveRolesPerProfileController;
use App\Domain\Users\Http\Controllers\Permission\RevokeRoleProfileController;
use App\Domain\Users\Http\Controllers\Permission\UpdateRoleController;
use App\Domain\Users\Http\Controllers\Profile\DeleteProfileController;
use App\Domain\Users\Http\Controllers\Tvtc\CreateTvtcOperatorController;
use App\Domain\Users\Http\Controllers\Tvtc\LoginTvtcOperatorController;
use App\Domain\Users\Http\Controllers\Tvtc\SetPasswordController;
use App\Domain\Users\Http\Controllers\User\ChangeUserEmailController;
use App\Domain\Users\Http\Controllers\User\ChangeUserPasswordController;
use App\Domain\Users\Http\Controllers\User\CheckUserController;
use App\Domain\Users\Http\Controllers\User\CreateUserController;
use App\Domain\Users\Http\Controllers\User\RegisterUserController;
use App\Domain\Users\Http\Controllers\User\RetrieveCollectionEstablishmentOperators;
use App\Domain\Users\Http\Controllers\User\RetrieveCollectionTvtcOperators;
use App\Domain\Users\Http\Controllers\User\RetrieveCollectionUser;
use App\Domain\Users\Http\Controllers\User\RetrieveUserController;
use App\Domain\Users\Http\Controllers\User\UpdateUserController;
use App\Domain\Users\Http\Controllers\User\ValidateUserController;
use App\Domain\Users\Http\Controllers\UserType\RetrieveCollectionUserTypesController;
use Illuminate\Http\Response;
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

# USER ROUTES
Route::prefix('users')->name('users.')->group(static function () {

    Route::group(['middleware' => ['auth:api']], static function () {
        Route::get('/', RetrieveCollectionUser::class)->name('all');
        Route::get('/tvtc-operators', RetrieveCollectionTvtcOperators::class)->name('tvtc-operators');
        Route::get('/establishment-operators', RetrieveCollectionEstablishmentOperators::class)->name('establishment-operators');
        Route::post('/', CreateUserController::class)->name('create');
        Route::get('{user}', RetrieveUserController::class)->name('single');
        Route::put('{user}', UpdateUserController::class)->name('single.update');
        Route::put('{user}/email', ChangeUserEmailController::class)->name('email.update');
        Route::post('password-change', ChangeUserPasswordController::class)->name('password.update');
        Route::delete('/profiles/{profile}', DeleteProfileController::class)->name('single.delete');
        Route::post('/profiles/{profile}/roles/assign', AssignRoleProfileController::class)->name('role.assign');
        Route::post('/profiles/{profile}/roles/revoke', RevokeRoleProfileController::class)->name('role.revoke');
        Route::get('/profiles/{profile}/roles', RetrieveRolesPerProfileController::class)->name('role.profile');
    });

    Route::put('validate/{token}', ValidateUserController::class)->name('users.validate');
    Route::post('check', CheckUserController::class)->name('users.check');
    Route::post('register', RegisterUserController::class)->name('users.register');
    Route::post('operator', CreateTvtcOperatorController::class)->name('users.register.operator');
});

# TVTC ROUTES
Route::prefix('tvtc')->name('tvtc.')->group(static function () {

    Route::group(['middleware' => ['auth:api']], static function () {
        Route::post('/', CreateTvtcOperatorController::class)->name('tvtc.create');
    });
    Route::post('/login', LoginTvtcOperatorController::class)->name('tvtc.login');
    Route::put('/set-password/{token}', SetPasswordController::class)->name('tvtc.set-password');
});

# USER TYPE ROUTES
Route::prefix('user-types')->name('user-types.')->group(static function () {
    Route::get('/', RetrieveCollectionUserTypesController::class)->name('all');
});

# GENDER ROUTES
Route::prefix('genders')->name('genders.')->group(static function () {
    Route::get('/', RetrieveCollectionGendersController::class)->name('all');
});

# DEPARTMENTS
Route::prefix('departments')->name('department.')->group(static function () {
    Route::group(['middleware' => ['auth:api']], static function () {
        Route::post('/', CreateDepartmentController::class)->name('create');
        Route::put('/{department}', UpdateDepartmentController::class)->name('update');
        Route::delete('/{department}', DeleteDepartmentController::class)->name('delete');
        Route::get('/', RetrieveCollectionDepartmentController::class)->name('all');
        Route::get('/{department}', RetrieveDepartmentController::class)->name('single');
        Route::post('/{department}/roles/assign', AssignRoleDepartmentController::class)->name('role.assign');
        Route::post('/{department}/roles/revoke', RevokeRoleDepartmentController::class)->name('role.revoke');
        Route::post('/{department}/profiles/{profile}/assign', AssignProfileDepartmentController::class)->name('profile.assign');
        Route::post('/{department}/profiles/{profile}/remove', RemoveProfileDepartmentController::class)->name('profile.remove');
    });
});

# PERMISSION ROUTES
Route::prefix('permissions')->name('permissions.')->group(static function () {
    Route::group(['middleware' => ['auth:api']], static function () {
        Route::get('/', RetrieveCollectionPermission::class)->name('all');
        Route::get('/roles/{role}', RetrieveRoleController::class)->name('role.single');
        Route::delete('/roles/{role}', DeleteRoleController::class)->name('role.delete');
        Route::get('/roles', RetrieveCollectionRole::class)->name('role.all');
        Route::post('/roles', CreateRoleController::class)->name('role.create');
        Route::put('/roles/{role}', UpdateRoleController::class)->name('role.update');
    });
});

# AUTH ROUTES
Route::prefix('auth')->name('auth.')->group(static function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('reset-password', ForgotPassword::class)->name('forgot-password');
    Route::put('reset-password/{token}', ResetPassword::class)->name('reset-password');

    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::post('/logout', LogoutController::class)->name('auth.logout');
        Route::post('/refresh-token', RefreshToken::class)->name('refresh-token');
        Route::get('/profile', RetrieveUserProfile::class)->name('profile');
        Route::post('/switch', SwitchUserController::class)->name('switch');
    });
});

Route::fallback(static fn () => \response()->json(['message' => 'Route not found.'], Response::HTTP_NOT_FOUND))->name('fallback');
