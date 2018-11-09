<?php
$db = new myPdo();
$personneManager = new PersonneManager($db);
?>

<h1>Pour vous connecter</h1>

<?php if (empty($_POST['captcha_result'])) { ?>
    <form class="" action="#" method="post">
        <div>
            <label for="">Nom d'utilisateur : </label>
            <input type="text" name="per_login" value="" required>
        </div>

        <div>
            <label for="">Mot de passe : </label>
            <input type="password" name="per_pwd" value="" required>
        </div>

        <div>
            <?php
            $nbRand1 = rand(1,9);
            $nbRand2 = rand(1,9);

            $_SESSION['nbRand1'] = $nbRand1;
            $_SESSION['nbRand2'] = $nbRand2;
            ?>

            <img src="<?php echo "image/nb/".$_SESSION['nbRand1'] ?>" alt="captcha1">
            <b>+</b>
            <img src="<?php echo "image/nb/".$_SESSION['nbRand2'] ?>" alt="captcha2">
            <b>=</b>

            <div class="">
                <input type="number" name="captcha_result" value="" required>
            </div>
        </div>

        <div>
            <input class="BoutonValider" type="submit" value="Valider">
        </div>
    </form>
<?php }
else {
    if ($_POST['captcha_result'] == $_SESSION['nbRand1']+$_SESSION['nbRand2'] && $personneManager->check_login_password($_POST['per_login'], $_POST['per_pwd'])) { ?>
        <?php
        $_SESSION['login'] = $_POST['per_login'];
        $_SESSION['password'] = $_POST['per_pwd'];
        $_SESSION['loggé'] = true;
        ?>

        <p>
            <img src="image/valid.png" alt="valide" title="valide">
            Bonjour
            <b><?php echo $_SESSION['login']?></b>
            , vous êtes maintenant connecté !
        </p>

        <p>Vous allez être redirigé vers l'accueil dans 1 secondes ...</p>

        <?php
        header("Refresh:1; url=index.php?page=0");
    }
    else { ?>
        <p>
            <img src="image/erreur.png" alt="erreur" title="erreur">
            Erreur lors de la connexion !
        </p>
        <?php
    }
} ?>
