<?php
use Symfony\Component\HttpFoundation\Request;
use GestionnaireLivret\Domain\Cours;
use GestionnaireLivret\Domain\User;
use GestionnaireLivret\Domain\Livret;
use GestionnaireLivret\Domain\Organigramme;
use GestionnaireLivret\Domain\ModulesEnseignement;
use GestionnaireLivret\Domain\ModalitesControle;
use GestionnaireLivret\Domain\Domaine;
use GestionnaireLivret\Domain\Semestre;
    
use GestionnaireLivret\Domain\PresentationEc;
use GestionnaireLivret\Form\Type\PasswordTypea;
use GestionnaireLivret\Form\Type\UserType;
use GestionnaireLivret\Form\Type\PresentationEcType;
use GestionnaireLivret\Form\Type\EditLivretType;
    
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
    $listIdDiplome=array();
    $listDomaine = array();
        
        
    //recupere la list des id des diplomes pour un prof
    $listCours = $app['dao.cours']->findByTeacher($str);
       foreach($listCours as $cours){
           
           $idDiplome = $cours->getDiplome();
           $diplome = $app['dao.diplome']->find($idDiplome);
               
           if(!in_array($diplome->getId(), $listIdDiplome)){
               array_push($listIdDiplome, $diplome->getId());
           }
               
       }
       $listDiplome = array();
       foreach($listIdDiplome as $idDip){
           $diplome = $app['dao.diplome']->find($idDip);
           array_push($listDiplome, $diplome);
               
       }
              foreach($listDiplome as $dip){
 $dip->setEc($app['dao.cours']->findByDipomeEtProf($dip->getId(),$str));
     
       }
           
           
    return $app['twig']->render('index.html.twig' ,array('coursList' =>$listCours,'listDiplome' => $listDiplome));
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
    
$app->get('/admin/domaine', function () use ($app) {
    
    $listDomaine = $app['dao.domaine']->findAll();     
        return $app['twig']->render('domaine.html.twig' ,array('domaineList' =>$listDomaine));
            
})->bind('domaine');
    
$app->get('/admin/mention/{id}', function ($id) use ($app) {
    
    $listMention = $app['dao.mention']->findByDomaine($id);     
        return $app['twig']->render('mention.html.twig' ,array('mentionList' =>$listMention));
            
})->bind('mention');
    
$app->get('/admin/coursPourLeDiplome/{id}', function ($id) use ($app) {
    $nomDiplome = $app['dao.diplome']->find($id);
    $nombreDeSemestre = $app['dao.diplome']->nombreDeSemestreDuDiplome($id);
    $listSemestre = array();
        
         for($i = 1; $i <= $nombreDeSemestre; $i ++){
             $semestre = new Semestre();
             $semestre->setNumSemestre($i);
                 
       // On récupère les UE et EC d'un parcours
   $listUe = $app['dao.ue']->findByDiplomeEtSemestre($id,$i);
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
   $semestre->setUE($listUe);
   $semestre->setDiplome($id);
   array_push($listSemestre, $semestre);
       }
           
           
           
        return $app['twig']->render('coursPourLeDiplome.html.twig' ,array('listSemestre' =>$listSemestre,'nomDiplome' => $nomDiplome));
            
})->bind('coursPourLeDiplome');
    
