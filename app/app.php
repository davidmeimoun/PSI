<?php

date_default_timezone_set('Europe/Paris');

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
           'form' => array('login_path' => '/login', 'check_path' => '/login_check', 'default_target_path' => '/cours'),
            'users' => function () use ($app) {
                 return new GestionnaireLivret\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

          
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());  
            
// Register services
$app['dao.diplome'] = function ($app) {
    return new GestionnaireLivret\DAO\DiplomeDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new GestionnaireLivret\DAO\UserDAO($app['db']);
};

$app['dao.cours'] = function ($app) {
    return new GestionnaireLivret\DAO\CoursDAO($app['db']);
};

$app['dao.ue'] = function ($app) {
    return new GestionnaireLivret\DAO\UeDAO($app['db']);
};
$app['dao.parcours'] = function ($app) {
    return new GestionnaireLivret\DAO\ParcoursDAO($app['db']);
};
$app['dao.presentationEc'] = function ($app) {
    return new GestionnaireLivret\DAO\PresentationEcDAO($app['db']);
};
$app['dao.livret'] = function ($app) {
   return new GestionnaireLivret\DAO\LivretDAO($app['db']);
};
$app['dao.organigramme'] = function ($app) {
   return new GestionnaireLivret\DAO\OrganigrammeDAO($app['db']);
};
