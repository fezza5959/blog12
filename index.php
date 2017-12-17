<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';

require_once 'config/connexion.inc.php';
require_once 'includes/fonctions.inc.php';
//Class smarty
require_once 'libs/Smarty.class.php';



$la_recherche = isset($_GET['larecherche']) ? $_GET['larecherche']  : "" ; //recupere la valeur de l'url , si elle existe pas elle est = à ""
$nb_articles_par_page = 2; // on veut 2 articles par page

$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;  

$index = pagination($page_courante, $nb_articles_par_page); // on utilise la fonction pagination qui est dans le fichier fontions.inc

$nb_total_articles = nb_total_article_publie($bdd); //fonction pour savoir le nb total d'article

$nb_total_articles_recherche = nb_total_article_recherche($bdd, $la_recherche); //fonction pour la pagination de la recherche

$nb_page = ceil($nb_total_articles / $nb_articles_par_page); //savoir le nombre de page 

$nb_page_recherche = ceil($nb_total_articles_recherche/ $nb_articles_par_page); // savoir le nombre de page pour la recherche





    if(isset($_GET['larecherche'])){ //si la recherche existe
        
    /*  requete SQL qui permet de selectionner les articles où le titre ou le texte a pour nom la recherche */
$recherche = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
        . "FROM articles "    
        . "WHERE (titre LIKE :larecherche OR texte LIKE :larecherche)"
        . "AND publie =:publie "
        . "ORDER BY date DESC "
        . "LIMIT :index, :nb_articles_par_page;";

/* @var $bdd PDO */
/*on prepare et securise les valeurs*/
$sth = $bdd->prepare($recherche);
$sth->bindValue(':larecherche', '%' . $_GET['larecherche'] . '%', PDO::PARAM_STR).
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);


if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); 
    //print_r($tab_articles);   

} else {
    echo 'une erreur est survenue...';
}


    }else{
/*si la recherche n'existe pas on select tout les articles de la table articles*/
$select = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
        . "FROM articles "    
        . "WHERE publie = :publie "
        . "LIMIT :index, :nb_articles_par_page;";


/* @var $bdd PDO */
/*on prepare et securise les valeurs*/
$sth = $bdd->prepare($select);
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);


if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); // retourne un tableau contenant les linges de la requete
    //print_r($tab_articles);   

} else {
    echo 'une erreur est survenue...';
}
 
}



$smarty = new Smarty(); //moteur de template smarty
$ftime = time();        //on creer la variable pour le temps
$smarty->setTemplateDir('templates/');  
$smarty->setCompileDir('templates_c/');

/*on assigne à smarty les variables php*/
$smarty->assign('is_connect', $is_connect); 


if ($is_connect == TRUE) {
    /*on assigne à smarty les variables php*/
    $smarty->assign('nom_connect', $nom_connect);
    $smarty->assign('prenom_connect', $prenom_connect);
}
/*on assigne à smarty les variables php*/

$smarty->assign('tab_session', $_SESSION);
$smarty->assign('ftime',$ftime);
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('nb_pages', $nb_page);
$smarty->assign('page_courante', $page_courante);
$smarty->assign('larecherche', $la_recherche);
$smarty->assign('nb_page_recherche', $nb_page_recherche);



if (isset($_SESSION['notification'])) {
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';

    $smarty->assign('notification_result', $notification_result);

    unset($_SESSION['notification']);
    unset($_SESSION['notification_result']);
}

//$smarty->assign('recherche', $recherche);
//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include 'includes/header.inc.php';

$smarty->display('index.tpl');

include 'includes/footer.inc.php';

?>




