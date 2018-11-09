<?php
$db = new myPdo();
$parcourManager = new ParcoursManager($db);
$villeManager= new villeManager($db);

$listeParcours = $parcourManager->getAllParcours();
$nbParcours = $parcourManager->getNbParcours();
?>

<h1>Liste des parcours</h1>

<p>Actuellement <?php echo $nbParcours; ?> parcours sont enregistrées </p>

<table>
	<tr>
		<th><b> Numéro </b></th>
		<th><b> Ville départ </b></th>
		<th><b> Ville arrivée </b></th>
		<th><b> Nombre de Km </b></th>
	</tr>

	<?php foreach ($listeParcours as $par): ?>
		<tr>
			<td class="TableauLister"><?php echo $par->getParNum();?></td>
			<td class="TableauLister"><?php echo $villeManager->getVilNomId($par->getVilNum1()); ?></td>
			<td class="TableauLister"><?php echo $villeManager->getVilNomId($par->getVilNum2()); ?></td>
			<td class="TableauLister"><?php echo $par->getParKm(); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
