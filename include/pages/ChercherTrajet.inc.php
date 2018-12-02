<?php
$db = new myPdo();
$ProposeManager = new ProposeManager($db);
$villeManager = new VilleManager($db);
?>

<h1>Rechercher un trajet</h1>

<?php if(empty($_POST["villeDepart"]) && empty($_POST['vil_num2'])) { ?>
    <?php
    $tableauVilleDepart = $villeManager->getVilleDepart();
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

            <div class="AjouterPersonne">
                <label>Ville de départ :</label>
                <?php
                echo $villeManager->getVilNomId($_POST['villeDepart']);
                $_SESSION['numVilleDepart'] = $_POST['villeDepart'];
                ?>
            </div>

            <div class="AjouterPersonne">
                <?php
                $tableauVilleArrivee = $villeManager->getVilleArrivee($_SESSION['numVilleDepart']);
                ?>

                <label>Ville d'arrivée : </label>
                <select class="" name="vil_num2" required>
                    <option value="">Choisir ville</option>
                    <?php foreach ($tableauVilleArrivee as $ville): ?>
                        <option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="AjouterPersonne">
                <label>Date de départ : </label>
                <input type="date" name="pro_date" value="<?php echo date("Y-m-d"); ?>" required>
            </div>

            <div class="AjouterPersonne">
                <label>Précision : </label>
                <select class="" name="precision" required>
                    <option value="" >Choisir jour</option>
                    <?php for ($i=0; $i <PRECISION_DATE_RECHERCHE+1 ; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>">+/- <?php echo $i; ?> jours</option>
                        <?php
                    } ?>
                </select>
            </div>

            <div class="AjouterPersonne">
                <label>A partir de : </label>
                <select class="" name="pro_time" required>
                    <option value="">Choisir heure</option>
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
                $avisManager = new AvisManager($db);
                foreach ($resultat as $proposition):
                    $personneNoteAvis = $avisManager->getNoteAvis($proposition->per_num);
                    $personneCommAvis = $avisManager->getCommAvis($proposition->per_num);
                    ?>
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
                                <a href="#" class="tooltip">
                                    <?php echo $proposition->per_nom." ".$proposition->per_prenom; ?>
                                    <span class="tooltiptext">
                                        <?php if ($personneNoteAvis===0 && $personneCommAvis===0) {
                                            ?> Aucun avis ! <?php
                                        }
                                        elseif ($personneNoteAvis===0) {
                                            ?>
                                            Dernier avis : <?php echo $personneCommAvis->avi_comm; ?>
                                            <?php
                                        }
                                        elseif ($personneCommAvis===0) {
                                            ?>
                                            Moyenne des avis : <?php echo $personneNoteAvis->moyenne; ?>
                                            <?php
                                        }
                                        else {?>
                                            Moyenne des avis : <?php echo $personneNoteAvis->moyenne; ?>
                                            Dernier avis : <?php echo $personneCommAvis->avi_comm; ?>
                                        <?php } ?>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php
            } ?>

        <?php }
    } ?>
