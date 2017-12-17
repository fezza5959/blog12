<?php


//require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';

require_once 'config/connexion.inc.php';
require_once 'includes/fonctions.inc.php';
require_once 'libs/Smarty.class.php';




$prenom = 'Quentin';
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


$smarty->assign('name',$prenom);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include 'includes/header.inc.php';

$smarty->display('smarty-test.tpl');

include 'includes/footer.inc.php';
 
 

?>