<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EncomendasController;
use App\Http\Controllers\EstampasController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;


Route::get('/', [EstampasController::class, 'index'])->name('home');
Route::get('catalogo', [EstampasController::class, 'catalogo'])->name('catalogo');
Route::get('/catalogo/{categoria}', [EstampasController::class, 'categoria'])->name('categoria');
Route::get('/carrinho', [CompraController::class, 'carrinho'])->name('carrinho');
Route::post('/carrinho/{estampa}', [CompraController::class, 'store_pedido'])->name('carrinho.store_pedido');
Route::delete('carrinho/destroy', [CompraController::class, 'destroy'])->name('carrinho.destroy');
Route::delete('carrinho', [CompraController::class, 'destroy_pedido'])->name('carrinho.destroy_pedido');
Route::put('carrinho/update', [CompraController::class, 'update_pedido'])->name('carrinho.update_pedido');


Route::get('faturas/{fatura}', [EncomendasController::class, 'mostrarFatura'])->name('fatura.mostrar');

Route::middleware(['auth', 'cliente'])->prefix('/')->name('usuario.')->group(function () {

    Route::get('estampa_personalizada', [EstampasController::class, 'estampa_personalizada'])->name('estampa_personalizada');
    Route::get('estampa_personalizada/{id}', [EstampasController::class, 'estampa_personalizada'])->name('estampa_personalizada.id');
    Route::post('estampa_personalizada', [EstampasController::class, 'store_estampa_privada'])->name('estampa.store');
    Route::get('perfil', [ClienteController::class, 'perfil'])->name('perfil');
    Route::put('perfil/{cliente}', [ClienteController::class, 'updateClientesInfo'])->name('clientes.update');
    Route::delete('perfil/{cliente}/foto', [ClienteController::class, 'destroy_foto'])->name('clientes.foto.destroy');

    Route::middleware(['carrinhoEmpty'])->group(function() {

        Route::get('checkout', [CompraController::class, 'checkout'])->name('checkout')
            ->middleware('verified');
        Route::post('carrinho', [CompraController::class, 'store_compra'])->name('carrinho.store_compra');
    });

});

Route::middleware('estampaValida')->prefix('catalogo')->name('catalogo.')->group(function () { //Serve para verificar se quem está a ver a
                                                                                        //estampa a pode ver
    Route::get('estampa/{estampa}', [EstampasController::class, 'estampa_detail'])->name('estampa');
    Route::get('estampa/{estampa}/private', [EstampasController::class, 'getEstampa'])->name('estampa.privada');
    Route::delete('estampa/{estampa}', [EstampasController::class, 'destroy_estampa_privada'])->name('estampa.destroy');

});


Route::middleware(['auth', 'staff'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('encomendas', [EncomendasController::class, 'view_encomendas'])->name('encomendas');
    Route::get('perfil/{staff}/alterarpassword', [StaffController::class, 'staffChangePass'])->name('alterarpass');
    Route::put('perfil/{staff}/alterarpassword', [StaffController::class, 'updatestaffPass'])->name('pass.update');
    Route::post('encomendas/estado', [EncomendasController::class, 'mudarEstado'])->name('encomenda.mudar.estado');
    Route::get('encomendas/{encomenda}/detalhes', [EncomendasController::class, 'detalhes_encomenda'])->name('encomenda.detalhes_encomenda');
    Route::get('estampa/{tshirt}/private/encomendas', [EstampasController::class, 'getEstampaPrivadaEncomenda'])->name('estampa.privada');


    Route::middleware(['admin'])->group(function() {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //TODO: Clientes
        Route::get('clientes', [ClienteController::class, 'admin_view_clientes'])->name('clientes');
        Route::get('clientes/{cliente}/encomendas/', [ClienteController::class, 'admin_encomendas'])->name('clientes.encomendas');
        Route::post('clientes', [ClienteController::class, 'bloquearDesbloquearClientes'])->name('clientes.unlock');
        Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
         //->middleware('can:delete,cliente'); Não funciona

        //TODO: Staff
        Route::get('staff', [StaffController::class, 'admin'])->name('staff');
        Route::post('staff/block', [StaffController::class, 'bloquearDesbloquearStaff'])->name('staff.unlock');
        Route::delete('staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
        Route::put('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::delete('staff/{staff}/foto', [StaffController::class, 'destroy_foto'])->name('staff.foto.destroy');

        //TODO: Precos
        Route::get('precos', [DashboardController::class, 'view_precos'])->name('precos');
        Route::get('precos/{precos}/edit', [DashboardController::class, 'edit_precos'])->name('precos.edit');
        Route::put('precos/{precos}', [DashboardController::class, 'update_precos'])->name('precos.update');

        //TODO: Categorias
        Route::get('categorias', [DashboardController::class, 'view_categorias'])->name('categorias');
        Route::get('categorias/create', [DashboardController::class, 'create_categoria'])->name('categorias.create');
        Route::post('categorias', [DashboardController::class, 'store_categoria'])->name('categorias.store');
        Route::get('categorias/{categoria}/edit', [DashboardController::class, 'edit_categoria'])->name('categorias.edit');
        Route::put('categorias/{categoria}', [DashboardController::class, 'update_categoria'])->name('categorias.update');
        Route::delete('categorias/{categoria}', [DashboardController::class, 'destroy_categoria'])->name('categorias.destroy');

        //TODO: Estampas
        Route::get('estampas', [EstampasController::class, 'admin_view_estampas'])->name('estampas');
        Route::get('estampas/create', [EstampasController::class, 'create'])->name('estampas.create');
        Route::post('estampas', [EstampasController::class, 'store'])->name('estampas.store');
        Route::get('estampas/{estampa}/edit', [EstampasController::class, 'edit'])->name('estampas.edit');
        Route::put('estampas/{estampa}', [EstampasController::class, 'update'])->name('estampas.update');
        Route::delete('estampas/{estampa}', [EstampasController::class, 'destroy'])->name('estampas.destroy');

        //TODO: Cores
        Route::get('cores', [DashboardController::class, 'view_cores'])->name('cores');
        Route::get('cores/create', [DashboardController::class, 'create_cor'])->name('cores.create');
        Route::post('cores', [DashboardController::class, 'store_cor'])->name('cores.store');
        Route::get('cores/{cor}/edit', [DashboardController::class, 'edit_cor'])->name('cores.edit');
        Route::put('cores/{cor}', [DashboardController::class, 'update_cor'])->name('cores.update');
        Route::delete('cores/{cor}', [DashboardController::class, 'destroy_cor'])->name('cores.destroy');

    });
});

Auth::routes(['verify' => true]);

