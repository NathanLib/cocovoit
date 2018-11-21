<?php $db = new myPdo();
$manager = new PersonneManager($db);

$tableauPersonne = $manager -> getAllPersonnes();
?>
<?php if(empty($_POST["per_num"]) && empty($_POST["per_mail"])) {  ?>
	<form class="" action="#" method="post">
		<h1>Modifier une personne</h1>

		<label> Nom : </label>
		<select class="" name="per_num" required>
			<?php foreach ($tableauPersonne as $pers): ?>
				<option value="<?php echo $pers->getPerNum() ?>"><?php echo $pers->getPerNom().' '.$pers->getPerPrenom(); ?></option>
			<?php endforeach; ?>
		</select>
		<input class="BoutonValider" type="submit" value="Choisir">
	</form>
<?php } 
else if(!empty($_POST["per_num"]) && empty($_POST["per_mail"])){
	$personne = $manager -> getPerByID($_POST["per_num"]);
	$estEtudiant = $manager -> estEtudiant($personne -> getPerNum());
	$_SESSION['numPersonne'] = $_POST["per_num"];
	?>
	<h1>Modifier la personne <?php echo($personne -> getPerNom()); ?></h1>
	<form class="" action="#" method="post">
		<div class="LB">
		</div>

		<div class="LB">
			<label> Nom : </label>
			<input type="text" name="per_nom" value="<?php  echo($personne -> getPerNom()); ?>" required>
		</div>

		<div class="LB">
			<label> Prenom : </label>
			<input type="text" name="per_prenom" value="<?php  echo($personne -> getPerPrenom()); ?>" required>
		</div>

		<div class="LB">
			<label> Téléphone : </label>
			<input type="tel" name="per_tel" value="<?php  echo($personne -> getPerTel()); ?>" pattern="(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}" title="Téléphone au format 06.00.00.00.00 ou 0600000000" required>
		</div>

		<div class="LB">
			<label> Email : </label>
			<input type="mail" name="per_mail" value="<?php  echo($personne -> getPerMail()); ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
		</div>

		<div class="LB">
			<label> Login : </label>
			<input type="text" name="per_login" value="<?php  echo($personne -> getPerLogin()); ?>" pattern="[A-Za-z0-9]+" title="Lettres et nombres seulement, pas de ponctuation ou de caractère sécial" required>
		</div>

		<div class="LB">
			<label> Mot de passe : </label>
			<input type="password" name="per_pwd" value="<?php  echo($personne -> getPerPwd()); ?>" pattern="[A-Za-z0-9]+" title="Lettres et nombres seulement, pas de ponctuation ou de caractère sécial" required>
		</div>
		
		<?php 
		
		if($manager -> estEtudiant($personne -> getPerNum())){
			$divisionManager = new DivisionManager($db);
			$departementManager = new DepartementManager($db);
			$etudiantManager = new EtudiantManager($db);
			
			$listeDepartements = $departementManager->getAllDepartements();
			$listeDivisions = $divisionManager->getAllDivisions();
			$Etud = $etudiantManager -> getEtudiantId($_POST["per_num"]);
			?>

			<div class="AjouterPersonne">
				<label> Année : </label>
				<select class="" name="div_num" required>
					<?php foreach ($listeDivisions as $division): ?>
						<option value="<?php echo $division->getDivNum() ?>"><?php echo $division->getDivNom() ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="AjouterPersonne">
				<label> Département : </label>
				<select class="" name="dep_num" required>
					<?php foreach ($listeDepartements as $departement): ?>
						<option value="<?php echo $departement->getDepNum() ?>"><?php echo $departement->getDepNom() ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php } else {
			$salarieManager = new SalarieManager($db);
			$fonctionManager = new fonctionManager($db);
			$salarie = $salarieManager -> getSalarieId($_POST["per_num"]);

			$listeFonctions = $fonctionManager -> getAllFonctions();

			?>
			<div class="AjouterPersonne">	
				<label> Tel pro : </label>
				<input type="tel" name="sal_telprof" value="<?php  echo($salarie -> getSalTelProf()); ?>" pattern="(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}" title="Téléphone au format 06.00.00.00.00 ou 0600000000" required>
			</div>

			<div class="AjouterPersonne">
				<label> Fonction : </label>
				<select class="" name="fon_num" required>
					<?php foreach ($listeFonctions as $fonction): ?>
						<option value="<?php echo $fonction->getFonNum() ?>"><?php echo $fonction->getFonLibelle() ?></option>
					<?php endforeach; ?>
				</select>
			</div>

		<?php }?>
		<input class="BoutonValider" type="submit" value="Modifier">
	</form>
<?php }else {

	$_SESSION['nouvellePersonne'] = new Personne($_POST);
	if ($manager -> estEtudiant($_SESSION['numPersonne'])) {
		$etudiantManager = new EtudiantManager($db);
		$Modification = $manager -> updatePersonne($_SESSION['numPersonne'], new Personne($_POST));
		$etudiantManager -> updateEtudiant($_SESSION['numPersonne'], new Etudiant($_POST));
	}else{
		$Modification = $manager -> updatePersonne($_SESSION['numPersonne'], new Personne($_POST));
		$salarieManager = new SalarieManager($db);
		$salarieManager -> updateSalarie($_SESSION['numPersonne'], new Salarie($_POST));
	}

	if($Modification) {?>
		<p>
			<img src="image/valid.png" alt="valide" title="valide"> 
			La personne a bien été modifiée ! 
		</p>

	<?php } else { ?> 

		<p>
			<img src="image/erreur.png" alt="erreur" title="erreur"> 
			Erreur dans la modification de la personne !
		</p>
	<?php } ?>
	<?php  } ?>