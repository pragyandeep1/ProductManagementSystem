<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ChargeDepartmentController;
use App\Http\Controllers\MeterReadUnitController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\BusinessClassificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'positions' => PositionController::class,
    'assets' => AssetController::class,
    'facilities' => FacilityController::class,
    'equipments' => EquipmentController::class,
    'tools' => ToolController::class,
    'supplies' => SuppliesController::class,
    'businesses' => BusinessController::class,
    'stocks' => StocksController::class,
    'orders' => OrderController::class,
    'maintenance' => MaintenanceController::class,
    'tasks' => TaskController::class,
    'projects' => ProjectController::class
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('dependent-dropdown', [DropdownController::class, 'index']);
    Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
    Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);

    // if values are already set
    // Route::get('/get-location-name/{id}',[DropdownController::class, 'getLocationNames'])->name('get-location-name');
    Route::get('get-location-name/{id}/{type}', [DropdownController::class, 'getLocationNames'])->name('get-location-name');

    Route::get('/settings', [SettingController::class, 'settings'])->name('settings');
    Route::post('/savesettings', [SettingController::class, 'savesettings'])->name('savesettings');

    // fetch address based on asset parent id dropdown
    Route::get('/get-parent-address/{id}', [FacilityController::class, 'getParentAddress']);
    Route::get('/get-equip_parent-address/{id}', [EquipmentController::class, 'getEquipParentAddress']);

    //Ajax stock save for supply
    Route::put('/save-stocks', [SuppliesController::class, 'saveStocks'])->name('save.stocks');
    Route::put('/save-inventories', [SuppliesController::class, 'saveInventories'])->name('save.inventories');
    Route::put('/save-warranties', [SuppliesController::class, 'saveWarranties'])->name('save.warranties');
    Route::put('/save-users', [SuppliesController::class, 'saveUsers'])->name('save.users');
    Route::put('/save-busiusers', [BusinessController::class, 'saveUsers'])->name('save.busiusers');
    Route::put('/save-suppliesbom', [SuppliesController::class, 'suppliesbom'])->name('save.suppliesbom');
    //Ajax for supply name
    Route::get('/getSupplyName', [SuppliesController::class, 'getSupplyName'])->name('getSupplyName');
    //Ajax for asset name
    Route::get('/getAssetName', [SuppliesController::class, 'getAssetName'])->name('getAssetName');

    // x---------------------------------Asset Category Controller ---------------------------------------------------------x
    Route::get('/category-index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{id}/show', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/category/add', [CategoryController::class, 'store'])->name('category.add');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    // x---------------------------------Asset Account Controller ---------------------------------------------------------x
    Route::get('/account-index', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/{id}/show', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account/add', [AccountController::class, 'store'])->name('account.add');
    Route::get('/account/{id}/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/{id}/update', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete/{id}', [AccountController::class, 'destroy'])->name('account.delete');
    // x---------------------------------Asset Charge Department Controller ---------------------------------------------------------x
    Route::get('/charge-index', [ChargeDepartmentController::class, 'index'])->name('charge.index');
    Route::get('/charge/{id}/show', [ChargeDepartmentController::class, 'show'])->name('charge.show');
    Route::post('/charge/add', [ChargeDepartmentController::class, 'store'])->name('charge.add');
    Route::get('/charge/{id}/edit', [ChargeDepartmentController::class, 'edit'])->name('charge.edit');
    Route::post('/charge/{id}/update', [ChargeDepartmentController::class, 'update'])->name('charge.update');
    Route::delete('/charge/delete/{id}', [ChargeDepartmentController::class, 'destroy'])->name('charge.delete');
    // x---------------------------------Meter Reading Units Controller ---------------------------------------------------------x
    Route::get('/meter-index', [MeterReadUnitController::class, 'index'])->name('meter.index');
    Route::get('/meter/{id}/show', [MeterReadUnitController::class, 'show'])->name('meter.show');
    Route::post('/meter/add', [MeterReadUnitController::class, 'store'])->name('meter.add');
    Route::get('/meter/{id}/edit', [MeterReadUnitController::class, 'edit'])->name('meter.edit');
    Route::post('/meter/{id}/update', [MeterReadUnitController::class, 'update'])->name('meter.update');
    Route::delete('/meter/delete/{id}', [MeterReadUnitController::class, 'destroy'])->name('meter.delete');
    // x---------------------------------Currency Unit Controller ---------------------------------------------------------x
    Route::get('/currency-index', [CurrencyController::class, 'index'])->name('currency.index');
    Route::get('/currency/{id}/show', [CurrencyController::class, 'show'])->name('currency.show');
    Route::post('/currency/add', [CurrencyController::class, 'store'])->name('currency.add');
    Route::get('/currency/{id}/edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::post('/currency/{id}/update', [CurrencyController::class, 'update'])->name('currency.update');
    Route::delete('/currency/delete/{id}', [CurrencyController::class, 'destroy'])->name('currency.delete');
    // x---------------------------------Asset Business Classification Controller ---------------------------------------------------------x
    Route::get('/businessclassification-index', [BusinessClassificationController::class, 'index'])->name('businessclassification.index');
    Route::get('/businessclassification/{id}/show', [BusinessClassificationController::class, 'show'])->name('businessclassification.show');
    Route::post('/businessclassification/add', [BusinessClassificationController::class, 'store'])->name('businessclassification.add');
    Route::get('/businessclassification/{id}/edit', [BusinessClassificationController::class, 'edit'])->name('businessclassification.edit');
    Route::post('/businessclassification/{id}/update', [BusinessClassificationController::class, 'update'])->name('businessclassification.update');
    Route::delete('/businessclassification/delete/{id}', [BusinessClassificationController::class, 'destroy'])->name('businessclassification.delete');

    // x---------------------------------part/facility Crud---------------------------------------------------------x
    Route::put('/save-faciparts', [FacilityController::class, 'savefaciparts'])->name('save.faciparts');
    Route::delete('/faciparts/delete/{id} ', [FacilityController::class, 'destroyfaciparts'])->name('faciparts.delete');
    // x---------------------------------meterread/facility Crud---------------------------------------------------------x
    Route::put('/save-facimeter', [FacilityController::class, 'savefacimeter'])->name('save.facimeter');
    Route::delete('/facimeter/delete/{id} ', [FacilityController::class, 'destroyfacimeter'])->name('facimeter.delete');
    // x---------------------------------documents/facility Crud---------------------------------------------------------x
    Route::put('/save-facidocs', [FacilityController::class, 'facidocs'])->name('save.facidocs');
    Route::delete('/facidocs/delete/{id} ', [FacilityController::class, 'destroyfacidocs'])->name('facidocs.delete');

    // x---------------------------------part/equipment Crud---------------------------------------------------------x
    Route::put('/save-equipparts', [EquipmentController::class, 'saveequipparts'])->name('save.equipparts');
    Route::delete('/equipparts/delete/{id} ', [EquipmentController::class, 'destroyequipparts'])->name('equipparts.delete');
    // x---------------------------------meterread/equipment Crud---------------------------------------------------------x
    Route::put('/save-equipmeter', [EquipmentController::class, 'saveequipmeter'])->name('save.equipmeter');
    Route::delete('/equipmeter/delete/{id} ', [EquipmentController::class, 'destroyequipmeter'])->name('equipmeter.delete');
    // x---------------------------------documents/equipment Crud---------------------------------------------------------x
    Route::put('/save-equipdocs', [EquipmentController::class, 'equipdocs'])->name('save.equipdocs');
    Route::delete('/equipdocs/delete/{id} ', [EquipmentController::class, 'destroyequipdocs'])->name('equipdocs.delete');

    // x---------------------------------meterread/tools Crud---------------------------------------------------------x
    Route::put('/save-toolsmeter', [ToolController::class, 'savetoolsmeter'])->name('save.toolsmeter');
    Route::delete('/toolsmeter/delete/{id} ', [ToolController::class, 'destroytoolsmeter'])->name('toolsmeter.delete');
    // x---------------------------------documents/tools Crud---------------------------------------------------------x
    Route::put('/save-toolsdocs', [ToolController::class, 'toolsdocs'])->name('save.toolsdocs');
    Route::delete('/toolsdocs/delete/{id} ', [ToolController::class, 'destroytoolsdocs'])->name('toolsdocs.delete');

    // x---------------------------------documents/business Crud---------------------------------------------------------x
    Route::put('/save-busidocs', [BusinessController::class, 'busidocs'])->name('save.busidocs');
    Route::delete('/busidocs/delete/{id} ', [BusinessController::class, 'destroybusidocs'])->name('busidocs.delete');

    // x---------------------------------documents/user Crud---------------------------------------------------------x
    Route::post('/ChangeStatus/{id}', [UserController::class, 'status_update']);
    Route::post('/certification/update/{id}', [UserController::class, 'cert_update'])->name('certificate.update');
    Route::delete('/certification/delete/{id}', [UserController::class, 'cert_delete'])->name('certificate.delete');

    // x---------------------------------documents/Supply Crud---------------------------------------------------------x
    Route::put('/save-supplydocs', [SuppliesController::class, 'supplydocs'])->name('save.supplydocs');
    Route::delete('/supplydocs/delete/{id} ', [SuppliesController::class, 'destroysupplydocs'])->name('supplydocs.delete');
    // x---------------------------------warranty/Supply Crud---------------------------------------------------------x
    Route::put('/save-supplywarranties', [SuppliesController::class, 'supplywarranties'])->name('save.supplywarranties');
    Route::delete('/supplywarranties/delete/{id} ', [SuppliesController::class, 'destroysupplywarranties'])->name('supplywarranties.delete');
    // x---------------------------------part BOMs/Supply Crud---------------------------------------------------------x
    Route::put('/save-supplyparts', [SuppliesController::class, 'savesupplyparts'])->name('save.supplyparts');
    Route::delete('/supplyparts/delete/{id} ', [SuppliesController::class, 'destroysupplyparts'])->name('supplyparts.delete');
    // x---------------------------------stock table detail/Supply Crud---------------------------------------------------------x
    Route::put('/save-supplystocks', [SuppliesController::class, 'savesupplystocks'])->name('save.supplystocks');
    Route::delete('/supplystocks/delete/{id} ', [SuppliesController::class, 'destroysupplystocks'])->name('supplystocks.delete');
    // x---------------------------------inventory table detail/Supply Crud---------------------------------------------------------x
    Route::put('/save-supplyinventories', [SuppliesController::class, 'savesupplyinventories'])->name('save.supplyinventories');
    Route::delete('/supplyinventories/delete/{id} ', [SuppliesController::class, 'destroysupplyinventories'])->name('supplyinventories.delete');
});

// Route::get('/ChangeStatus',[FacilityController::class,'changeStatus'])->name('facilities.ChangeStatus');