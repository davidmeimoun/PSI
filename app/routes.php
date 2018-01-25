<?php
use Symfony\Component\HttpFoundation\Request;
use GestionnaireLivret\Domain\Cours;
use GestionnaireLivret\Domain\User;
use GestionnaireLivret\Form\Type\UserType;

// Add a user
$app->match('/admin/user/add', function(Request $request) use ($app) {
    $user = new User();
    $teachers = $app['dao.user']->getAllTeacher();
    $userForm = $app['form.factory']->create(UserType::class, $user, array('teacher_choices' => $teachers));
    $userForm->handleRequest($request);
    
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        // Retrieve select teacher informations
        $teacherID = $user->getId()->getId();
        $teacherNumHarpege = $user->getId()->getNumHarpege();
        $teacherEmail = $user->getId()->getEmail();
        $teacherName = $user->getId()->getNom();
        $teacherFirstName = $user->getId()->getPrenom();
        //Update user informations
        $user->setId($teacherID);
        $user->setNumHarpege($teacherNumHarpege);
        $user->setEmail($teacherEmail);
        $user->setNom($teacherName);
        $user->setPrenom($teacherFirstName);
        // generate a random salt value
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $plainPassword = $user->getPassword();
        // find the default encoder
        $encoder = $app['security.encoder.bcrypt'];
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'New user',
        'userForm' => $userForm->createView()));
})->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $teacher = $app['dao.user']->getEditTeacher($id);
    $userForm = $app['form.factory']->create(UserType::class, $user, array('teacher_choices' => $teacher));
    $userForm->handleRequest($request);
    
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        $teacherID = $user->getId()->getId();
        $teacherNumHarpege = $user->getId()->getNumHarpege();
        $teacherEmail = $user->getId()->getEmail();
        $teacherName = $user->getId()->getNom();
        $teacherFirstName = $user->getId()->getPrenom();
        //Update user informations
        $user->setId($teacherID);
        $user->setNumHarpege($teacherNumHarpege);
        $user->setEmail($teacherEmail);
        $user->setNom($teacherName);
        $user->setPrenom($teacherFirstName);
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'Edit user',
        'userForm' => $userForm->createView()));
})->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Delete the user
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_user_delete');


$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

$app->get('/cours/{id}', function ($id) use ($app) {
    $cours = $app['dao.cours']->find($id);
    $presentation = $app['dao.presentationEc']->findByEC($cours->getId_ligne());
    $cours -> setPresentation($presentation);
            
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

$app->get('/admin', function() use ($app) {
    $cours = $app['dao.cours']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
        'coursList' => $cours,
        'users' => $users));
})->bind('admin');


// Article details with comments
$app->get('/ue/{id}', function ($id) use ($app) {
  
    $listUe = $app['dao.ue']->findByParcours($id);
    $ec = array();
    foreach($listUe as $ue)
    {
        $ec = $app['dao.cours']->findByUE($ue->getId());
       $ue->setEc($ec);
    }
        
        return $app['twig']->render('ue.html.twig' ,array('ueList' =>$listUe, 'parcours' => $id));
    
})->bind('ue');
$app->get('/parcours', function () use ($app) {
  
    $listParcours = $app['dao.parcours']->findAll();     
        return $app['twig']->render('parcours.html.twig' ,array('parcoursList' =>$listParcours));
    
})->bind('parcours');
$app->get('/generatePDF/{id}', function ($id) use ($app) {
 
    $return = shell_exec('wkhtmltopdf http://localhost/PSI/web/index.php/ue/'.$id.' /var/www/html/PSI/web/livret'.$id.'.pdf');    //$return = shell_exec('wkhtmltopdf http://localhost/GestionnaireLivret/Livret/web/index.php/ue/'+$id+' /var/html/GestionnaireLivret/Livret/views/livret.pdf');     
    return $app->redirect('http://localhost:8085/PSI/web/livret'.$id.'.pdf');
})->bind('generatePDF');
$app->get('/generateMarkdown/{id}', function ($id) use ($app) {
    
$return = shell_exec('pandoc -s -r html http://localhost/PSI/web/index.php/ue/'.$id.' -o /var/www/html/PSI/web/livret'.$id.'.text ');//readfile("http://localhost/GestionnaireLivret/Livret/web/index.pdf/");
        return $app->redirect('http://localhost:8085/PSI/web/livret'.$id.'.text');
})->bind('generateMarkdown');
$app->get('/enseignements/{id}', function ($id) use ($app) {
  
    $listUe = $app['dao.ue']->findByParcours($id);
    $ec = array();
    foreach($listUe as $ue)
    {
        $ec = $app['dao.cours']->findByUE($ue->getId());
            foreach($ec as $e){
                $presentation = $app['dao.presentationEc']->findByEC($e->getId_ligne());
                $e -> setPresentation($presentation);
            }
       $ue->setEc($ec);
    }
        
        return $app['twig']->render('enseignements.html.twig' ,array('ueList' =>$listUe, 'parcours' => $id));
    
})->bind('enseignements');
