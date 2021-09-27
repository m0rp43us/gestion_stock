<?php
	require_once '../include/include.php';
	$nb_clients = Client::nb();	//on sauvegarde dans une variable pour ne pas consulter la base une deuxiéme fois
	$table = Client::getTableName();
	$title = "afficher - $table ($nb_clients)";	
	if(!Utilisateur::utilisateurConnecte()):	//si l'utilisateur n'est pas connecté, on le renvoie vers l'interface de connexion
		Application::redir('../login/');
	endif;
	if(Client::pasDelements()):
		//test pour vérifier qu'il y a des clients à afficher
		Application::alert("aucun client trouvé!");
		Application::redir('index.php');
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
  <script type="text/javascript" src="../include/js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="../include/js/jquery.colorize-1.7.0.js"></script>
	<script type="text/javascript">
		$('document').ready(function(){
			$('table').colorize();
		});
	</script>
	<style type="text/css"> table, td, th { border:1px solid black; } </style>
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
      <?php require_once '../include/side_bar_clients.php'; ?>
	<div id="content">
<?php
	Sort::initOrderLog($table);		//initialiser les ordres
	Sort::initCols($table);			//initialiser les colonnes
	$error = false;				//flag d'erreur
	$msg_erreur = '';			//message d'erreur
	if(Sort::parametresExistent()):
		$paramsExistent = true;	//les paramétres existent
		if(Sort::parametresValides()):
			if(preg_match("~^-?[0-9]+$~i", $_GET['n'])):
				$n = (int) $_GET['n'];				//paramétre passé à la page
				$nb_lignes = DB_Manager::getNbRows($table);	//nombre totale de lignes
				$nlpp = Application::Lpp();							//nombre de lignes par page
				$derniere_page = ceil($nb_lignes / $nlpp);
				if(!$nb_lignes):	//aucun résultat à afficher
					$error = true;
					$msg_erreur = 'aucun resultat trouvee!';
				else:
					if($n >= 1 && $n <= $derniere_page):	//test sur la valeur de la clé passé
						//OK
						$x = $nlpp * ($n - 1);	//nombre de pages à sauter
						$sql = "SELECT * from $table ORDER BY " . $_GET['col'] . " " . $_GET['ordre'] . " LIMIT $x, $nlpp";
						$res = DB_Manager::query($sql);
						Sort::MAJordre();
					else:
						$error = true;
						$msg_erreur = 'indice de page invalide!';
					endif;	//if($n >= 1 && $n <= $derniere_page)
				endif;
			else:
				$error = true;
				$msg_erreur = 'paramétre érroné, ça doit être une valeur numérique >= 1';
			endif;	//if(preg_match("~^-?[0-9]+$~i", $_GET['n'])):
		else:
			$error = true;
			$msg_erreur = 'parametres invalides!';
		endif;	//if(parametresValides()):
	else:
		//les paramétres col et order n'existent pas, test si le paramétre n existe et est valide
		if(isset($_GET['n'])):
			if(preg_match("~^-?[0-9]+$~i", $_GET['n'])):
			$n = (int) $_GET['n'];				//paramétre passé à la page
			$nb_lignes = DB_Manager::getNbRows($table);	//nombre totale de lignes
			$nlpp = Application::Lpp();							//nombre de lignes par page
			$derniere_page = ceil($nb_lignes / $nlpp);
			if(!$nb_lignes):	//aucun résultat à afficher
				$error = true;
				$msg_erreur = 'aucun resultat trouvee!';
			else:
				if($n >= 1 && $n <= $derniere_page):	//test sur la valeur de la clé passé
					//OK
					$x = $nlpp * ($n - 1);	//nombre de pages à sauter
					$sql = "SELECT * from $table LIMIT $x, $nlpp";	//car les autres paramétres sont omises
					$res = DB_Manager::query($sql);
				else:
					$error = true;
					$msg_erreur = 'indice de page invalide!';
				endif;	//if($n >= 1 && $n <= $derniere_page)
			endif;
		else:
			$error = true;
			$msg_erreur = 'paramétre érroné, ça doit être une valeur numérique >= 1';
		endif;	//if(preg_match("~^-?[0-9]+$~i", $_GET['n'])):
		else:
			$error = true;
			$msg_erreur = 'le paramétre n n\'existe pas!';
		endif;
	endif;	//if(parametresExistent()):
	if(!$error):
		?>
		<table>
			<tr>
				<?php
					foreach(Sort::$orderLog as $key => $value):
						?>
							<th><a href="<?php echo $_SERVER['PHP_SELF']; ?>?col=<?php echo $key; ?>&ordre=<?php echo Sort::$orderLog[$key]; ?>&n=<?php echo $_GET['n']; ?>"><?php echo $key; ?> <?php Sort::printArrow($key); ?></a></th>
						<?php
					endforeach;
				?>
				<?php if(Utilisateur::getUtilisateurConnecte()->estAdmin()): ?>
					<th colspan="2">Options</th>
				<?php endif; ?>
			</tr>
			<?php
				foreach($res as $record):
					?>
						<tr>
							<?php
								foreach(Sort::$orderLog as $key => $value):
									?>
										<td><?php echo $record[$key]; ?></td>
									<?php
								endforeach;
							?>
							<?php if(Utilisateur::getUtilisateurConnecte()->estAdmin()): ?>
								<td><a href="modifier_client.php?id=<?php echo $record['id']; ?>"><img src="../include/img/edit-icon.png" title="modifier" style="height:24px;width:24px;"/></a></td>
								<td><a href="supprimer_client.php?id=<?php echo $record['id']; ?>" onclick="return(confirm('Supprimer?'))"><img src="../include/img/delete-icon.png" title="supprimer" style="height:24px;width:24px;"/></a></td>
							<?php endif; ?>
						</tr>
					<?php
				endforeach;
			?>
		</table>
		<?php
			//Remarque: le test if($nb_lignes > $nlpp) est fait pour vérifier le cas où il existe
			//exactement un multiple de $nlpp de lignes à afficher
			//echo "n = ", $n, " | derniere_page = ", $derniere_page;die;	//debug line
			if($n == $derniere_page):	//derniére page
				if($nb_lignes > $nlpp):
					?>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?n=<?php echo ($n - 1); ?>">&lt;</a>	<!-- page précédante -->
					<?php
				endif;
			elseif($n == 1):	//premiére page
				if($nb_lignes > $nlpp):
					?>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?n=<?php echo ($n + 1); ?>">&gt;</a>	<!-- page suivante -->
					<?php
				endif;
			else:
				?>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?n=<?php echo ($n - 1); ?>">&lt;</a>	<!-- page précédante --> &nbsp;&nbsp;
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?n=<?php echo ($n + 1); ?>">&gt;</a>	<!-- page suivante -->
				<?php
			endif;
	else:
		echo 'Erreur: ' . $msg_erreur;
	endif; //if(!$error):
?>
	<br /><br /><a href="../include/telecharger_liste.php?table=clients" target="_blank"><img src="../include/img/download.png" style="height:25px;width:25px;" title="télécharger"/></a>
	</div>
    </div>
    <div id="footer">
      <p><a href="#">ARKAS - <?php echo gmdate("M Y");?></a></p>
    </div>
  </div>
  </div>
</body>
</html>