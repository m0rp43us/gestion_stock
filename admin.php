<?php
	require_once 'include/include.php';
	$title = 'Administration';
	if(!Utilisateur::utilisateurConnecte()):
		Application::alert('vous devez connecter pour consulter cette page');
		Application::redir('login/');
	endif;
	if(!Utilisateur::getUtilisateurConnecte()->estAdmin()):
		Application::alert('vous devez être administrateur pour consulter cette page');
		Application::redir('autre.php');
	endif;
?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="include/style/cssmenu.css" />
</head>
<body>
	<div id="login_info">
		<span id="nom"><?php echo $_SESSION['prenom'] ?></span>,
		<span id="prenom"><?php echo $_SESSION['nom'] ?></span>
		<span id="deconnexion"><a href='deconnexion.php'>Déconnecter</a></span>
	</div>
	<div id="main">
		<div id="header">
			<div id="logo">
				<div id="logo_text">
					<h1>
						<a href="#"><span class="logo_colour">gestion de Entrepôt</span></a>
					</h1>
					<h2><?php echo gmdate("M Y");?></h2>
				</div>
			</div>
			<?php require 'include/cssmenu_admin.php'; ?>
			<div id="site_content">
			<?php require_once 'include/side_bar.php'; ?>
				<div id="content">
					<h1>Présentation</h1>
					<p>application web - gestion de Entrepôt - ARKAS - <?php echo gmdate("M Y");?></p>
				</div>
			</div>
			<div id="footer">
				<p>
					<a href="#">ARKAS - <?php echo gmdate("M Y");?></a>
				</p>
			</div>
		</div>
	</div>
</body>
</html>