<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';

require_once 'config/connexion.inc.php';
require_once 'includes/fonctions.inc.php';
//Class smarty
require_once 'libs/Smarty.class.php';


$id_article = isset($_GET['id_article']) ? $_GET['id_article'] : ""; //on recupere l'id dans l'url



if (isset($_POST['publier'])) {  //si le bouton publier a été pressé

    if (!empty($_POST['pseudo']) AND !empty($_POST['textc'])) { //si les champs suivant ne sont pas vide

        
        /*requete qui permet insert dans la table commentaire le pseudo,email et le commentaire*/
        $insert = "INSERT INTO commentaire (pseudo,email,textc,id_article)"
                . "VALUES (:pseudo, :email, :textc, :id_article)";


        /* @var $bdd PDO */
/*prepare et securisation des variables*/
        $sth = $bdd->prepare($insert);
        $sth->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':textc', $_POST['textc'], PDO::PARAM_STR);
        $sth->bindValue(':id_article', $id_article, PDO::PARAM_INT);




        if ($sth->execute() == TRUE) {


            echo 'Votre commentaire a été inséré...';
        }

        header('index.php');
    } else {

        echo 'Veuillez renseigner les champs obligatoires';
    }
} else {
   // echo 'Un problème est survenu lors de l\inserstion dans la base de donnée....';
}


/*requete SQL qui recupere id,titre,texte et qui assigne un pseudo et un commentaire à l'article
 l'utilisation de separator devait me servir pour différencier les pseudos et commentaire entre eux avec la fonction explode
 mais je n'ai pas réussi à l'utiliser*/

$select = "SELECT articles.id,titre,texte,GROUP_CONCAT(commentaire.pseudo separator '*') as pseudo,GROUP_CONCAT(commentaire.textc separator '*')as textc  FROM articles LEFT JOIN commentaire ON articles.id = commentaire.id_article WHERE articles.id=:id_article ;";
//$select2 = "SELECT pseudo,email,textc FROM commentaire as c INNER JOIN articles as a WHERE a.id = c.id_article AND c.id_article =:id_article;";


/* @var $bdd PDO */
/*on prepare et securise les valeurs*/
$sth = $bdd->prepare($select);
$sth->bindValue(':id_article', $id_article, PDO::PARAM_INT);



if ($sth->execute() == TRUE) {
    
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); // retourne un tableau contenant les linges de la requete
  
    //  print_r($tab_articles);   
} else {
    echo 'une erreur est survenue...';
}




$smarty = new Smarty(); //moteur de template smarty
$ftime = time(); //on creer la variable pour le temps

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');

/*on assigne à smarty les variables php*/
$smarty->assign('is_connect', $is_connect);


if ($is_connect == TRUE) {
/*on assigne à smarty les variables php*/
    $smarty->assign('nom_connect', $nom_connect);
    $smarty->assign('prenom_connect', $prenom_connect);
    $smarty->assign('ftime', $ftime);
}
/*on assigne à smarty les variables php*/
$smarty->assign('tab_session', $_SESSION);
$smarty->assign('tab_articles', $tab_articles);



if (isset($_SESSION['notification'])) {
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';

    $smarty->assign('notification_result', $notification_result);

    unset($_SESSION['notification']);
    unset($_SESSION['notification_result']);
}


include 'includes/header.inc.php';

$smarty->display('commentaire.tpl');

include 'includes/footer.inc.php';
?>




