<?php
$db = new myPdo();
$manager = new ProposeManager($db);

$villeManager = new VilleManager($db);
$tableauVille = $villeManager->getAllVilles();
?>

<h1>Proposer un trajet</h1>

<?php if(empty($_POST["vil_num1"]) && empty($_POST['vil_num2'])) { ?>
    <form action="#" method="post">
        <label> Ville de départ : </label>
        <select name="vil_num1" required>
            <option value="">Choisir ville</option>
            <?php foreach ($tableauVille as $ville): ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
            <?php endforeach; ?>
        </select>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>
<?php } elseif (!empty($_POST['vil_num1']) && empty($_POST['vil_num2'])) {
    ?>
    <form class="Formulaire" action="#" method="post">
        <div>
            <label>Ville de départ :</label>
            <?php
            echo $villeManager->getVilNomId($_POST['vil_num1']);
            $_SESSION['numVilleDepart'] = $_POST['vil_num1'];
            ?>
        </div>

        <div>
            <?php
            $parcoursManager = new ParcoursManager($db);
            $tableauVilleDispo = $parcoursManager->getVilleDispo($_POST['vil_num1']);
            ?>

            <label>Ville d'arrivée : </label>
            <select name="vil_num2" required>
                <option value="">Choisir ville</option>
                <?php foreach ($tableauVilleDispo as $villeDispo): ?>
                    <option value="<?php echo $villeDispo->getVilNum() ?>"><?php echo $villeManager->getVilNomId($villeDispo->getVilNum()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Date de départ : </label>
            <input type="date" name="pro_date" value="<?php echo date("Y-m-d"); ?>" required>
        </div>

        <div>
            <label>Heure de départ : </label>
            <input type="time" name="pro_time" value="<?php echo date("H:i"); ?>" required>

        </div>

        <div>
            <label>Nombre de place : </label>
            <input type="number" name="pro_place" value="" min="1" required>
        </div>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>

    <?php
} else {
    $propose = new Propose($_POST);

    $parcoursManager = new ParcoursManager($db);
    $monParcours = $parcoursManager->getParcours($_SESSION['numVilleDepart'], $_POST['vil_num2']);

    $propose->setParNum($monParcours->par_num);
    $propose->setProSens($monParcours->pro_sens);

    $personneManager = new PersonneManager($db);
    $numPers = $personneManager->getNumPersLog($_SESSION['login']);
    $propose->setPerNum($numPers);

    $manager->add($propose);

    ?>
    <p>
        <img src="image/valid.png" alt="valide" title="valide">
        Le trajet a été ajoutée à la liste des propostitions !
    </p>
    <?php
    unset($_SESSION['numVilleDepart']);
}
