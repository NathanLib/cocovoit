<?php
$db = new myPdo();
$manager = new ParcoursManager($db);
$villeManager = new VilleManager($db);

$tableauVille = $villeManager->getAllVilles();
?>

<h1>Ajouter un parcours</h1>

<?php if(empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["par_km"])) { ?>
    <form class="" action="#" method="post">
        <p>
            <label> Ville 1 : </label>
            <select class="" name="vil_num1" required>
                <?php foreach ($tableauVille as $ville): ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php endforeach; ?>
            </select>

            <label> Ville 2 : </label>
            <select class="" name="vil_num2" required>
                <?php foreach ($tableauVille as $ville): ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php endforeach; ?>
            </select>

            <label> Nombre de kilomètre(s) : </label>
            <input type="number" name="par_km" value="" min="1" required>
        </p>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>

<?php } else {
    if ($_POST['vil_num1'] != $_POST['vil_num2']) {

        $parcours = new Parcours($_POST);
        $manager->add($parcours);
        ?>

        <p><img src="image/valid.png" alt="valide" title="valide"> Le parcours a été ajoutée ! </p>

    <?php }
    else {
        ?>
        <p>
            <img src="image/erreur.png" alt="erreur" title="erreur">
            Erreur dans l'ajout du parcours !
        </p>
        <?php
    }
} ?>
