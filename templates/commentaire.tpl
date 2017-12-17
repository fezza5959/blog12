

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
            <h1 class="mt-5">BLOG DE BG</h1>  
            
       {if $is_connect == TRUE}
        <div class="alert alert-info" role="alert">
            Connecté en tant que {$nom_connect}  {$prenom_connect}
        </div>
    {/if}
   

        </div>
    </div>
    
    {foreach from =$tab_articles item=value}
    <h2>Article : 
        <div class="card col-md-6" >
            
                 <div class="card-body">
                <h4 class="card-title">{$value['titre']}</h4>       
            </div>
           <img class="card-img-top" src="img/{$value['id']}.jpg?{$ftime}" alt="{$value['titre']}">
            <div class="card-body">
             <p class="card-text">{$value['texte']}</p>
             
        </div>
            
        
        {/foreach}
    </h2>
    
    
    <h2> Commentaires :  </h2>
      <div class="card col-md-6 bg-primary text-white">
         
                 <div class="row">
  {foreach from =$tab_articles item=value}   
                     <label type="text" id="Utilisateur" name="pseudo">Pseudo : {$value['pseudo']} </label> 
                 
                 </div>
             <div>
          
            <p class="card-text"> : {$value['textc']}</p>
    {/foreach}    
             </div>
 
            
        </div>
    
 
    
        <h2>
        Ajouter un commentaire : 
        </h2>

     <div class="card col-md-12">
         <form action="" method="post" enctype="multipart/form-data" id="form_article">
         
        
  <div class="row">
    <div class="col">
 <label for="titre"> Pseudo :</label>
                        
                        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre Pseudo"  >
    </div>
    <div class="col">
    <label for="titre">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="xyz@exemple.com"  >
    </div>
  </div>
      <h2></h2>
     <div class="row">
            <div class="col-md-12">         
        <textarea class="form-control" id="textc" name="textc" placeholder="Texte de votre commentaire" rows="5" ></textarea>
            </div>
      </div>
        <div class="row">
      <div class="col-md-6">
        
          <h2></h2>
       <button type="submit" class="btn btn-primary" id="publier" name="publier" value="publier">Publier votre commentaire </button>
    
      </div>
      </div>
         </form>
  </div>
                      
    </div> 
        
     
  
    
     </div> 
    
      

</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


