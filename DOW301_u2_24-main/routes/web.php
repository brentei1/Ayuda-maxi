<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\EstadiosController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el inicio de sesión
Route::post('/login', [LoginController::class, 'login']);

// Ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');
return redirect()->route('login');

// Rutas de autenticación

Route::get('/login', [UsuariosController::class, 'showLoginForm'])->name('usuarios.login'); // Mostrar formulario de inicio de sesión
Route::post('/login', [UsuariosController::class, 'login'])->name('usuarios.login.submit'); // Procesar inicio de sesión
Route::post('/logout', [UsuariosController::class, 'logout'])->name('usuarios.logout'); // Procesar cierre de sesión
Route::get('/register', [UsuariosController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UsuariosController::class, 'register']);

// Rutas de autenticación para invitados
Route::middleware('guest')->group(function () {
    Route::get('login', [HomeController::class, 'login'])->name('home.login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Página de inicio del usuario autenticado
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // Rutas de perfil de usuario
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit'); // Mostrar formulario de edición de perfil
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update'); // Actualizar perfil de usuario
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Eliminar perfil de usuario
    Route::get('/perfil/{user}', [ProfileController::class, 'show'])->name('profile.show'); // Mostrar perfil de usuario

    // Rutas de equipos
    Route::resource('equipos', EquiposController::class)->except(['show']); // Recurso para gestionar equipos

    // Rutas de jugadores
    Route::resource('jugadores', JugadoresController::class)->only(['index', 'store']); // Recurso para gestionar jugadores

    // Rutas de partidos
    Route::get('/partidos', [PartidosController::class, 'index'])->name('partidos.index'); // Listado de partidos
    Route::get('/partidos/create', [PartidosController::class, 'create'])->name('partidos.create'); // Mostrar formulario de crear partido
    Route::post('/partidos', [PartidosController::class, 'store'])->name('partidos.store'); // Almacenar nuevo partido
    Route::get('/partidos/{partido}', [PartidosController::class, 'show'])->name('partidos.show'); // Mostrar detalles del partido
    Route::get('/partidos/{partido}/edit', [PartidosController::class, 'edit'])->name('partidos.edit'); // Mostrar formulario de edición del partido
    Route::put('/partidos/{partido}', [PartidosController::class, 'update'])->name('partidos.update'); // Actualizar partido
    Route::delete('/partidos/{partido}', [PartidosController::class, 'destroy'])->name('partidos.destroy'); // Eliminar partido

    // Rutas de estadísticas
    Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas.index'); // Listado de estadísticas
    Route::get('/estadisticas/create', [EstadisticasController::class, 'create'])->name('estadisticas.create'); // Mostrar formulario de crear estadística
    Route::post('/estadisticas', [EstadisticasController::class, 'store'])->name('estadisticas.store'); // Almacenar nueva estadística
    Route::get('/estadisticas/{estadisticas}', [EstadisticasController::class, 'show'])->name('estadisticas.show'); // Mostrar detalles de la estadística
    Route::get('/estadisticas/{estadisticas}/edit', [EstadisticasController::class, 'edit'])->name('estadisticas.edit'); // Mostrar formulario de edición de estadística
    Route::put('/estadisticas/{estadisticas}', [EstadisticasController::class, 'update'])->name('estadisticas.update'); // Actualizar estadística
    Route::delete('/estadisticas/{estadisticas}', [EstadisticasController::class, 'destroy'])->name('estadisticas.destroy'); // Eliminar estadística
    Route::get('/estadisticas/create/{partido_id}', [EstadisticasController::class, 'create'])->name('estadisticas.create'); // Crear estadística para un partido específico
});

// Rutas protegidas por autenticación y autorización de administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdministracionController::class, 'index'])->name('admin.index'); // Panel de administración

    // Ruta para mostrar el formulario de crear usuario administrador
    Route::get('/usuarios/crear-admin', [UsuariosController::class, 'showCrearAdminForm'])->name('usuarios.showCrearAdminForm'); // Mostrar formulario para crear usuario administrador
    Route::post('/usuarios/crear-admin', [UsuariosController::class, 'storeAdmin'])->name('usuarios.storeAdmin'); // Almacenar nuevo usuario administrador

    // Rutas de estadios
    Route::resource('estadios', EstadiosController::class)->except(['show']); // Recurso para gestionar estadios

    // Rutas de usuarios solo para administradores
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index'); // Listado de Usuarios
    Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create'); // Mostrar formulario para crear usuario
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store'); // Almacenar nuevo usuario
});

// Ruta para la vista de inicio de sesión
Route::view('/auth/login', 'auth.login')->name('auth.login'); // Vista de inicio de sesión

// Ruta para generar una contraseña hash
Route::get('/generate', function () {
    return Hash::make('password123');
});
