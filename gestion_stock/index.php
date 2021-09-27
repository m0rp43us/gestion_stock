<?php
	$title = 'GestionEntrepôt';
	require_once '../include/include.php';
	if(!Utilisateur::utilisateurConnecte()):
		Application::redir('../login/');
	endif;
?>
<!DOCTYPE HTML>
<html>
<head>
  <title><?php echo $title; ?></title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../style/style.css" />
  <link rel="stylesheet" type="text/css" href="../include/style/cssmenu.css" />
</head>
<body>
	<?php require_once '../include/login_info.php'; ?>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <h1><a href="#"><span class="logo_colour">gestion de Entrepôt</span></a></h1>
          <h2><?php echo gmdate("M Y");?></h2>
        </div>
      </div>
    <?php require '../include/cssmenu.php'; ?>
    <div id="site_content">
    <?php require_once '../include/side_bar_gestion_Entrepôt.php'; ?>
	<div id="content">
		<a href="reception.php">Réception</a><br />
    	<a href="livraison.php">Livraison</a><br />
    	<a href="consultation.php">Consultation (<?php echo Mouvement::nb(); ?>)</a>
	</div>
    </div>
    <div id="footer">
		<p><a href="#">ARKAS - <?php echo gmdate("M Y");?></a></p>
	</div>
	</div>
	</div>
</body>
</html>