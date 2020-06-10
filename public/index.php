<?php
require_once "../src/vendor/autoload.php"; //composer
use Jenssegers\Blade\Blade; //Blade template
use \PlugRoute\PlugRoute;
use \PlugRoute\RouteContainer;
use \PlugRoute\Http\RequestCreator;

$blade = new Blade('../app/View/', '../app/View/cache');

$route = new PlugRoute(new RouteContainer(), RequestCreator::create());

$route->notFound(function() use ($blade){
    echo $blade->render('errors.404');
});
$route->getNotFound(function() use ($blade){
    echo $blade->render('errors.404');
});

$route->get('/home', function() use ($blade) {
    echo $blade->render('home.home');
});

/**
 * Rotas Cadastro
 */
$route->get('/cadastro', function() use ($blade) {
    echo $blade->render('cadastro.cadastro');
});

$route->post('/cadastrar', function() {
    include '../app/View/cadastro/cadastrar.php';
});

/**
 * Rotas Agenda
 */
$route->get('/agenda', function() use ($blade) {
    echo $blade->render('agenda.agenda');
});

$route->get('/agenda/listar', function() {
    include '../app/View/agenda/list_eventos.php';
});

$route->post('/agenda/cadastar', function() {
    include '../app/View/agenda/cad_event.php';
});

$route->post('/agenda/editar', function() {
    include '../app/View/agenda/edit_event.php';
});

$route->get('/agenda/apagar/', function() {
    include '../app/View/agenda/proc_apagar_evento.php';
});

//$route->delete('/agenda/apagar/{id:\d+}', function() {
//    include '../app/View/agenda/proc_apagar_evento.php';
//});

$route->on();


