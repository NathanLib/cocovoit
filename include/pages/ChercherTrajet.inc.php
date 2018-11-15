<?php
$db = new myPdo();
$ProposeManager = new ProposeManager($db);
?>

<h1>Rechercher un trajet</h1>

<?php if(empty($_POST["villeDepart"]) && empty($_POST['vil_num2'])) { ?>
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

    <?php if (!empty($_POST['villeDepart']) && empty($_POST['vil_num2'])): ?>
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

            <div class="">
                <label for="">Date de départ : </label>
                <input type="date" name="pro_date" value="<?php echo date("Y-m-d"); ?>" required>
            </div>

            <div class="">
                <label for="">Précision : </label>
                <select class="" name="" required>
                    <option value="0">Ce jour</option>
                    <?php for ($i=1; $i <PRECISION_DATE_RECHERCHE+1 ; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>">+/- <?php echo $i; ?> jours</option>
                        <?php
                    } ?>
                </select>
            </div>

            <div class="">
                <label for="">A partir de : </label>
                <select class="" name="" required>
                    <?php for ($i=0; $i <24 ; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?> h </option>
                        <?php
                    } ?>
                </select>
            </div>

            <input class="BoutonValider" type="submit" value="Valider">
        </form>
    <?php endif; ?>

<?php } ?>
