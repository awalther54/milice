<?php
// on teste si le visiteur a soumis le formulaire
include ('info_base_donnees.php');
if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') {
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass'])) && (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm']))) {
	// on teste les deux mots de passe
	if ($_POST['pass'] != $_POST['pass_confirm']) {
		$erreur = 'Les 2 mots de passe sont différents.';
	}
	else {
		$base = mysql_connect ($serveur, $login, $password);
		mysql_select_db ($database, $base);

		// on recherche si ce login est déjà utilisé par un autre membre
		$sql = 'SELECT count(*) FROM membre WHERE login="'.mysql_escape_string($_POST['login']).'"';
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$data = mysql_fetch_array($req);

		if ($data[0] == 0) {
		$sql = 'INSERT INTO membre VALUES("", "'.mysql_escape_string($_POST['login']).'", "'.mysql_escape_string(md5($_POST['pass'])).'", "'.mysql_escape_string($_POST['email']).'")';
		mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());

		session_start();
		$_SESSION['login'] = $_POST['login'];
		header('Location: index.php');
		exit();
		}
		else {
		$erreur = 'Un membre possède déjà ce login.';
		}
	}
	}
	else {
	$erreur = 'Au moins un des champs est vide.';
	}
}
?>
<html>
<head>
<title>Inscription</title>
<style type="text/css">
body
{
background:url(Fond.jpg);
color:white;
}

table
{
width:100%;
height:100%;
border:white 1px solid;
}
tr
{
border:white 1px solid;
}
td
{
border:white 1px solid;
background:black;
text-align:center;
}
</style>
</head>

<body>
<form action="inscription.php" method="post">
<table>
<tr>
<td colspan="2" style="font-size:24;font-weight:bold;">
Inscription a l'espace membre :
</td>
</tr>
<tr>
<td style="text-align:left">
Login :
</td>
<td>
<input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>">
</td>
</tr>
<tr>
<td style="text-align:left">
Mot de passe :
</td>
<td>
<input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>">
</td>
</tr>
<tr>
<td style="text-align:left">
Confirmation du mot de passe :
</td>
<td>
<input type="password" name="pass_confirm" value="<?php if (isset($_POST['pass_confirm'])) echo htmlentities(trim($_POST['pass_confirm'])); ?>">
</td>
</tr>
<tr>
<td style="text-align:left">
Email :
</td>
<td>
<input type="email" name="email" value="<?php if (isset($_POST['email'])) echo htmlentities(trim($_POST['email'])); ?>">
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" name="inscription" value="Inscription" style="width:100%">
</td>
</tr>
</table>
</form>
<?php
if (isset($erreur)) echo '<br />',$erreur;
?>
</body>
</html>	