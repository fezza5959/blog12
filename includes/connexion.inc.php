<?php

$is_connect = FALSE ;




if(isset($_COOKIE['sid']) AND !empty($_COOKIE['sid'])) {  // Vérifier la présence de sid dans le tableau cookie ainsi que le fait qu'il soit différent de vide.
    

$select = "SELECT COUNT(*) as nb_sid,id,nom,prenom FROM utilisateur  WHERE sid = :sid "; // requete sql de comptage (COUNT)

  /* @var $bdd PDO */
        $sth = $bdd->prepare($select);
        $sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_STR);
        $sth->execute();
        
        $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
        
        
if($tab_result['nb_sid'] > 0) 
    {
    $is_connect = TRUE;
    $id_connect = $tab_result['id'];
    $nom_connect = $tab_result['nom'];
    $prenom_connect =$tab_result['prenom'];
  

    }
}

?>
