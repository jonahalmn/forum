<?php
session_start();
try {
    $bdd = new PDO ('mysql:host=localhost;dbname=OC;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('erreur: ' . $e->getMessage());
}

if (isset($_POST['submit'])) {

$pseudo = htmlspecialchars($_POST['pseudo']);


// Hachage du mot de passe
$pass_hache = sha1($_POST['pass']);

// Vérification des identifiants
$req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo AND pass = :pass');
$req->execute(array(
    'pseudo' => $pseudo,
    'pass' => $pass_hache));

$resultat = $req->fetch();

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{

    $_SESSION['id'] = $resultat['id'];
    $_SESSION['pseudo'] = $pseudo;
    echo 'Vous êtes connecté ! </br>';
}
}

if (!isset($_SESSION['pseudo']) AND !isset($_SESSION['id'])){
 ?>

 <form action="connexion.php" method="post" class="form">

 <label for="pseudo"> Votre Pseudo </label>
 <input type="string" name="pseudo" class="field"/>

 <label for="pass"> Votre Mot de Passe </label>
 <input type="password" name="pass" class="field"/>

 <input type="submit" name="submit" value="Connexion"/>

 </form>

 <a href="inscription.php"> Pas encore de compte? </a>

<?php } else { ?>

  Bienvenue <?php echo $_SESSION['pseudo'] ?> vous etes déja connecté, rendez vous sur la page <a href="messages.php"> messages </a>

  <?php } ?>
