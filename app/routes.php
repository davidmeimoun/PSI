<?php
use Symfony\Component\HttpFoundation\Request;
use GestionnaireLivret\Domain\Cours;
use GestionnaireLivret\Domain\User;

use GestionnaireLivret\Domain\PresentationEc;
use GestionnaireLivret\Form\Type\PasswordTypea;
use GestionnaireLivret\Form\Type\UserType;
use GestionnaireLivret\Form\Type\PresentationEcType;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

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




// Edit an existing user
$app->match('/user/{id}/editPassword', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $teacher = $app['dao.user']->getEditTeacher($id);
    $userForm = $app['form.factory']->create(PasswordTypea::class, $user, array('teacher_choices' => $teacher));
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
    return $app['twig']->render('password_form.html.twig', array(
        'title' => 'Edit user',
        'userForm' => $userForm->createView()));
})->bind('editPassword');


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


$app->match('/cours/{id}', function ($id, Request $request) use ($app) {
    $cours = $app['dao.cours']->find($id);
    $presentation = $app['dao.presentationEc']->findByEC($cours->getId_ligne());
    $cours -> setPresentation($presentation);
    //Cas où nous n'avons pas de presentation pour un EC
    if($presentation==null){
        $objectifs = "";
        $competences = "";
        $prerequis = "";
        $plan_cours = "";
        $bibliographie = "";
        $cours_en_ligne = "";
        $modalite_controle = "";
        $erasmus = "";
    } else {
        $objectifs = $presentation->getObjectifs();
        $competences = $presentation->getCompetences();
        $prerequis = $presentation->getPrerequis();
        $plan_cours = $presentation->getPlanCours();
        $bibliographie = $presentation->getBibliographie();
        $cours_en_ligne = $presentation->getCoursEnLigne();
        $modalite_controle = $presentation->getModaliteControle();
        $erasmus = $presentation->getErasmus();
    }

    
    $presentationEcForm = $app['form.factory']->create(PresentationEcType::class, $presentation, array('objectifs' => $objectifs,'competences' =>$competences ,
        'prerequis' => $prerequis,'plan_cours' => $plan_cours,'bibliographie' => $bibliographie,'cours_en_ligne' => $cours_en_ligne,
        'modalite_controle' => $modalite_controle,'erasmus' =>$erasmus ));
    $presentationEcForm->handleRequest($request);
    
    if ($presentationEcForm->isSubmitted() && $presentationEcForm->isValid()) {
        $presEc = new PresentationEc();
        $presEc->setFidEc($cours->getId_ligne());
        $presEc->setIdPresentation($cours->getId_ligne());
        $presEc->setObjectifs($presentationEcForm['objectifs']->getData());
        $presEc->setCompetences($presentationEcForm['competences']->getData());
        $presEc->setPrerequis($presentationEcForm['prerequis']->getData());
        $presEc->setPlanCours($presentationEcForm['plan_cours']->getData());
        $presEc->setBibliographie($presentationEcForm['bibliographie']->getData());
        $presEc->setCoursEnLigne($presentationEcForm['cours_en_ligne']->getData());
        $presEc->setModaliteControle($presentationEcForm['modalite_controle']->getData());
        $presEc->setErasmus($presentationEcForm['erasmus']->getData());
        
        $app['dao.presentationEc']->save($presEc);
        $app['session']->getFlashBag()->add('success', 'The informations was successfully saved.');
    }
            
    return $app['twig']->render('cours.html.twig', array('cours' => $cours,'presentationEcForm' => $presentationEcForm->createView()));

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

$app->get('/verifNewUser', function () use ($app) {
  $str = $app['user']->getNewUser();
  $id =  $app['user']->getId();
  if( $str  != 1 ){
     return $app->redirect('http://localhost:8085/PSI/web/index.php/cours');
  }
  else{
       return $app->redirect('http://localhost:8085/PSI/web/index.php/user/'.$id.'/editPassword');
  }
    
       
    
})->bind('verifNewUser');


$app->get('/generatePDF/{id}', function ($id) use ($app) {
 
    shell_exec('sudo wkhtmltopdf http://localhost/PSI/web/index.php/livret/'.$id.' /var/www/html/PSI/web/livret'.$id.'.pdf');    //$return = shell_exec('wkhtmltopdf http://localhost/GestionnaireLivret/Livret/web/index.php/ue/'+$id+' /var/html/GestionnaireLivret/Livret/views/livret.pdf');     
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

$app->get('/livret/{id}', function ($id) use ($app) {

   // On récupère la mention
   $mention = $app['dao.livret']->findMention($id);
   
   // On récupère le calendrier
   $calendrier = $app['dao.livret']->findCalendrier($id);
   // On récupère l'organigramme
   $organigramme = $app['dao.organigramme']->find($id);
   
   
   // On récupère la présentation de l'UE
   $presentationForm = $app['dao.livret']->findPresentation($id);
   
   // On récupère la charte du vivre ensemble
   $charte = $app['dao.livret']->findCharte();
   
   // On récupère les modalités de controle
   $modalites = $app['dao.livret']->findModalitesControle($id);
 
   // On récupère les stages
   $stages = $app['dao.livret']->findStages($id);
   
   // On récupère les modules enseignements
   $modules = $app['dao.livret']->findModulesEnseignement($id);
   
   // On récupère les UE et EC d'un parcours
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
       
       return $app['twig']->render('livret.html.twig' ,array('mention'=>$mention, 'ueList' =>$listUe, 'parcours' => $id, 'organigramme'=>$organigramme, 'presentationForm'=>$presentationForm, 'charte'=>$charte,'modalites'=>$modalites,'stages'=>$stages,'modules'=>$modules, 'calendrier'=>$calendrier));
   
})->bind('livret');
