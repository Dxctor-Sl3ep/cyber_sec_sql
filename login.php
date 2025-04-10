<?php
session_start();

// Informations de connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'cyber';

try {
    // Connexion initiale à MySQL sans spécifier de base de données
    $db = new PDO("mysql:host=$host", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active les exceptions en cas d'erreur

    // Vérifie si la base de données 'cyber' existe
    $stmt = $db->query("SHOW DATABASES LIKE '$dbname'");
    if (!$stmt->fetch()) {
        include 'setup.php'; // Si la BDD n'existe pas, inclut le script de configuration
        exit();
    }

    // Connexion à la base de données 'cyber' une fois qu'on est sûr qu'elle existe
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Affiche une erreur si la connexion échoue
}

// Initialisation des variables de message et des champs de formulaire
$msg = "";
$u = "";
$p = "";

if ($_POST) {
    $u = $_POST["username"];
    $p = $_POST["password"];

    // Requête SQL pour vérifier les identifiants
    // ⚠️ Vulnérable à l'injection SQL 
    $sql = "SELECT * FROM users WHERE username = '$u' AND password = '$p'";
    $stmt = $db->query($sql);

    /* exemple injection sql : ' OR '1' = '1 */

    if ($stmt->fetch()) { // Si une ligne est retournée, connexion réussie
        $_SESSION['username'] = $u; // Stocke le nom d'utilisateur en session
        header('Location: loggedin.php'); // Redirige vers la page de connexion réussie
        exit();
    } else {
        $msg = "Nom d'utilisateur ou mot de passe incorrect."; // Message d'erreur
    }
}
?>

<html>

<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Login Page</h1>

    <form method="POST">
        <input name="username" placeholder="Nom d'utilisateur"><br><br>
        <input name="password" placeholder="Mot de passe" type="password"><br><br>
        <button>Login</button>
    </form>

    <!-- Affiche un message si erreur de connexion -->
    <p><?= $msg ?></p>
</body>

<footer>
    <p>Si mon talent vous impressionne venez sur mon linkedin</p>
    <a href="https://www.linkedin.com/in/mathias-de-meuleneire-2788b7333/" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:30px;height:30px;">
    </a>
</footer>

</html>