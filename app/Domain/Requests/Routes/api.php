<?php


declare(strict_types=1);

namespace App\Domain\Requests\Routes;

use App\Domain\Requests\Http\Controllers\Config\RequestType\RequestTypeController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\RequestTypeCategoriesController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\RequestTypeCreateController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\RetrieveRequestTypeController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\RequestTypeUpdateController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\RequestTypeNewReleaseController;
use App\Domain\Requests\Http\Controllers\Config\RequestType\DeleteRequestTypController;
use App\Domain\Requests\Http\Controllers\Config\FormRequest\DeleteFormRequestController;
use App\Domain\Requests\Http\Controllers\Config\FormRequest\FormRequestController;
use App\Domain\Requests\Http\Controllers\Config\FormRequest\RetrieveFormRequestController;
use App\Domain\Requests\Http\Controllers\Config\FormRequest\FormRequestCreateController;
use App\Domain\Requests\Http\Controllers\Config\FormRequest\FormRequestUpdateController;
use App\Domain\Requests\Http\Controllers\Config\FieldType\DeleteFieldTypeController;
use App\Domain\Requests\Http\Controllers\Config\FieldType\FieldTypeController;
use App\Domain\Requests\Http\Controllers\Config\FieldType\RetrieveFieldTypeController;
use App\Domain\Requests\Http\Controllers\Config\FieldType\FieldTypeCreateController;
use App\Domain\Requests\Http\Controllers\Config\FieldType\FieldTypeUpdateController;
use App\Domain\Requests\Http\Controllers\Config\RequestPermissionRole\RequestPermissionByRoleController;
use App\Domain\Requests\Http\Controllers\Config\RequestPermissionRole\RequestPermissionRoleCreateController;
use App\Domain\Requests\Http\Controllers\Config\TemplateDataField\DeleteTemplateDataFieldController;
use App\Domain\Requests\Http\Controllers\Config\TemplateDataField\TemplateDataFieldCreateController;
use App\Domain\Requests\Http\Controllers\Request\DataSelectController;
use App\Domain\Requests\Http\Controllers\Request\GenerateRequestController;
use App\Domain\Requests\Http\Controllers\Request\GetDataSelectByIdController;
use App\Domain\Requests\Http\Controllers\Request\GetInfoRequestController;
use App\Domain\Requests\Http\Controllers\Request\GetStatusRequestController;
use App\Domain\Requests\Http\Controllers\Request\ListRequestInBoxController;
use App\Domain\Requests\Http\Controllers\Request\RequestCreateController;
use App\Domain\Requests\Http\Controllers\Request\StatusRequestController;
use App\Domain\Requests\Http\Controllers\Request\TransactionsRequestController;
use App\Domain\Requests\Http\Controllers\Request\WorkflowRequestController;
use App\Domain\Requests\Http\Controllers\TemplateStep\TemplateStepCreateController;
use App\Domain\Requests\Http\Controllers\ValidateValue\ValidateFieldController;
use App\Domain\Requests\Http\Controllers\ValidateValue\ValidateFormController;
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
Route::prefix('request')->name('request.')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::post('template-step/create', TemplateStepCreateController::class)->name('create.template.step'); 
        Route::post('create', RequestCreateController::class)->name('create.request');
        Route::post('validate-field', ValidateFieldController::class)->name('validate.field.request');
        Route::post('validate-form', ValidateFormController::class)->name('validate.form.request');

    });
});


Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::get('get-data-by-id/{nameTable}/{idItem}/{champRelationship}', GetDataSelectByIdController::class)->name('get.data.select.byId');
    Route::get('get-data-select/{nameTable}', DataSelectController::class)->name('get.data.select');
    Route::get('generate-from/{requestType}', GenerateRequestController::class)->name('generate.from');
    Route::get('get-info-request/{idRequest}', GetInfoRequestController::class)->name('get.info.request');
    Route::get('request-transactions/{idRequest}', TransactionsRequestController::class)->name('get.transactions.request');
    Route::get('request-workflow/{idRequest}', WorkflowRequestController::class)->name('get.workflow.request');
    Route::get('inbox/list-requests', ListRequestInBoxController::class)->name('inbox.list.requests');
    Route::post('change/status/request', StatusRequestController::class)->name('change.status.request');
    Route::post('get/status/request', GetStatusRequestController::class)->name('get.status.request');


});


Route::prefix('template-data-field')->name('templateDataField.')->group(static function () {
    Route::delete('{templateDataField}', DeleteTemplateDataFieldController::class)->name('delete.templateDataField');
    Route::post('create', TemplateDataFieldCreateController::class)->name('create.templateDataField');
});
Route::prefix('field-type')->name('fieldType.')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::delete('{fieldType}', DeleteFieldTypeController::class)->name('delete.fieldType');
        Route::get('/', FieldTypeController::class)->name('all.fieldType');
        Route::get('{fieldType}', RetrieveFieldTypeController::class)->name('single.fieldType');
        Route::post('create', FieldTypeCreateController::class)->name('create.fieldType');
        Route::put('{fieldType}', FieldTypeUpdateController::class)->name('update.fieldType');
    });
});
Route::prefix('template-datas')->name('requestForm.')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::get('/', FormRequestController::class)->name('all.form');
        Route::delete('{templateData}', DeleteFormRequestController::class)->name('delete.form');
        Route::get('{templateData}', RetrieveFormRequestController::class)->name('single.form');
        Route::post('create', FormRequestCreateController::class)->name('create.form');
        Route::put('{templateData}', FormRequestUpdateController::class)->name('update.form');
    });
});


Route::prefix('request-types')->name('request.')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {

        Route::get('categories', RequestTypeCategoriesController::class)->name('all.categories.request.types');
        Route::get('/', RequestTypeController::class)->name('all.type');
        Route::get('{requestType}', RetrieveRequestTypeController::class)->name('single.type');
        Route::post('create', RequestTypeCreateController::class)->name('create.type');
        Route::put('{requestType}', RequestTypeUpdateController::class)->name('update.type');
        Route::post('NewRelease', RequestTypeNewReleaseController::class)->name('new.release.type');
        Route::delete('{requestType}', DeleteRequestTypController::class)->name('delete.type');
    });
});


Route::prefix('request-permission-role')->name('requestPermission.')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {

        Route::post('create', RequestPermissionRoleCreateController::class)->name('create.request.permission.role');
        Route::get('get', RequestPermissionByRoleController::class)->name('get.request.permission.role');


    });
});
Route::prefix('request')->name('configForm.')->group(static function () {


    Route::group(['middleware' => ['auth:sanctum']], static function () {

        //   Route::post('/configForm/register', ConfigFormController::class)->name('configForm.register');
    });

});


Route::fallback(static fn () => \response()->json(['message' => 'Route not found.'], Response::HTTP_NOT_FOUND))->name('fallback');
