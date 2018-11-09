<?php
session_unset();
session_destroy();
?>

<p>
	<img src="image/valid.png" alt="valide" title="valide">
	vous êtes maintenant déconnecté !
</p>

<p>Vous allez être redirigé vers l'accueil dans 1 secondes ...</p>

<?php
header("Refresh:1; url=index.php?page=0");
?>
