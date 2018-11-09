<?php
class Mypdo extends PDO
{

	protected $dbo;

	public function __construct ()
	{
	 // le paramétrage de cette classe se fait dans le fichier config.inc.php
		if (ENV=='dev'){
			$bool=true;
		}
		else
		{
			$bool=false;
		}
		try {
			$this->dbo =parent::__construct("mysql:host=".DBHOST."; dbname=".DBNAME."; port=".DBPORT.";charset=UTF8", DBUSER, DBPASSWD,
			array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => $bool, PDO::ERRMODE_EXCEPTION => $bool));

			$req = "set NAMES UTF8";
			$resu = PDO::query($req);
			
		}
		catch (PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}


}

?>

