<?php
use Symfony\Component\HttpFoundation\Request;

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

$app->get('/cours/{id}', function ($id) use ($app) {
    $cours = $app['dao.cours']->find($id);
    return $app['twig']->render('cours.html.twig', array('cours' => $cours));
})->bind('coursDetail');


$app->get('/cours', function () use ($app) {
    $str =  $app['user']->getId();
    $listCours = $app['dao.cours']->findByTeacher($str);
    return $app['twig']->render('index.html.twig' ,array('coursList' =>$listCours));
})->bind('cours');

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('empty.html.twig');
})->bind('home');

// Article details with comments
