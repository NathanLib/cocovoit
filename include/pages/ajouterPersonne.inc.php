
<?php $db = new myPdo();
$manager = new PersonneManager($db);

if(!isset($_SESSION['nouvellePersonne'])) {

	if(empty($_POST['per_pwd'])) {
		?>

		<h1>Ajouter une personne</h1>

		<form class="Formulaire" action="#" method="post">
			<div class="LB">
				<label> Nom : </label>
				<input type="text" name="per_nom" value="" required>
			</div>
			
			<div class="LB">
				<label> Prenom : </label>
				<input type="text" name="per_prenom" value="" required>
			</div>

			<div class="LB">
				<label> Téléphone : </label>
				<input type="tel" name="per_tel" value="" pattern="(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}" title="Téléphone au format 06.00.00.00.00 ou 0600000000" required>
			</div>

			<div class="LB">
				<label> Email : </label>
				<input type="email" name="per_mail" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
			</div>

			<div class="LB">
				<label> Login : </label>
				<input type="text" name="per_login" value="" pattern="[A-Za-z0-9]+" title="Lettres et nombres seulement, pas de ponctuation ou de caractère sécial" required>
			</div>
			
			<div class="LB">
				<label> Mot de passe : </label>
				<input type="password" name="per_pwd" value="" pattern="[A-Za-z0-9]+" title="Lettres et nombres seulement, pas de ponctuation ou de caractère sécial" required>
			</div>

			<div>
				<b class="CAT">Catégorie :</b>
				<input class="CAT" type="radio" name="categorie" value="etudiant"/>
				<label class="CAT">Etudiant</label>

				<input class="CAT" type="radio" name="categorie" value="personnel"/>
				<label class="CAT">Personnel</label>
			</div>

			<input class="BoutonValider" type="submit" value="Valider">
		</form>
		<?php
	}
	else {
		$_SESSION['nouvellePersonne'] = new Personne($_POST);

		if (isset($_POST["categorie"]) && $_POST["categorie"] == "etudiant") {

			$divisionManager = new DivisionManager($db);
			$listeDivisions = $divisionManager->getAllDivisions();

			$departementManager = new DepartementManager($db);
			$listeDepartements = $departementManager->getAllDepartements();
			?>

			<h1>Ajouter un étudiant</h1>

			<form class="AjouterPersonne" action="#" method="post">
				<div class="">
					<label> Année : </label>
					<select class="" name="div_num" required>
						<option value="">Choisir année</option>
						<?php foreach ($listeDivisions as $division): ?>
							<option value="<?php echo $division->getDivNum() ?>"><?php echo $division->getDivNom() ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="AjouterPersonne">
					<label> Département : </label>
					<select class="" name="dep_num" required>
						<option value="">Choisir département</option>
						<?php foreach ($listeDepartements as $departement): ?>
							<option value="<?php echo $departement->getDepNum() ?>"><?php echo $departement->getDepNom() ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<input class="BoutonValider" type="submit" value="Valider">
			</form>

		<?php } elseif (isset($_POST["categorie"]) && $_POST["categorie"] == "personnel") {

			$fonctionManager = new FonctionManager($db);
			$listeFonctions = $fonctionManager->getAllFonctions();
			?>

			<h1>Ajouter un salarié</h1>

			<form action="#" method="post">
				<div class="AjouterPersonne">
					<label> Téléphone professionnel : </label>
					<input type="tel" name="sal_telprof" value="" pattern="(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}" title="Téléphone au format 06.00.00.00.00 ou 0600000000" required>
				</div>

				<div class="AjouterPersonne">
					<label> Fonction : </label>
					<select  name="fon_num" required>
						<option>Choisir fonction</option>
						<?php foreach ($listeFonctions as $fonction): ?>
							<option value="<?php echo $fonction->getFonNum() ?>"><?php echo $fonction->getFonLibelle() ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<input class="BoutonValider" type="submit" value="Valider">

			</form>
			<?php
		}
	}
}
else {

	if (!empty($_POST['div_num'])) {
		$manager->add($_SESSION['nouvellePersonne']);

		$etudiantManager = new EtudiantManager($db);
		$etudiant = new Etudiant($_POST);
		$etudiantManager->add($etudiant);

		?> <p><img src="image/valid.png" alt="valide" title="valide"> L'étudiant <b><?php echo $_SESSION['nouvellePersonne']->getPerPrenom().' '.$_SESSION['nouvellePersonne']->getPerNom() ?></b> a été ajoutée ! </p> <?php

	}
	else {
		if (!empty($_POST['fon_num'])) {
			$manager->add($_SESSION['nouvellePersonne']);

			$salarieManager = new SalarieManager($db);
			$salarie = new Salarie($_POST);
			$salarieManager->add($salarie);

			?> <p><img src="image/valid.png" alt="valide" title="valide"> Le salarié <b><?php echo $_SESSION['nouvellePersonne']->getPerPrenom().' '.$_SESSION['nouvellePersonne']->getPerNom() ?></b> a été ajoutée ! </p> <?php
		}
	}
	?>

	<?php
	unset($_SESSION['nouvellePersonne']);
} ?>