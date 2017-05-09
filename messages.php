<?php session_start();

try {
    $bdd = new PDO ('mysql:host=localhost;dbname=OC;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('erreur: ' . $e->getMessage());
}



if(isset($_POST['submit']) AND isset($_SESSION['id'])){
  $message = htmlspecialchars($_POST['message']);
  $UserId = $_SESSION['id'];

  $req2 = $bdd->prepare('INSERT INTO MESSAGES (MembreId, Contenu) VALUES (:MembreId, :Message)');
  $req2->execute(array('MembreId' => $UserId,
                        'Message' => $message));
}

?>

<h1> Bienvenue <?= $_SESSION['pseudo'] ?>, créez un message </h1>


<form class="" action="messages.php" method="post">

<label for="message"> Votre message </label>
<textarea name="message" placeholder="Entrez Votre message"></textarea>

<input type="submit" name="submit" value="Envoyer"/>

</form>

<a href="deconnexion.php"> Deconnexion </a>

<?php
$req = $bdd->prepare('SELECT MEMBRES.Pseudo AS Membre, Contenu AS Message FROM MESSAGES INNER JOIN MEMBRES ON MEMBRES.id = MESSAGES.MembreId');
$req->execute();

while ($donnees= $req->fetch()) {
  echo "Posté par " . $donnees['Membre'] . "</br>" . $donnees['Message'] . "</br>";
}
 ?>
