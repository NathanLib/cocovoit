<?php
$db = new myPdo();
$ProposeManager = new ProposeManager($db);
$tableauVilleDepart = $ProposeManager->getVilleDepart();
?>

<h1>Rechercher un trajet</h1>

<?php if(empty($_POST["villeDepart"])) { ?>
    <form class="" action="#" method="post">
        <label> Ville de départ : </label>
        <select class="" name="villeDepart" required>
            <option value=""></option>
            <?php foreach ($tableauVilleDepart as $ville): ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
            <?php endforeach; ?>
        </select>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>
<?php } ?>
