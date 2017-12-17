<?php

function cryptPassword($mdp) {
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
}


function sid($email) {
    $sid =  md5($email . time());
    return $sid;
}


// Fonction de retour d'index de pagination
function pagination($page_courante, $nb_articles_par_page) {
    $index = ($page_courante-1) * $nb_articles_par_page;
    return $index;
}





//fonction nombre total d'article publié
function nb_total_article_publie($bdd){
    /* @var $bdd PDO */
    $sql="SELECT COUNT(*) as nb_total_article_publie FROM articles WHERE publie = 1";
    $sth = $bdd->prepare($sql);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    
    return $tab_result['nb_total_article_publie'];
}

//foncion nombre total article recherché
function  nb_total_article_recherche($bdd,$la_recherche){
    /* @var $bdd PDO */
    $sql="SELECT COUNT(*) as nb_total_article_recherche FROM articles WHERE (titre LIKE :larecherche OR texte LIKE :larecherche) AND publie = 1";
    $sth = $bdd->prepare($sql);
    $sth->bindValue(':larecherche', '%' . $la_recherche . '%', PDO::PARAM_STR).
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    return $tab_result['nb_total_article_recherche'];
}
?>



