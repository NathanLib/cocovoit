<?php
$db = new myPdo();
$manager = new ParcoursManager($db);
$villeManager = new VilleManager($db);

$tableauVille = $villeManager->getAllVilles();
$nbVille = $villeManager->getNbVille();
?>

<h1>Liste des villes</h1>

<p>Actuellement <?php echo $nbVille; ?> villes sont enregistrées </p>

<table>
	<tr>
		<th><b> Numéro </b></th>
		<th><b> Nom </b></th>
	</tr>

	<?php foreach ($tableauVille as $ville): ?>
		<tr>
			<td class="TableauLister"><?php echo $ville->getVilNum(); ?></td>
			<td class="TableauLister"><?php	echo $ville->getVilNom(); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
