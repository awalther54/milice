<html>
	<head>
		<title>Etat des serveurs</title>
		<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
		<style type="text/css">
		body
		{
		background:url(IMG/Fond_Gauche.jpg) no-repeat left, 
		url(IMG/Fond_Droite.jpg) no-repeat right, 
		url(IMG/Fond_Centre.jpg) repeat center; 
		color:white;
		}

		.Disponible
		{
		color:green;
		}

		.Indisponible
		{
		color:red;
		}

		.etat_serveurs
		{
		width:50%;
		height:50%;
		position:absolute;
		left:25%;
		top:25%;
		}

		#header
		{
		margin-top:5;
		margin-left:0;
		margin-right:0;
		background:black;
		color:white;
		text-align:right;
		position:relative;
		}

		a
		{
		color:white;
		}

		#container
		{
		top:45;
		left:5;
		right:5;
		bottom:5;
		position:absolute;
		}

		table
		{
		border:white 1px solid;
		background:rgba(0,0,0,0.5);
		width:100%;
		height:100%;
		}

		td
		{
		text-align:center;
		}
		</style>
	</head>

	<body>
<div id="header">
<div style="float:left">
<a href="index.php">Accueil du site</a>
</div>
<form action="shakes-et-les-champis.php" method="post">
<?php
if (!isset($_SESSION['login'])) {
?>
Identifiant : <input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>">
Mot de passe : <input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>">
<input type="submit" name="connexion" value="Connexion">
<a href="inscription.php">Vous inscrire</a>
<?php
if (isset($erreur)) echo '<br /><br />',$erreur;
?>
</form>
<? } else { ?>
Bienvenue <?php echo htmlentities(trim($_SESSION['login'])); ?>&nbsp;&nbsp;
<a href="deconnexion.php">Deconnexion</a>
<?php }
if (isset($erreur)) echo '<br /><br />',$erreur;
?>
</div>
<?php
include("maj_etats_serveurs.php");
?>
<script type="text/javascript">

var scruterserveurs =function()
{
        var tableau = document.getElementById( "etat_serveurs" );
        var etat_s1 = $("tr").children()[3].innerHTML;
        var boucle;
        var compteur_dispo = 0;
        			
        var loop=function() {
                $.ajax({
                   url : 'maj_etats_serveurs.php', 
                   type : 'GET',
                   dataType : 'html',
                   success : function(code_html, statut){
                          $('#etat_serveurs').replaceWith(code_html);
                          console.log("Tableau rafraîchi !");
                          var new_etat_s1 = $("tr").children()[3].innerHTML;
                          if (etat_s1 != new_etat_s1) {
                               var audio;
                               if (new_etat_s1 == "Disponible") {
                                     if (compteur_dispo <= 5) {
                                           compteur_dispo++;
                                     }
                                     else {
                                           compteur_dispo=0;
                                           audio = new Audio('s1-disponible.m4a');
                                           audio.play();
                                           etat_s1 = new_etat_s1;
                                     }
                               }
                               else {
                                     compteur_dispo=0;
                                     audio = new Audio('s1-plus-disponible.m4a');
                                     audio.play();
                                     etat_s1 = new_etat_s1;
                               }
                          }
                   },
        
                   error : function(resultat, statut, erreur){
                          console.log(resultat);
                          console.log(erreur);
                   }
                });
        }
        
        boucle = setInterval(loop,10000);
}
scruterserveurs();
</script>
</body>
</html>		