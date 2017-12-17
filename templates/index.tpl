<div class="container"> <p>
        
 
    
    
    {if isset($tab_session['notification'])}
   

    <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {$tab_session['notification']}

    </div>
    
   {/if}
  
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">BLOG</h1>  
            
       {if $is_connect == TRUE}
        <div class="alert alert-info" role="alert">
            Connecté en tant que {$nom_connect} {$prenom_connect} 
        </div>
    {/if}
  

        </div>
    </div>
    
    {foreach from =$tab_articles item=value}
    <h2>
        <div class="card col-md-6" >
            <img class="card-img-top" src="img/{$value['id']}.jpg?{$ftime}" alt="{$value['titre']}">
            <div class="card-body">
                <h4 class="card-title">{$value['titre']}</h4>
                
                <button type="button" class="btn btn-primary" disabled >Crée le : {$value['date_fr']}</button>
                <a href="article.php?action=modifier&id_article={$value['id']}" class="btn btn-warning">Modifier l'article</a>
               <a href="article.php?action2=supprimer&id_article={$value['id']}" class="btn btn-danger ">Supprimer l'article</a>
          
            <a href="commentaire.php?action=commentaire&id_article={$value['id']}" class="btn btn-info" role="button" name="commentaire">Lire</a>
       
            </div>
        </div>
            
        
        {/foreach}
    </h2>
    
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            {if $larecherche == ""}   
            {for $i=1 to $nb_pages}
            <li class="page-item {if $page_courante == $i} active {/if}">
                <a class="page-link" href="?page={$i}">{$i}</a></li>
             
            {/for}
            {else}
               {for $i=1 to $nb_page_recherche}
            <li class="page-item {if $page_courante == $i} active {/if}">
                <a class="page-link" href="?page={$i}&larecherche={$larecherche}">{$i}</a></li>
                
                 {/for} 
                
            {/if}
          
              
      
        </ul>
    </nav>

</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


