<?php
$db = new myPdo();
$PersManager = new PersonneManager($db);
$EtudiantManager = new EtudiantManager($db);
$DepartementManager = new DepartementManager($db);
$VilleManager = new VilleManager($db);

$tableauPersonne = $PersManager -> getAllPersonnes();
$nbPersonnes = $PersManager -> getNbPersonne();
?>
<?php if (empty($_GET['numPersClick'])) { ?>

	<h1>Liste des personnes</h1>

	<p>Actuellement <?php echo $nbPersonnes; ?> personnes sont enregistrées </p>

	<table>
		<tr>
			<th><b> Numéro </b></th>
			<th><b> Nom </b></th>
			<th><b> Prénom </b></th>
		</tr>


		<?php foreach ($tableauPersonne as $pers): ?>
			<tr>
				<td class="TableauLister"><a href="index.php?page=2&numPersClick=<?php echo $pers->getPerNum(); ?>"><b><?php echo $pers->getPerNum(); ?></b></a></td>
				<td class="TableauLister"><?php echo $pers->getPerNom(); ?></td>
				<td class="TableauLister"><?php echo $pers->getPerPrenom(); ?></td>
			</tr>
		<?php endforeach; } ?>
	</table>


	<?php
	
	if(isset($_GET['numPersClick'])){
		$numPersonne = $_GET['numPersClick'];
		$estEtudiant = $PersManager -> estEtudiant($numPersonne);
		$Personne = $PersManager -> getPerByID($numPersonne);
		if($estEtudiant){
			$message = "l'étudiant ";
			$EtudManager = new EtudiantManager($db);
			$DepaManager = new DepartementManager($db);
			$VillManager = new VilleManager($db);
			$Etud = $EtudManager -> getEtudiantId($numPersonne);
			$Depa = $DepaManager -> getDepartementId($numPersonne);
			?>	
			<h1>Détail sur <?php echo($message); echo $Personne->getPerNom(); ?></h1>
			<table>
				<tr>
					<th><b> Prénom </b></th>
					<th><b> Mail </b></th>
					<th><b> Tel </b></th>
					<th><b> Département </b></th>
					<th><b> Ville </b></th>
				</tr>

				<tr>
					<td class="TableauLister"><?php echo $Personne->getPerPrenom(); ?></td>
					<td class="TableauLister"><?php echo $Personne->getPerMail(); ?></td>
					<td class="TableauLister"><?php echo $Personne->getPerTel(); ?></td>
					<td class="TableauLister"><?php echo $DepaManager->getDepartementNomId($Etud -> getDepNum()); ?></td>
					<td class="TableauLister"><?php echo $VillManager->getVilNomId($Depa -> getVilNum()); ?></td>

				</tr>
			</table>
		<?php } else {
			$message = "le salarié ";
			$SalaManager = new SalarieManager($db);
			$FoncManager = new FonctionManager($db);
			$Sala = $SalaManager -> getSalarieId($numPersonne);
			?>	
			<h1>Détail sur <?php echo($message); echo $Personne->getPerNom(); ?></h1>
			<table>
				<tr>
					<th><b> Prénom </b></th>
					<th><b> Mail </b></th>
					<th><b> Tel </b></th>
					<th><b> Tel Pro </b></th>
					<th><b> Fonction </b></th>
				</tr>

				<tr>
					<td class="TableauLister"><?php echo $Personne->getPerPrenom(); ?></td>
					<td class="TableauLister"><?php echo $Personne->getPerMail(); ?></td>
					<td class="TableauLister"><?php echo $Personne->getPerTel(); ?></td>
					<td class="TableauLister"><?php echo $Sala -> getSalTelProf()  ?></td>
					<td class="TableauLister"><?php echo $FoncManager-> getFonctionNomId($Sala -> getFonNum()); ?></td>


				</tr>
			</table>
		<?php }
	}?>