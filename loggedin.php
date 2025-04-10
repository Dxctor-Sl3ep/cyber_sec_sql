<?php
session_start();

// Vérifie si l'utilisateur est connecté (si la session contient un nom d'utilisateur)
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username']; // Récupère le nom d'utilisateur depuis la session
?>


<html>

<head>
    <title>Mouahaha</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Bienvenue, <?= $username ?> !</h1>
    <p>Tu es connecté(e).</p>

    <a href="logout.php">Exit</a>
</body>

<footer>
    <p>Toujours mon linkedin</p>
    <a href="https://www.linkedin.com/in/mathias-de-meuleneire-2788b7333/" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:30px;height:30px;">
    </a>
</footer>

</html>