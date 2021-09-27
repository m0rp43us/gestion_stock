<?php
	$title = 'ajouterGamme';
	require_once '../include/include.php';
	if(!Utilisateur::utilisateurConnecte()):	//si l'utilisateur n'est pas connecté, on le renvoie vers l'interface de connexion
		Application::redir('../login/');
	endif;
	$nom = (isset($_SESSION['GammeNom']) && !empty($_SESSION['GammeNom']))? $_SESSION['GammeNom'] : '';
	$nomCourt = (isset($_SESSION['GammeNomCourt']) && !empty($_SESSION['GammeNomCourt']))? $_SESSION['GammeNomCourt'] : '';
	$message = (isset($_SESSION['message']) && !empty($_SESSION['message']))? $_SESSION['message']: '';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style/style.css" />
	<link rel="stylesheet" type="text/css" href="../include/style/cssmenu.css" />
	<link rel="stylesheet" type="text/css" href="../include/style/form.css" />
</head>
<body>
	<?php require_once '../include/login_info.php'; ?>
	<div id="main">
		<div id="header">
			<div id="logo">
				<div id="logo_text">
					<h1>
						<a href="#"><span class="logo_colour">gestion de Entrepôt</span> </a>
					</h1>
					<h2><?php echo gmdate("M Y");?></h2>
				</div>
			</div>
			<?php require '../include/cssmenu.php'; ?>
			<div id="site_content">
			<?php require_once '../include/side_bar_gammes.php'; ?>
				<div id="content">
					<form method="post" action="add.php" class="login">
						<fieldset>
							<legend>Gamme:</legend>
							<div>
								<label for="nom">Nom:</label>
								<input type="text" name="nom" placeholder="Nom de la gamme" required value="<?php echo $nom; ?>" /><br />
							</div>
							<div>
								<label for="nom_court">Nom court:</label>
								<input type="text" name="nom_court" placeholder="Nom court de la gamme" required value="<?php echo $nomCourt; ?>" /><br />
							</div>
							<span><?php echo $message; $_SESSION['message'] = ''; ?></span>
						</fieldset>
						<input type="submit" name="add_gamme" value="Ajouter la gamme" />
					</form>
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