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


$route->get('/home', function() use ($blade) {
    echo $blade->render('home.home');
});

$route->get('/cadastro', function() use ($blade) {
    echo $blade->render('cadastro.cadastro');
});

#Eventos
#$route->get('/agenda/eventos', function() use ($blade) {
#    echo $blade->render('schedule.schedule-events.schedule-events');
#});

/**
 * Rotas Agenda
 */
$route->group(['prefix' => '/agenda'], function($route) use ($blade){

    #Calendario
    $route->get('/calendario', function() use ($blade){
        echo $blade->render('schedule.schedule-calendar.schedule-calendar');
    });

    $route->get('/calendario/listar', function() {
        include '../app/View/schedule/schedule-calendar/list-event.php';
    });
    
    $route->post('/calendario/cadastar', function() {
        include '../app/View/schedule/schedule-calendar/register-event.php';
    });

    $route->post('/calendario/editar', function() {
        include '../app/View/schedule/schedule-calendar/edit-event.php';
    });
    
    $route->get('/calendario/apagar/', function() {
        include '../app/View/schedule/schedule-calendar/delete-events.php';
    });

    #Eventos
    $route->get('/eventos', function() use ($blade){
        echo $blade->render('schedule.schedule-events.schedule-events');
    });

    $route->post('/eventos/listar', function() {
        include '../app/View/schedule/schedule-events/list-events.php';
    });

    $route->post('/eventos/apagar', function() {
        include '../app/View/schedule/schedule-events/delete-event.php';
    });

    $route->get('/eventos/editar', function() {
        include '../app/View/schedule/schedule-events/edit-event.php';
    });

    
});

$route->on();


