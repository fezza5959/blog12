<?php
/* Smarty version 3.1.30, created on 2017-12-13 14:18:45
  from "H:\projet php\UwAmp\www\startbootstrap-bare-gh-pages\templates\commentaire.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a3136c56f5028_31888615',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '638a66c11a0393dd9dcc4601289866ad782a231c' => 
    array (
      0 => 'H:\\projet php\\UwAmp\\www\\startbootstrap-bare-gh-pages\\templates\\commentaire.tpl',
      1 => 1513174722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a3136c56f5028_31888615 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="container"> <p>
        
 
    
    
    <?php if (isset($_smarty_tpl->tpl_vars['tab_session']->value['notification'])) {?>
   

    <div class="alert <?php echo $_smarty_tpl->tpl_vars['notification_result']->value;?>
 alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $_smarty_tpl->tpl_vars['tab_session']->value['notification'];?>


    </div>
    
   <?php }?>
  
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">BLOG DE BG</h1>  
            
       <?php if ($_smarty_tpl->tpl_vars['is_connect']->value == TRUE) {?>
        <div class="alert alert-info" role="alert">
            Connecté en tant que <?php echo $_smarty_tpl->tpl_vars['nom_connect']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['prenom_connect']->value;?>

        </div>
    <?php }?>
   

        </div>
    </div>
    
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab_articles']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
    <h2>Article : 
        <div class="card col-md-6" >
            
                 <div class="card-body">
                <h4 class="card-title"><?php echo $_smarty_tpl->tpl_vars['value']->value['titre'];?>
</h4>       
            </div>
            <img class="card-img-top" src="img/<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['value']->value['titre'];?>
">
             <p class="card-text"><?php echo $_smarty_tpl->tpl_vars['value']->value['texte'];?>
</p>
             
        </div>
            
        
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </h2>
    
    
    <h2> Commentaires :  </h2>
      <div class="card col-md-6 bg-primary text-white">
         
                 <div class="row">
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab_articles']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>   
                     <label type="text" id="Utilisateur" name="pseudo">Pseudo : <?php echo $_smarty_tpl->tpl_vars['value']->value['pseudo'];?>
 </label> |
                       <label type="text" id="Utilisateur" name="email">Email : <?php echo $_smarty_tpl->tpl_vars['value']->value['email'];?>
 </label> 
                     
                 </div>
             <div>
          
            <p class="card-text"> : <?php echo $_smarty_tpl->tpl_vars['value']->value['textc'];?>
</p>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    
             </div>
 
            
        </div>
    
 
    
       <h2>
        
        Ajouter un commentaire : 
        </h2>
    
    
    
    
 
        
       
     <div class="card col-md-12">
         
        
  <div class="row">
    <div class="col">
 <label for="titre"> Pseudo :</label>
                        
                        <input type="text" class="form-control" id="prenom" name="pseudo" placeholder="Votre Pseudo"  >
    </div>
    <div class="col">
    <label for="titre">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="xyz@exemple.com"  >
    </div>
  </div>
      <h2></h2>
     <div class="row">
            <div class="col-md-12">         
        <textarea class="form-control" id="texte" name="textc" placeholder="Texte de votre commentaire" rows="5" ></textarea>
            </div>
      </div>
        <div class="row">
      <div class="col-md-6">
        
          <h2></h2>
       <button type="submit" class="btn btn-primary" id="submit" name="sumbit3" value="comment">Publier votre commentaire </button>
    
      </div>
      </div>
  </div>
                      
    </div> 
        
     
  
    
     </div> 
    
   

</div>

<!-- Bootstrap core JavaScript -->
<?php echo '<script'; ?>
 src="vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/popper/popper.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>


<?php }
}
