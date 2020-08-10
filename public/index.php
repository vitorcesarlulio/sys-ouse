<?php
require_once "../src/vendor/autoload.php"; //composer
use Jenssegers\Blade\Blade; //Blade template
use \PlugRoute\PlugRoute;
use \PlugRoute\RouteContainer;
use \PlugRoute\Http\RequestCreator;

$blade = new Blade('../app/View/', '../app/View/cache');

$route = new PlugRoute(new RouteContainer(), RequestCreator::create());

$route->notFound(function () use ($blade) {
    echo $blade->render('errors.404');
});

# Login
$route->group(['prefix' => '/login'], function ($route) use ($blade) {

    $route->get('', function () {
        include '../app/View/login/login.php';
    });

    $route->post('/verificar', function () {
        include '../app/View/login/check-login.php';
    });
});

$route->get('/', function () use ($blade) {
    echo $blade->render('home.home');
});

$route->get('/cadastro', function () use ($blade) {
    echo $blade->render('cadastro.cadastro');
});

/**
 * Rotas Agenda
 */
$route->group(['prefix' => '/agenda'], function ($route) use ($blade) {

    #Calendario
    $route->get('/calendario', function () use ($blade) {
        echo $blade->render('schedule.schedule-calendar.schedule-calendar');
    });

    $route->get('/calendario/listar', function () {
        include '../app/View/schedule/schedule-calendar/list-event.php';
    });

    $route->post('/calendario/cadastar', function () {
        include '../app/View/schedule/schedule-calendar/register-event.php';
    });

    $route->post('/calendario/editar', function () {
        include '../app/View/schedule/schedule-calendar/edit-event.php';
    });

    $route->get('/calendario/apagar/', function () {
        include '../app/View/schedule/schedule-calendar/delete-events.php';
    });

    #Eventos
    $route->get('/eventos', function () use ($blade) {
        echo $blade->render('schedule.schedule-events.schedule-events');
    });

    $route->post('/eventos/listar', function () {
        include '../app/View/schedule/schedule-events/list-events.php';
    });

    $route->post('/eventos/apagar', function () {
        include '../app/View/schedule/schedule-events/delete-event.php';
    });

    $route->post('/eventos/mudar-status', function () {
        include '../app/View/schedule/schedule-events/update-status.php';
    });
});

# Orçamento
$route->group(['prefix' => '/orcamentos'], function ($route) use ($blade) {

    $route->get('', function () use ($blade) {
        echo $blade->render('budgets.budgets');
    });

    $route->get('/editar', function () use ($blade) {
        echo $blade->render('budgets.edit-budget.edit-budget');
    });

    $route->post('/listar', function () {
        include '../app/View/budgets/list-budgets.php';
    });
});

# Usuarios
$route->group(['prefix' => '/usuarios'], function ($route) use ($blade) {

    $route->get('', function () use ($blade) {
        echo $blade->render('users.users');
    });

    $route->post('/listar', function () {
        include '../app/View/users/list-users.php';
    });

    $route->post('/apagar', function () {
        include '../app/View/users/delete-users.php';
    });

    $route->post('/cadastrar', function () {
        include '../app/View/users/register-user.php';
    });

    $route->post('/listar-editar', function () {
        include '../app/View/users/list-user-edit.php';
    });
});

$route->on();
