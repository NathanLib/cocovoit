<?php
// Param�tres de l'application Covoiturage
// A modifier en fonction de la configuration

define('DBHOST', "localhost");
define('DBNAME', "cocovoit");
define('DBUSER', "bd");
define('DBPASSWD', "bede");
define('ENV','dev');
define('SALT','48@!alsd');
define('DBPORT',3306);

define('PRECISION_DATE_RECHERCHE', 3);
date_default_timezone_set('europe/paris');
// pour un environememnt de production remplacer 'dev' (d�veloppement) par 'prod' (production)
// les messages d'erreur du SGBD s'affichent dans l'environememnt dev mais pas en prod
?>
