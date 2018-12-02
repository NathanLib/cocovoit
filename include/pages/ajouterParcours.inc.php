<?php
$db = new myPdo();
$manager = new ParcoursManager($db);
$villeManager = new VilleManager($db);

$tableauVille = $villeManager->getAllVilles();
?>

<h1>Ajouter un parcours</h1>

<?php if(empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["par_km"])) { ?>
    <form class="Formulaire" action="#" method="post">
        <div class="AjouterPersonne">
            <label> Ville 1 : </label>
            <select name="vil_num1" required>
                <option value="">Choisir ville</option>
                <?php foreach ($tableauVille as $ville): ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php endforeach; ?>
            </select>

            <label> Ville 2 : </label>
            <select class="" name="vil_num2" required>
                <option value="">Choisir ville</option>
                <?php foreach ($tableauVille as $ville): ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php endforeach; ?>
            </select>

            <label> Nombre de kilomètre(s) : </label>
            <input type="number" name="par_km" value="" min="1" required>
        </div>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>

<?php } else {
    if ($_POST['vil_num1'] != $_POST['vil_num2']) { ?>

        <?php if ($manager->getParcoursExist($_POST['vil_num1'], $_POST['vil_num2'])) {
            ?>
            <p>
                <img src="image/erreur.png" alt="erreur" title="erreur">
                Erreur : le parcours existe déjà !
            </p>
            <?php
        } else {
            $parcours = new Parcours($_POST);
            $manager->add($parcours);
            ?>

            <p><img src="image/valid.png" alt="valide" title="valide"> Le parcours a été ajoutée ! </p>

        <?php } ?>

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
