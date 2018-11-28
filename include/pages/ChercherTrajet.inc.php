<?php
$db = new myPdo();
$ProposeManager = new ProposeManager($db);
?>

<h1>Rechercher un trajet</h1>

<?php if(empty($_POST["villeDepart"]) && empty($_POST['vil_num2'])) { ?>
    <?php
    $tableauVilleDepart = $ProposeManager->getVilleDepart();
    ?>

    <form class="Formulaire" action="#" method="post">
        <div class="AjouterPersonne">
            <label> Ville de départ : </label>
            <select class="" name="villeDepart" required>
                <option value="">Choisir ville</option>
                <?php foreach ($tableauVilleDepart as $ville): ?>
                    <option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input class="BoutonValider" type="submit" value="Valider">
    </form>
<?php } else { ?>

    <?php if (!empty($_POST['villeDepart']) && empty($_POST['vil_num2'])) { ?>
        <form class="Formulaire" action="#" method="post">
            <?php
            $villeManager = new VilleManager($db);
            ?>

            <div class="AjouterPersonne">
                <label for="">Ville de départ :</label>
                <?php
                echo $villeManager->getVilNomId($_POST['villeDepart']);
                $_SESSION['numVilleDepart'] = $_POST['villeDepart'];
                ?>
            </div>

            <div class="AjouterPersonne">
                <?php
                $tableauVilleArrivee = $ProposeManager->getVilleArrivee($_SESSION['numVilleDepart']);
                ?>

                <label for="">Ville d'arrivée : </label>
                <select class="" name="vil_num2" required>
                    <option value="">Choisir ville</option>
                    <?php foreach ($tableauVilleArrivee as $ville): ?>
                        <option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="AjouterPersonne">
                <label for="">Date de départ : </label>
                <input type="date" name="pro_date" value="<?php echo date("Y-m-d"); ?>" required>
            </div>

            <div class="AjouterPersonne">
                <label for="">Précision : </label>
                <select class="" name="precision" required>
                    <option value=0 >Ce jour</option>
                    <?php for ($i=1; $i <PRECISION_DATE_RECHERCHE+1 ; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>">+/- <?php echo $i; ?> jours</option>
                        <?php
                    } ?>
                </select>
            </div>

            <div class="AjouterPersonne">   
                <label for="">A partir de : </label>
                <select class="" name="pro_time" required>
                    <?php for ($i=0; $i <24 ; $i++) {
                        ?>
                        <option value="<?php echo $i.".00.00"; ?>"><?php echo $i; ?> h </option>
                        <?php
                    } ?>
                </select>
            </div>

            <input class="BoutonValider" type="submit" value="Valider">
        </form>
    <?php } else {
        $parcoursManager = new ParcoursManager($db);
        $numParcours = $parcoursManager->getParcours($_SESSION['numVilleDepart'],$_POST['vil_num2'])->par_num;
        $sensPacours = $parcoursManager->getParcours($_SESSION['numVilleDepart'],$_POST['vil_num2'])->pro_sens;

        $resultat=$ProposeManager->getAllPropositions($numParcours, $_POST['pro_date'], $_POST['precision'], $_POST['pro_time'], $sensPacours);

        if($resultat===0){
            ?>
            <p>
                <img src="image/erreur.png" alt="erreur" title="erreur">
                <b>
                    Désolé, pas de trajet disponible !
                </b>
            </p>
            <?php
        } else {
            $villeManager = new VilleManager($db);
            ?>
            <table>
             <tr>
              <th><b> Ville départ </b></th>
              <th><b> Ville arrivée </b></th>
              <th><b> Date de départ </b></th>
              <th><b> Heure départ </b></th>
              <th><b> Nombre de places </b></th>
              <th><b> Nom du covoitureur </b></th>
          </tr>

          <?php
          foreach ($resultat as $proposition): ?>
              <tr>
               <td class="TableauLister">
                <?php echo $villeManager->getVilNomId($proposition->ville_depart);?>
            </td>
            <td class="TableauLister">
                <?php echo $villeManager->getVilNomId($proposition->ville_arrivee); ?>
            </td>
            <td class="TableauLister">
                <?php echo $proposition->pro_date; ?></td>
                <td class="TableauLister">
                    <?php echo $proposition->pro_time; ?>
                </td>
                <td class="TableauLister">
                    <?php echo $proposition->pro_place;?>
                </td>
                <td class="TableauLister">
                    <?php echo $proposition->per_nom." ".$proposition->per_prenom; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
} ?>

<?php }
} ?>
