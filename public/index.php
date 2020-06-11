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
#Calendário
$route->get('/calendario', function() use ($blade) {
    echo $blade->render('schedule.calendar');
});

$route->get('/calendario/listar', function() {
    include '../app/View/schedule/list_eventos.php';
});

$route->post('/calendario/cadastar', function() {
    include '../app/View/schedule/cad_event.php';
});

$route->post('/calendario/editar', function() {
    include '../app/View/schedule/edit_event.php';
});

$route->get('/calendario/apagar/', function() {
    include '../app/View/schedule/proc_apagar_evento.php';
});

//$route->delete('/agenda/apagar/{id:\d+}', function() {
//    include '../app/View/agenda/proc_apagar_evento.php';
//});

#Eventos
$route->get('/eventos', function() use ($blade) {
    echo $blade->render('schedule.schedule-events.schedule-events');
});

$route->on();


