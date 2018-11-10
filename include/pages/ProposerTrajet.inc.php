<?php
$db = new myPdo();
$manager = new ProposeManager($db);
$villeManager = new VilleManager($db);
$tableauVille = $villeManager->getAllVilles();
?>

<h1>Proposer un trajet</h1>

<?php if(empty($_POST["vil_num1"]) && empty($_POST['vil_num2'])) { ?>
    <form class="" action="#" method="post">
        <label> Ville de départ : </label>
        <select class="" name="vil_num1" required>
            <option value=""></option>
            <?php foreach ($tableauVille as $ville): ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
            <?php endforeach; ?>
        </select>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>
<?php } elseif (!empty($_POST['vil_num1']) && empty($_POST['vil_num2'])) {
    ?>

    <form class="Formulaire" action="#" method="post">
        <div class="">
            <label for="">Ville de départ :</label>
            <?php echo $villeManager->getVilNomId($_POST['vil_num1']); ?>
        </div>

        <div class="">
            <?php
            $parcoursManager = new ParcoursManager($db);
            $tableauVilleDispo = $parcoursManager->getVilleDispo($_POST['vil_num1']);
            ?>

            <label for="">Ville d'arrivée : </label>
            <select class="" name="vil_num2" required>
                <option value=""></option>
                <?php foreach ($tableauVilleDispo as $villeDispo): ?>
                    <option value="<?php echo $villeDispo->getVilNum() ?>"><?php echo $villeManager->getVilNomId($villeDispo->getVilNum()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="">
            <label for="">Date de départ : </label>
            <input type="date" name="pro_date" value="<?php echo date("Y-m-d"); ?>" required>
        </div>

        <div class="">
            <label for="">Heure de départ : </label>
            <input type="time" name="pro_time" value="<?php echo date("h:i"); ?>" required>

        </div>

        <div class="">
            <label for="">Nombre de place : </label>
            <input type="number" name="" value="" min="1" required>
        </div>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>

    <?php
} else {
    $propose = new Propose($_POST);
    $manager->add($propose);
}
