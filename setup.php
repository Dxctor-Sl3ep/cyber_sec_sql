<?php
// Informations de connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'cyber';

try {
    // Connexion initiale à MySQL sans spécifier de base de données
    $db = new PDO("mysql:host=$host", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la base de données si elle n'existe pas
    $db->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Base de données '$dbname' créée ou déjà existante.<br>";

    // Connexion à la base de données 'cyber' maintenant qu'elle est assurée d'exister
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,  // Identifiant unique, auto-incrémenté
        username VARCHAR(255) NOT NULL,    // Colonne pour le nom d'utilisateur (ne peut pas être vide)
        password VARCHAR(255) NOT NULL     // Colonne pour le mot de passe (ne peut pas être vide)
    )";
    $db->exec($sql);
    echo "Table 'users' créée ou déjà existante.<br>";

    // Vérifier si des utilisateurs existent déjà dans la table 'users'
    $check = $db->query("SELECT COUNT(*) FROM users");
    if ($check->fetchColumn() == 0) {
        // Si la table est vide (aucun utilisateur), on insère des utilisateurs par défaut
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

        $stmt->execute([':username' => 'admin', ':password' => 'adminpass']);
        $stmt->execute([':username' => 'user', ':password' => '1234']);
        $stmt->execute([':username' => 'MathCass', ':password' => 'MathLe33']);
        $stmt->execute([':username' => 'MaelB', ':password' => 'MaelLaMenace']);
        $stmt->execute([':username' => 'Maxime', ':password' => 'MaxoubidouLeChouchou']);
        echo "Utilisateurs par défaut insérés.<br>";
    } else {
        echo "Utilisateurs déjà présents, aucune insertion.<br>";
    }

    // Rediriger l'utilisateur vers la page de connexion 'login.php'
    header('Location: login.php');
    exit();
} catch (PDOException $e) {
    die("Erreur de connexion ou requête : " . $e->getMessage());
}
