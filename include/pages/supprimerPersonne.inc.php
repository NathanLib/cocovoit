<?php 
$db = new myPdo();
$PersManager = new PersonneManager($db);
$ParcManager = new ParcoursManager($db);
$PropManager = new ProposeManager($db);
$AvisManager = new AvisManager($db);

$tableauPersonne = $PersManager -> getAllPersonnes();
?>

<?php if(empty($_POST["per_num"])) {  ?>
	<form action="#" method="post">
		<h1>Supprimer une personne</h1>

		<label> Nom : </label>
		<select name="per_num" required>
			<option value="">Choisir personne</option>
			<?php foreach ($tableauPersonne as $pers): ?>
				<option value="<?php echo $pers->getPerNum() ?>"><?php echo $pers->getPerNom().' '.$pers->getPerPrenom(); ?></option>
			<?php endforeach; ?>
		</select>
		<input class="BoutonValider" type="submit" value="Supprimer">
	</form>
<?php } else {
	$suppression = $AvisManager -> supprimerAvis($_POST["per_num"]);
	$suppression = $PropManager -> supprimerPropose($_POST["per_num"]);
	$suppression = $PersManager -> supprimerPersonne($_POST["per_num"]);
	if ($suppression ) {  ?>
		<p>
			<img src="image/valid.png" alt="valide" title="valide"> 
			La personne a bien été supprimée ! 
		</p>
		
	<?php } else { ?> 
		
		<p>
			<img src="image/erreur.png" alt="erreur" title="erreur"> 
			Erreur dans la suppression de la personne !
		</p>
	<?php } 
}?>

