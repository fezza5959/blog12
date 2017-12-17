<?php
session_start();

require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';


$id_article = isset($_GET['id_article']) ? $_GET['id_article'] : ""; //on recupere l'id dans l'url

$ftime = time(); // fonction time pour rafraichissement de l'image

if ($is_connect == TRUE)
    if (isset($_POST['ajouter'])) {  // si le bouton ajouter a été pressé
        print_r($_POST);
        print_r($_FILES);

        if ($_FILES['image']['error'] == 0) {

            $notification = 'Aucune notification';  //on creer une notification
            $_SESSION['notification_result'] = FALSE;
            $date_du_jour = date("Y-m-d"); // création date 

            if (!empty($_POST['titre']) AND !empty($_POST['texte'])) { // si les champs ne sont pas vide
                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0; // savoir si publie existe sinon publie = 0


                $insert = "INSERT INTO articles (titre, texte, date, publie)"  // requete qui insert les articles dans la BDD
                        . "VALUES (:titre, :texte, :date, :publie)";


                /* @var $bdd PDO */
                /* on prepare la requete et securise les variables */
                $sth = $bdd->prepare($insert);
                $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);


                if ($sth->execute() == TRUE) {

                    $id_article = $bdd->lastInsertId();

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);//attribuer une extension

                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $id_article . '.' . $extension); // on donne le chemin pour l'image

                    $notification = 'Votre article est inséré...';
                    $_SESSION['notification_result'] = TRUE;
                } else {
                    $notification = 'Une erreur est surevenue lors le l\'insertion de l\'article dans la base de données...';//notification
                    $_SESSION['notification_result'] = FALSE;
                    //   }
                }
            } else {
                $notification = 'Veuillez renseigner les champs obligatoires';  // notificaiton
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            $notification = 'Une erreur est survenue lors du traitement de votre image...'; // notification

            $_SESSION['notification_result'] = FALSE;
        }

        $_SESSION['notification'] = $notification;

        header('Location: article.php ');
        exit();
    } else if (isset($_POST['modifier'])) {  // si le bouton modifier a été pressé
        
        $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;   // savoir si publie existe sinon publie = 0
        

        /* requete sql qui met à jour les nouveaux paremetres de l'article */

        $update = "UPDATE articles SET titre =:titre,texte =:texte,publie =:publie WHERE id =:id_article";
        /* on prepare la fonction update et on securise les valeurs */
        $sth = $bdd->prepare($update);
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
        $sth->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_INT);

        if ($sth->execute() == TRUE) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); //attribuer une extension

            if ($sth->execute() == TRUE) {
                move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $_POST['id_article'] . '.' . $extension); //chemin pour l'image


                header('Location: index.php'); //redirection
                exit();
            } else {
                echo 'Une erreur est survenue..';
            }
        }
    } elseif (isset($_POST['submit2'])) { //si le bouton supprimer a été pressé
        $id_article = $_POST["id_articles"]; // on recup l'id grace a un "hidden"


        /* requete qui permet de supprimer l'article */

        $sth = $bdd->prepare("DELETE FROM articles  WHERE id = :id_article");
        $sth->bindParam(':id_article', $_POST['id_articles'], PDO::PARAM_INT);
        $sth->execute();
        //$sth->execute();
        //$sth = $bdd->prepare($suppression);
        $img = 'img/' . $_POST['id_article'] . '.' . 'jpg';
        unlink($img);

        header('Location: index.php ');
    } else {

        $id_article = isset($_GET['id_article']) ? $_GET['id_article'] : ""; //on recup l'id dans l'url
        $action = isset($_GET['action']) ? $_GET['action'] : "ajouter"; //si action n'existe pas alors il est = à ajouter

        if ($action == "modifier") {   //ici si le bouton pressé a pour valeur "modifier" on SELECT l'article ou son id = a l'id recup dans l'url
            $select2 = "SELECT * FROM articles where id = :id_article";

            $sth2 = $bdd->prepare($select2);
            $sth2->bindValue(':id_article', $id_article, PDO::PARAM_INT);


            if ($sth2->execute() == TRUE) {
                $tab_result2 = $sth2->fetch(PDO::FETCH_ASSOC); // retourne un tableau contenant les linges de la requete
                $titre = $tab_result2['titre'];
                $texte = $tab_result2['texte'];
                $publie = $tab_result2['publie'];
            }
        } else {
            
        }



        include 'includes/header.inc.php';
        ?>
        <!-- Page Content -->
        <form action="article.php" method="post" enctype="multipart/form-data" id="form_article">
            <div class="container">

                <div class="form-group">
                    <div class="col-lg-12  text-center"> <p>
        <?php if (isset($_GET['id_article'])) { ?>                  
                                <input type='hidden' name='id_article' value="<?= $_GET['id_article'] ?>">    

        <?php } ?>
                            <?php
                            if ($is_connect == TRUE) {
                                ?>
                            <div class="alert alert-info" role="alert">
                                Connecté en tant que <?= $nom_connect; ?> <?= $prenom_connect; ?> 
                            </div>
                                <?php
                            }
                            ?>

                        <?php if (isset($_GET['action']) == "modifier") { ?>
                            <h1 class="mt-5">Modifier un article </h1> 
                            <?php
                        } elseif (isset($_GET['action2']) == "supprimer") {
                            ?>
                            <h1 class="mt-5">Suppression d'un article </h1> 

                            <?php
                            //  echo $id_article;
                            ?>

                            <label for="contenu">  Etes-vous sûr de vouloir supprimer cet article ?</label>
                            <div>

                            <?php
                            //    echo $id_article
                            ?>


                                <button type="submit" class="btn btn-primary" id="submit" name="submit2" value="supprimer"> Oui </button>
                                <a href="index.php" class="btn btn-primary">Non</a>
                            </div>
                            <input type='hidden' name='id_articles' value="<?= $id_article ?>">    

            <?php
            exit();
        } else {
            ?>
                            <h1 class="mt-5">Ajouter un article </h1> 

                            <?php
                        }
                        ?>
        <?php
        if (isset($_SESSION['notification'])) {
            $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
            ?>

                            <div class="alert <?= $notification_result ?> alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
            <?= $_SESSION['notification']; ?>

                            </div>
            <?php
            unset($_SESSION['notification']);
            unset($_SESSION['notification_result']);
        }
        ?>
                        <div class="form-group">
                            <div class="col-md">


                                <label for="titre">Titre</label>

        <?php if (isset($titre)) { ?>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de votre article" value=" <?= isset($titre) ? $titre : "" ?>"  >
        <?php } else { ?>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de votre article">
                                <?php }
                                ?>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md ">
                                <label for="contenu">Article</label>
                                <textarea class="form-control" id="texte" name="texte" placeholder="Texte de votre article" rows="5"  ><?= isset($texte) ? $texte : "" ?></textarea>
                            </div>
                        </div>


        <?php if (isset($id_article)) { ?>
                            <img class="card-img-top" src="img/<?= $id_article ?>.jpg?<?= $ftime ?>" style = "width:15rem;"   >

        <?php } else { ?>


        <?php } ?>

                        <div class="form-group">


                            <input type="file" class="form-control-file" id="image" name="image" aria-describedby="fileHelp">
                        </div>




                        <div class="form-check">
                            <label for ="checkbox" class="form-check-label">
        <?php if (isset($publie) == 1) { ?>
                                    <input type="checkbox" checked class="form-check-input" id="publie" name="publie" value="1">
        <?php } else { ?>
                                    <input type="checkbox" class="form-check-input" id="publie" name="publie" value="1">
                                <?php } ?>
                                Publié ?
                            </label>
                        </div>

                        <div  for ="submit" class="btn-group" >
        <?php if (isset($_GET['action']) == "modifier") { ?>
                                <button type="submit" class="btn btn-primary" id="submit" name="modifier" value="modifier">Modifier un article </button>

            <?php
        } else {
            ?>
                                <button type="submit" class="btn btn-primary" id="submit" name=" ajouter" value="ajouter">Ajouter un article </button>
                                <?php
                            }
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/popper/popper.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <?php
        include 'includes/footer.inc.php';
    } else {
    echo' vous devez etre connecte...';
}
?>
