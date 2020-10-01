<?php
require_once "../src/vendor/autoload.php"; //composer
use Jenssegers\Blade\Blade; //Blade template
use \PlugRoute\PlugRoute;
use \PlugRoute\RouteContainer;
use \PlugRoute\Http\RequestCreator;

$blade = new Blade('../app/View/', '../app/View/cache');

$route = new PlugRoute(new RouteContainer(), RequestCreator::create());

/**
 * Login
 */
$route->get('/', function () {
    #Verifico se ja esta logado e direciono para home
/* if (isset($_SESSION['login']) && isset($_SESSION['name']) && isset($_SESSION['canary']) && isset($_SESSION['name']) && isset($_SESSION['loginUser']) && isset($_SESSION['permition'])) {
    echo " <script> window.location.href='/home'; </script> ";
} */
    include '../app/View/login/login.php';
});

$route->post('/verificar-login', function () {
    include '../app/View/login/validation-login.php';
});

$route->get('/logout', function () {
    include '../app/View/login/logout.php';
});

/**
 * Home
 */
$route->get('/home', function () use ($blade) {
    echo $blade->render('home.home');
});

/**
 * Rota de Erros
 */
$route->notFound(function () use ($blade) {
    echo $blade->render('errors.404');
});

/**
 * Rotas Agenda
 */
$route->group(['prefix' => '/agenda'], function ($route) use ($blade) {

    # Calendário
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

    $route->post('/calendario/apagar', function () {
        include '../app/View/schedule/schedule-calendar/delete-events.php';
    });

    # Eventos
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

/**
 * Orçamento
 */
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

/**
 * Pessoas
 */
$route->group(['prefix' => '/pessoas'], function ($route) use ($blade) {

    $route->get('', function () use ($blade) {
        echo $blade->render('people.people');
    });
    $route->post('/listar', function () {
        include '../app/View/people/list-people.php';
    });

    $route->post('/verificar-existencia-pessoa', function () {
        include '../app/View/people/check-people-existence.php';
    });
    $route->post('/cadastrar', function () {
        include '../app/View/people/register-people.php';
    });

    $route->post('/listar-editar', function () {
        include '../app/View/people/list-people-edit.php';
    });
    $route->post('/editar', function () {
        include '../app/View/people/edit-people.php';
    });
    $route->post('/listar-contatos', function () {
        include '../app/View/people/list-people-contact.php';
    });
    $route->post('/deletar-contato', function () {
        include '../app/View/people/delete-contact.php';
    });
    $route->post('/cadastrar-contato', function () {
        include '../app/View/people/register-contact.php';
    });

    $route->post('/apagar', function () {
        include '../app/View/people/delete-people.php';
    });
});

/**
 * Usuários
 */
$route->group(['prefix' => '/usuarios'], function ($route) use ($blade) {

    $route->get('', function () use ($blade) {
        echo $blade->render('users.users');
    });

    $route->post('/listar', function () {
        include '../app/View/users/list-users.php';
    });

    $route->post('/verificar-existencia-usuario', function () {
        include '../app/View/users/check-user-existence.php';
    });

    $route->post('/cadastrar', function () {
        include '../app/View/users/register-user.php';
    });

    $route->post('/listar-editar', function () {
        include '../app/View/users/list-user-edit.php';
    });

    $route->post('/editar', function () {
        include '../app/View/users/edit-user.php';
    });

    $route->post('/apagar', function () {
        include '../app/View/users/delete-users.php';
    });
});

# Carregar
$route->get('/carregar', function () {
    include '../app/View/templates/loading.php';
});

$route->on();