$app->get('/diplome/{id}', function ($id) use ($app) {
    $listDiplome =  $app['dao.diplome']->findByMention($id);    
        return $app['twig']->render('diplome.html.twig' ,array('diplomeList' =>$listDiplome));
            
})->bind('diplome');
    
    
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
       //On récupère les services numériques
   $servicesNum = $app['dao.livret']->findServicesNumeriques($id);
       
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
       
   $nomDiplome = $app['dao.diplome']->find($id);
    $nombreDeSemestre = $app['dao.diplome']->nombreDeSemestreDuDiplome($id);
    $listSemestre = array();
        
         for($i = 1; $i <= $nombreDeSemestre; $i ++){
             $semestre = new Semestre();
             $semestre->setNumSemestre($i);
                 
       // On récupère les UE et EC d'un parcours
   $listUe = $app['dao.ue']->findByDiplomeEtSemestre($id,$i);
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
   $semestre->setUE($listUe);
   $semestre->setDiplome($id);
   array_push($listSemestre, $semestre);
       }
 return $app['twig']->render('livret.html.twig' ,array('listSemestre' =>$listSemestre,'nomDiplome' => $nomDiplome,'servicesNum'=> $servicesNum,'mention'=>$mention, 'parcours' => $id, 'organigramme'=>$organigramme, 'presentationForm'=>$presentationForm, 'charte'=>$charte,'modalites'=>$modalites,'stages'=>$stages,'modules'=>$modules, 'calendrier'=>$calendrier));
     
})->bind('livret');
    
    
// Modification du contenu d'un livret (Admin)
$app->match('editLivret/{id}', function ($id, Request $request) use ($app) {
    
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
       
    $livret = new Livret();
    $livretForm = $app['form.factory']->create(EditLivretType::class, $livret, ['calendrier' => $calendrier, 'universite' =>$organigramme->getUniversite(),
        'ufr' =>$organigramme->getUfr(),'departement' =>$organigramme->getDepartement(),
        'presentation' => $presentationForm,'maquette' => $mention,
        'modules_transversaux' => $modules->getModules_transversaux(), 'langues_vivantes' => $modules->getLangues_vivantes(),
        'bonus_diplomes' => $modules->getBonus_diplomes(),'stage' => $stages,
        'modalites_generales' => $modalites->getModalites_generales(),'modalites_specifiques' => $modalites->getModalites_specifiques(),
        'particularite_validation' => $modalites->getParticularite_validation(),'deroulement_charte_examens' => $modalites->getDeroulement_charte_examens(),
        'delivrance_diplome' => $modalites->getDelivrance_diplome(), 
        'charte' => $charte]);
    $livretForm->handleRequest($request);
        
    if ($livretForm->isSubmitted() && $livretForm->isValid()) {
        $organigramme = new Organigramme();
        $modulesEnseignement = new ModulesEnseignement();
        $modalitesControle = new ModalitesControle();
        // Build domain object Livret for persistance
        $livret->setCalendrier($livretForm['calendrier']->getData());
        //Object Organigramme
        $organigramme->setFid_dip($id);
        $organigramme->setDepartement($livretForm['departement']->getData());
        $organigramme->setUniversite($livretForm['universite']->getData());
        $organigramme->setUfr($livretForm['ufr']->getData());
        $livret->setOrganigramme($organigramme);
        $livret->setPresentation($livretForm['presentation']->getData());
        //Object ModulesEnseignement
        $modulesEnseignement->setFid_dip($id);
        $modulesEnseignement->setModules_transversaux($livretForm['modules_transversaux']->getData());
        $modulesEnseignement->setBonus_diplomes($livretForm['bonus_diplomes']->getData());
        $modulesEnseignement->setLangues_vivantes($livretForm['langues_vivantes']->getData());
            
        $livret->setModules_enseignement($modulesEnseignement);
        $livret->setStage($livretForm['stage']->getData());
        //Objectt ModalitesControle
        $modalitesControle->setFid_dip($id);
        $modalitesControle->setModalites_generales($livretForm['modalites_generales']->getData());
        $modalitesControle->setModalites_specifiques($livretForm['modalites_specifiques']->getData());
        $modalitesControle->setParticularite_validation($livretForm['particularite_validation']->getData());
        $modalitesControle->setDeroulement_charte_examens($livretForm['deroulement_charte_examens']->getData());
        $modalitesControle->setDelivrance_diplome($livretForm['delivrance_diplome']->getData());
            
        $livret->setModalites_examens($modalitesControle);
        $livret->setCharte($livretForm['charte']->getData());
            
        $app['dao.livret']->save($livret);
        $app['session']->getFlashBag()->add('success', 'The informations was successfully saved.');
    }
        
    return $app['twig']->render('EditLivret.html.twig', array('livretForm' => $livretForm->createView()));
        
})->bind('editLivret');