<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\LayoutController;

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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;

Route::get('theme-switcher/{activeTheme}', [ThemeController::class, 'switch'])->name('theme-switcher');
Route::get('layout-switcher/{activeLayout}', [LayoutController::class, 'switch'])->name('layout-switcher');
Route::post('/login', [LoginController::class, 'login']);
Route::get('login', [PageController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/RegisterUsers', [UserController::class, 'RegisterUsers'])->name('users.register');
Route::post('/RegisterUsers/create', [UserController::class, 'RegisterUsersStore'])->name('users.registerStore');
Route::get('/resetPassword', [UserController::class, 'resetPasswordIndex'])->name('users.resetPasswordIndex');
Route::post('/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');
// Mostrar formulario para solicitar enlace de restablecimiento de contraseña
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Enviar enlace de restablecimiento de contraseña
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Mostrar formulario de restablecimiento de contraseña
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Procesar el restablecimiento de contraseña
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/registroCitas/{guid}',[EmpresaController::class,'registerPublic'])->name('empresa.registerPublic');
Route::post('/registroCitasSubmit/{guid}',[EmpresaController::class,'registerPublicSubmit'])->name('citas.registerPublic');
Route::get('/registradoCitas/{guid}',[CitaController::class,'publicRegistered'])->name('empresa.publicRegistered');

Route::get('/clientes/buscar ',[ClienteController::class,'buscarCliente']);
Route::get('/empleados/{id}/servicios ',[EmpleadoController::class,'obtenerServicios']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //CRUD USUARIOS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/update/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/check-record', [UserController::class, 'checkRecord'])->name('checkRecord');

    //CRUD CONFIGURACIONES
    //CRUD CONFIGURACION DEPARTAMENTO
    Route::get('/department',[DepartmentController::class,'list'])->name('department.index');
    Route::get('/department/create',[DepartmentController::class,'create'])->name('department.create');
    Route::post('/department/create',[DepartmentController::class,'store'])->name('department.store');
    Route::get('/department/update/{id}',[DepartmentController::class,'edit'])->name('department.edit');
    Route::post('/department/update/',[DepartmentController::class,'update'])->name('department.update');
    Route::get('/department/delete/{id}',[DepartmentController::class,'delete'])->name('department.delete');

    //CRUD SERVICIOS
    Route::get('/servicios',[ServicioController::class,'index'])->name('servicio.index');
    Route::get('/servicios/create',[ServicioController::class,'create'])->name('servicio.create');
    Route::post('/servicios/create',[ServicioController::class,'store'])->name('servicio.store');
    Route::get('/servicios/update/{id}',[ServicioController::class,'edit'])->name('servicio.edit');
    Route::put('/servicios/update/{id}',[ServicioController::class,'update'])->name('servicio.update');
    Route::delete('/servicios/delete/{id}',[ServicioController::class,'destroy'])->name('servicio.delete');

    //CRUD CONFIGURACION CIUDAD
    Route::get('/city',[CityController::class,'list'])->name('city.index');
    Route::get('/city/create',[CityController::class,'create'])->name('city.create');
    Route::post('/city/create',[CityController::class,'store'])->name('city.store');
    Route::get('/city/update/{id}',[CityController::class,'edit'])->name('city.edit');
    Route::post('/city/update/',[CityController::class,'update'])->name('city.update');
    Route::get('/city/delete/{id}',[CityController::class,'delete'])->name('city.delete');

    //CRUS empresas
    Route::get('/empresas',[EmpresaController::class,'index'])->name('empresa.index');
    Route::get('/empresa/create',[EmpresaController::class,'create'])->name('empresa.create');
    Route::post('/empresa/create',[EmpresaController::class,'store'])->name('empresa.store');
    Route::get('/empresa/update/{id}',[EmpresaController::class,'edit'])->name('empresa.edit');
    Route::put('/empresa/update/{id}',[EmpresaController::class,'update'])->name('empresa.update');
    Route::delete('/empresa/delete/{id}',[EmpresaController::class,'destroy'])->name('empresa.delete');

    //CRUS empleados
    Route::get('/empleados',[EmpleadoController::class,'index'])->name('empleado.index');
    Route::get('/empleados/create',[EmpleadoController::class,'create'])->name('empleado.create');
    Route::post('/empleados/create',[EmpleadoController::class,'store'])->name('empleado.store');
    Route::get('/empleado/update/{id}',[EmpleadoController::class,'edit'])->name('empleado.edit');
    Route::put('/empleado/update/{id}',[EmpleadoController::class,'update'])->name('empleado.update');
    Route::delete('/empleados/delete/{id}',[EmpleadoController::class,'destroy'])->name('empleado.delete');

    //CRUS empleados
    Route::get('/citas',[CitaController::class,'index'])->name('citas.index');
    Route::get('/cita/create',[CitaController::class,'create'])->name('citas.create');
    Route::post('/cita/create',[CitaController::class,'store'])->name('citas.store');
    Route::get('/cita/update/{id}',[CitaController::class,'edit'])->name('citas.edit');
    Route::put('/cita/update/{id}',[CitaController::class,'update'])->name('citas.update');
    Route::delete('/cita/delete/{id}',[CitaController::class,'destroy'])->name('citas.delete');
    Route::get('/citas/dashboard', [CitaController::class, 'citesDashBoard'])->name('cites.dashboard');

    //CRUD AJAX
    Route::get('input-form', [AjaxController::class, 'index']);
    Route::get('search-Autocomplete', [AjaxController::class, 'searchAutocomplete']);


    Route::get('input-form-Layout', [AjaxController::class, 'index']);
    Route::get('search-AutocompleteLayout', [AjaxController::class, 'searchAutocompleteLayout']);


    Route::prefix('auth-complete-search')->group(function(){
            Route::view('/','autocompletesearch.index');
            Route::get('search/{query}',[AjaxController::class,'index']);

    });

      //EDITAR PERFIL
    Route::get('/profile/update/{id}', [UserController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/profile/changeProfilePhoto', [UserController::class, 'changeProfilePhoto'])->name('profile.changeProfilePhoto');
    Route::post('/profile/changeProfilePhoto', [UserController::class, 'changeProfilePhotoUpdate'])->name('profile.changeProfilePhotoUpdate');
    //REESTABLECER CONTRASEÑA
    Route::get('/profile/changePassword', [UserController::class, 'changePassword'])->name('profile.changePassword');
    Route::patch('/profile/changePassword', [UserController::class, 'changePasswordUpdate'])->name('profile.changePasswordUpdate');
});


Route::controller(PageController::class)->group(function () {
    Route::get('/dashboard', 'dashboardOverview1')->name('dashboard-overview-1');
    Route::get('dashboard-overview-2-page', 'dashboardOverview2')->name('dashboard-overview-2');
    Route::get('dashboard-overview-3-page', 'dashboardOverview3')->name('dashboard-overview-3');
    Route::get('dashboard-overview-4-page', 'dashboardOverview4')->name('dashboard-overview-4');
    Route::get('categories-page', 'categories')->name('categories');
    Route::get('add-product-page', 'addProduct')->name('add-product');
    Route::get('product-list-page', 'productList')->name('product-list');
    Route::get('product-grid-page', 'productGrid')->name('product-grid');
    Route::get('transaction-list-page', 'transactionList')->name('transaction-list');
    Route::get('transaction-detail-page', 'transactionDetail')->name('transaction-detail');
    Route::get('seller-list-page', 'sellerList')->name('seller-list');
    Route::get('seller-detail-page', 'sellerDetail')->name('seller-detail');
    Route::get('reviews-page', 'reviews')->name('reviews');
    Route::get('inbox-page', 'inbox')->name('inbox');
    Route::get('file-manager-page', 'fileManager')->name('file-manager');
    Route::get('point-of-sale-page', 'pointOfSale')->name('point-of-sale');
    Route::get('chat-page', 'chat')->name('chat');
    Route::get('post-page', 'post')->name('post');
    Route::get('calendar-page', 'calendar')->name('calendar');
    Route::get('crud-data-list-page', 'crudDataList')->name('crud-data-list');
    Route::get('crud-form-page', 'crudForm')->name('crud-form');
    Route::get('users-layout-1-page', 'usersLayout1')->name('users-layout-1');
    Route::get('users-layout-2-page', 'usersLayout2')->name('users-layout-2');
    Route::get('users-layout-3-page', 'usersLayout3')->name('users-layout-3');
    Route::get('profile-overview-1-page', 'profileOverview1')->name('profile-overview-1');
    Route::get('profile-overview-2-page', 'profileOverview2')->name('profile-overview-2');
    Route::get('profile-overview-3-page', 'profileOverview3')->name('profile-overview-3');
    Route::get('wizard-layout-1-page', 'wizardLayout1')->name('wizard-layout-1');
    Route::get('wizard-layout-2-page', 'wizardLayout2')->name('wizard-layout-2');
    Route::get('wizard-layout-3-page', 'wizardLayout3')->name('wizard-layout-3');
    Route::get('blog-layout-1-page', 'blogLayout1')->name('blog-layout-1');
    Route::get('blog-layout-2-page', 'blogLayout2')->name('blog-layout-2');
    Route::get('blog-layout-3-page', 'blogLayout3')->name('blog-layout-3');
    Route::get('pricing-layout-1-page', 'pricingLayout1')->name('pricing-layout-1');
    Route::get('pricing-layout-2-page', 'pricingLayout2')->name('pricing-layout-2');
    Route::get('invoice-layout-1-page', 'invoiceLayout1')->name('invoice-layout-1');
    Route::get('invoice-layout-2-page', 'invoiceLayout2')->name('invoice-layout-2');
    Route::get('faq-layout-1-page', 'faqLayout1')->name('faq-layout-1');
    Route::get('faq-layout-2-page', 'faqLayout2')->name('faq-layout-2');
    Route::get('faq-layout-3-page', 'faqLayout3')->name('faq-layout-3');
    Route::get('register-page', 'register')->name('register');
    Route::get('error-page-page', 'errorPage')->name('error-page');
    Route::get('update-profile-page', 'updateProfile')->name('update-profile');
    Route::get('change-password-page', 'changePassword')->name('change-password');
    Route::get('regular-table-page', 'regularTable')->name('regular-table');
    Route::get('tabulator-page', 'tabulator')->name('tabulator');
    Route::get('modal-page', 'modal')->name('modal');
    Route::get('slide-over-page', 'slideOver')->name('slide-over');
    Route::get('notification-page', 'notification')->name('notification');
    Route::get('tab-page', 'tab')->name('tab');
    Route::get('accordion-page', 'accordion')->name('accordion');
    Route::get('button-page', 'button')->name('button');
    Route::get('alert-page', 'alert')->name('alert');
    Route::get('progress-bar-page', 'progressBar')->name('progress-bar');
    Route::get('tooltip-page', 'tooltip')->name('tooltip');
    Route::get('dropdown-page', 'dropdown')->name('dropdown');
    Route::get('typography-page', 'typography')->name('typography');
    Route::get('icon-page', 'icon')->name('icon');
    Route::get('loading-icon-page', 'loadingIcon')->name('loading-icon');
    Route::get('regular-form-page', 'regularForm')->name('regular-form');
    Route::get('datepicker-page', 'datepicker')->name('datepicker');
    Route::get('tom-select-page', 'tomSelect')->name('tom-select');
    Route::get('file-upload-page', 'fileUpload')->name('file-upload');
    Route::get('wysiwyg-editor-classic-page', 'wysiwygEditorClassic')->name('wysiwyg-editor-classic');
    Route::get('wysiwyg-editor-inline-page', 'wysiwygEditorInline')->name('wysiwyg-editor-inline');
    Route::get('wysiwyg-editor-balloon-page', 'wysiwygEditorBalloon')->name('wysiwyg-editor-balloon');
    Route::get('wysiwyg-editor-balloon-block-page', 'wysiwygEditorBalloonBlock')->name('wysiwyg-editor-balloon-block');
    Route::get('wysiwyg-editor-document-page', 'wysiwygEditorDocument')->name('wysiwyg-editor-document');
    Route::get('validation-page', 'validation')->name('validation');
    Route::get('chart-page', 'chart')->name('chart');
    Route::get('slider-page', 'slider')->name('slider');
    Route::get('image-zoom-page', 'imageZoom')->name('image-zoom');
});
