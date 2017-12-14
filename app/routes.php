<?php


$app->get('/cours/{id}', function ($id) use ($app) {
    $cours = $app['dao.cours']->find($id);
    return $app['twig']->render('cours.html.twig', array('cours' => $cours));
})->bind('cours');

// Home page
$app->get('/', function () use ($app) {
    $str = 962;
    $listCours = $app['dao.cours']->findByTeacher($str);
    return $app['twig']->render('index.html.twig' ,array('coursList' =>$listCours));
})->bind('home');

// Article details with comments
