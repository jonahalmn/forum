<?php

try {
    $bdd = new PDO ('mysql:host=localhost;dbname=OC;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('erreur: ' . $e->getMessage());
}

if (isset($_POST['inscription'])){
//traitement des infos
if (isset($_POST['pseudo'], $_POST['pass']) AND preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {

  if ($_POST['pass'] == $_POST['passwordconfirmation']){
  // Hachage du mot de passe
  $pass_hache = sha1($_POST['pass']);
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $email = htmlspecialchars($_POST['email']);
  // Insertion
  $req = $bdd->prepare("INSERT INTO MEMBRES (Pseudo, Pass, Email, DateInscritpion) VALUES (:pseudo, :pass, :email, CURDATE())");

  $req->execute(array(
      'pseudo' => $pseudo,
      'pass' => $pass_hache,
      'email' => $email));

      echo "l'utilisateur a bien été créé</br>";
      header('Location: connexion.php');
    }
      else {
        echo "erreur de confimation de mdp</br>";
      }
}elseif ($_POST['pass'] != $_POST['passwordconfirmation']) {
  echo "erreur de confimation de mdp</br>";
}

if(!isset($_POST['pseudo'])) {
echo "merci d'entrer un pseudo valide</br>";}

if(!isset($_POST['email']) OR !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
echo "merci d'entrer un email valide</br>";}

if(!isset($_POST['pass'])) {
echo "merci d'entrer un mot de passe valide</br>";}
}


?>

<form action="inscription.php" method="post" class="form">

<label for="pseudo"> Votre Pseudo </label>
<input type="string" name="pseudo" class="field"/>

<label for="pass"> Votre Mot de Passe </label>
<input type="password" name="pass" class="field"/>

<label for="passconfirmation"> Confirmez le mot de passe </label>
<input type="password" name="passwordconfirmation" class="field"/>

<label for="email"> Votre Email </label>
<input type="string" name="email" class="field"/>

<input type="submit" name="inscription" value="Inscription"/>

<a href="connexion.php"> Vous etes déja inscrit? </a>
