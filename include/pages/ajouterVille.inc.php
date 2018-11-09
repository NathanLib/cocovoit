<?php
$db = new myPdo();
$manager = new VilleManager($db);
?>

<h1>Ajouter une ville</h1>

<?php if (empty($_POST["vil_nom"])) { ?>
    <form class="" action="#" method="post">
        <label> Nom : </label>
        <input type="text" name="vil_nom" value="" required>
        <input  class="BoutonValider" type="submit" value="Valider">
    </form>

<?php } else {
    
    $ville = new Ville($_POST);
    $manager->add($ville);
    ?>

    <p>
        <img src="image/valid.png" alt="valide" title="valide">
        La ville "<b><?php echo $_POST["vil_nom"]?></b>" a été ajoutée !
    </p>
<?php } ?>
