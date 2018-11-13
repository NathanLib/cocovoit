<?php
$db = new myPdo();
$ProposeManager = new ProposeManager($db);
?>

<h1>Rechercher un trajet</h1>

<?php if(empty($_POST["villeDepart"])) { ?>
    <?php
    $tableauVilleDepart = $ProposeManager->getVilleDepart();
    ?>

    <form class="" action="#" method="post">
        <label> Ville de départ : </label>
        <select class="" name="villeDepart" required>
            <option value=""></option>
            <?php foreach ($tableauVilleDepart as $ville): ?>
                <option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
            <?php endforeach; ?>
        </select>

        <input class="BoutonValider" type="submit" value="Valider">
    </form>
<?php } else { ?>

    <form class="Formulaire" action="#" method="post">
        <?php
        $villeManager = new VilleManager($db);
        ?>
        <div class="">
            <label for="">Ville de départ :</label>
            <?php
            echo $villeManager->getVilNomId($_POST['villeDepart']);
            $_SESSION['numVilleDepart'] = $_POST['villeDepart'];
            ?>
        </div>

        <div class="">
            <?php
            $tableauVilleArrivee = $ProposeManager->getVilleArrivee($_SESSION['numVilleDepart']);
            ?>

            <label for="">Ville d'arrivée : </label>
            <select class="" name="vil_num2" required>
                <option value=""></option>
                <?php foreach ($tableauVilleArrivee as $ville): ?>
                    <option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>


    <?php } ?>
