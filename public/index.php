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

/**
 * Verificar Login
 */
$route->post('/verificar-login', function () {
    include '../app/View/login/validation-login.php';
});

/**
 * Loading
 */
$route->get('/carregar', function () {
    include '../app/View/templates/loading.php';
});

/**
 * Home
 */
$route->get('/home', function () use ($blade) {
    echo $blade->render('home.home');
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

    $route->post('/eventos/atualizar-status', function () {
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
 * Rotas Financeiro
 */
$route->group(['prefix' => '/financeiro'], function ($route) use ($blade) {

    # Contas a Receber
    $route->get('/contas-a-receber', function () use ($blade) {
        echo $blade->render('finance.accounts-receivable.accounts-receivable');
    });

    $route->post('/contas-a-receber/listar', function () {
        include '../app/View/finance/accounts-receivable/list-accounts-receivable.php';
    });

    $route->post('/contas-a-receber/cadastar', function () {
        include '../app/View/finance/accounts-receivable/register-account-receivable.php';
    });

    $route->post('/contas-a-receber/editar', function () {
        include '../app/View/finance/accounts-receivable/edit-account-receivable.php';
    });

    $route->post('/contas-a-receber/apagar', function () {
        include '../app/View/finance/accounts-receivable/delete-account-receivable.php';
    });

    # Contas a Pagar
    $route->get('/contas-a-pagar', function () use ($blade) {
        echo $blade->render('finance.accounts-payable.account-payable');
    });

    $route->post('/contas-a-pagar/cadastar', function () {
        include '../app/View/finance/accounts-payable/register-account-payable.php';
    });

    $route->post('/contas-a-pagar/listar', function () {
        include '../app/View/finance/accounts-payable/list-account-payable.php';
    });

    $route->post('/contas-a-pagar/editar', function () {
        include '../app/View/finance/accounts-payable/edit-account-payable.php';
    });

    $route->post('/contas-a-pagar/apagar', function () {
        include '../app/View/finance/accounts-payable/delete-account-payable.php';
    });

    # Formas de Pagamento
    $route->get('/formas-de-pagamento', function () use ($blade) {
        echo $blade->render('finance.payment-method.payment-method');
    });
    $route->post('/formas-de-pagamento/listar', function () {
        include '../app/View/finance/payment-method/list-payment-method.php';
    });
    $route->post('/formas-de-pagamento/verificar-existencia-forma-de-pagamento', function () {
        include '../app/View/finance/payment-method/check-payment-method-existence.php';
    });
    $route->post('/formas-de-pagamento/cadastar', function () {
        include '../app/View/finance/payment-method/register-payment-method.php';
    });
    $route->post('/formas-de-pagamento/apagar', function () {
        include '../app/View/finance/payment-method/delete-payment-method.php';
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

/**
 * Rota de Erros
 */
$route->notFound(function () use ($blade) {
    echo $blade->render('templates.404');
});

/**
 * Logout
 */
$route->get('/logout', function () {
    include '../app/View/login/logout.php';
});

/**
 * Backup
 */
$route->get('/backup', function () {
    include '../app/View/backup/backup.php';
});

$route->on();
