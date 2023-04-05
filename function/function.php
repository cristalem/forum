

<?php
/*creation de la base de donnees*/
function bdd(){
     try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=forum', 'root', '', $pdo_options);
}
catch (Exception $e)
{
        /* si erreur afficher un message*/
        die('Erreur : ' . $e->getMessage());
}
return $bdd;
}

?>
