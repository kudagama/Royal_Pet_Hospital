<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\MainPanelController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('main-panel');
    })->name('dashboard');
});

Route::prefix('main-panel')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [MainPanelController::class, 'index'])->name('main-panel');
    Route::get('/dashboard', [MainPanelController::class, 'dashboard'])->name('dashboard');
    Route::get('/petRegistretion', [MainPanelController::class, 'petRegistration'])->name('pet-registration');
    Route::get('/petRegistretion/register', [MainPanelController::class, 'registerPet'])->name('pet-registration.register');
    Route::post('/petRegistretion/store', [MainPanelController::class, 'storePet'])->name('pet-registration.store');
    Route::get('/petRegistretion/list', [MainPanelController::class, 'listPets'])->name('pet-registration.list');
    Route::get('/petRegistretion/edit/{id}', [MainPanelController::class, 'editPet'])->name('pet-registration.edit');
    Route::put('/petRegistretion/update/{id}', [MainPanelController::class, 'updatePet'])->name('pet-registration.update');
    Route::get('/petRegistretion/profile/{id}', [MainPanelController::class, 'showPet'])->name('pet-registration.show');
    Route::get('/petRegistretion/categories', [MainPanelController::class, 'petCategories'])->name('pet-registration.categories');
    Route::post('/petRegistretion/categories', [MainPanelController::class, 'storePetCategory'])->name('pet-registration.categories.store');
    Route::get('/petRegistretion/categories/{id}/edit', [MainPanelController::class, 'editPetCategory'])->name('pet-registration.categories.edit');
    Route::put('/petRegistretion/categories/{id}', [MainPanelController::class, 'updatePetCategory'])->name('pet-registration.categories.update');
    Route::delete('/petRegistretion/categories/{id}', [MainPanelController::class, 'deletePetCategory'])->name('pet-registration.categories.delete');
    Route::put('/petRegistretion/categories/{id}/toggle-status', [MainPanelController::class, 'togglePetCategoryStatus'])->name('pet-registration.categories.toggle-status');


    Route::post('/petRegistretion/breeds', [MainPanelController::class, 'storePetBreed'])->name('pet-registration.breeds.store');
    Route::delete('/petRegistretion/breeds/{id}', [MainPanelController::class, 'deletePetBreed'])->name('pet-registration.breeds.delete');
    
    Route::get('/bookings', [MainPanelController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/create', [MainPanelController::class, 'createBooking'])->name('bookings.create');
    Route::get('/opd', [MainPanelController::class, 'opd'])->name('opd');
    Route::get('/opd/create', [MainPanelController::class, 'createOPD'])->name('opd.create');
    Route::post('/opd/store', [MainPanelController::class, 'storeOPD'])->name('opd.store');
    Route::put('/opd/update-advance/{id}', [MainPanelController::class, 'updateOPDAdvance'])->name('opd.update-advance');
    Route::get('/opd/list', [MainPanelController::class, 'listOPD'])->name('opd.list');
    Route::get('/ward', [MainPanelController::class, 'ward'])->name('ward');
    Route::get('/salon', [MainPanelController::class, 'salon'])->name('salon');
    Route::get('/salon/create', [MainPanelController::class, 'createSalon'])->name('salon.create');
    Route::get('/salon/list', [MainPanelController::class, 'listSalon'])->name('salon.list');
    Route::get('/pharmacy', [MainPanelController::class, 'pharmacy'])->name('pharmacy');
    Route::get('/pharmacy/pos', [MainPanelController::class, 'pharmacyPOS'])->name('pharmacy.pos');
    Route::get('/pharmacy/inventory', [MainPanelController::class, 'pharmacyInventory'])->name('pharmacy.inventory');
    Route::get('/stock', [MainPanelController::class, 'stock'])->name('stock');
    Route::get('/stock/pharmacy', [MainPanelController::class, 'stockPharmacy'])->name('stock.pharmacy');
    Route::get('/stock/opd', [MainPanelController::class, 'stockOPD'])->name('stock.opd');
    Route::get('/stock/main', [MainPanelController::class, 'stockMain'])->name('stock.main');
    Route::get('/supplier-mgmt', [MainPanelController::class, 'supplierMgmt'])->name('supplier-mgmt');
    Route::get('/expenses', [MainPanelController::class, 'expenses'])->name('expenses');
    Route::get('/expenses/create', [MainPanelController::class, 'createExpense'])->name('expenses.create');
    Route::get('/expenses/list', [MainPanelController::class, 'listExpenses'])->name('expenses.list');
    Route::get('/expenses/create-category', [MainPanelController::class, 'createExpenseCategory'])->name('expenses.category.create');
    Route::get('/expenses/category-list', [MainPanelController::class, 'listExpenseCategories'])->name('expenses.category.list');
    Route::get('/final-billing', [MainPanelController::class, 'finalBilling'])->name('final-billing');
    Route::get('/users', [MainPanelController::class, 'users'])->name('users');
    Route::get('/users/attendance', [MainPanelController::class, 'usersAttendance'])->name('users.attendance');
    Route::get('/users/payroll', [MainPanelController::class, 'usersPayroll'])->name('users.payroll');
    Route::get('/users/create', [MainPanelController::class, 'createUser'])->name('users.create');
    Route::get('/users/list', [MainPanelController::class, 'listUsers'])->name('users.list');



});



