<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8">

    <?php
    $title = "Bienvenue sur le site de covoiturage de l'IUT.";?>
    <title>
        <?php echo $title ?>
    </title>

    <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>
<body>
    <div id="header">
        <div id="entete">
            <div class="colonne">
                <a href="index.php?page=0">
                    <img src="image/logo.png" alt="Logo covoiturage IUT" title="Logo covoiturage IUT Limousin" />
                </a>
            </div>
            <div class="colonne">
                Covoiturage de l'IUT,<br />Partagez plus que votre véhicule !!!
            </div>
        </div>

        <?php if (isset($_SESSION['loggé'])) {
            ?>
            <div id="connect">
                <p>
                    utilisateur :
                    <?php echo $_SESSION['login']; ?>

                    <a href="index.php?page=12">Déconnexion</a>
                </p>
            </div>
        <?php } else { ?>
            <div id="connect">
                <a href="index.php?page=11">Connexion</a>
            </div>
            <?php
        }?>
    </div>
