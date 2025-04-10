# Projet : Lab de Vulnérabilités Web — Injection SQL

## 🏆  Objectif du projet

Créer un site web volontairement vulnérable, afin de comprendre l'injection SQL.

---

## 🛠️ Technologies utilisées

- **HTML/CSS**
- **PHP**
- **WAMP**
- **MySql**


---

## 📈 Étapes de réalisation

### 1. Création d'une base de données

Un script `setup.php` initialise une base SQL, avec une table `users` et des utilisateurs par défaut .

### 2. Développement d’un site vulnérable (`login.php`)

- Une page de connexion prend un identifiant et un mot de passe.
- Les données sont insérées directement dans la requête SQL sans filtrage. ❌ 


---

## 🏴‍☠️  Exemple d’exploitation

1. Accéder à l'URL suivante pour initialiser la base de données :  
   `http://localhost/cyber/setup.php`

2. Se connecter à la page de connexion (`login.php`) avec les identifiants suivants :

   - **Utilisateur** : (sans importance)
   - **Mot de passe** :  
     
  |          ' OR '1'='1            |
    

✅ **Résultat** : connexion réussie sans avoir besoin de mot de passe correct.



## Améliorations possibles

Utiliser des requêtes préparées pour lutter contre de possibles injections SQL, comme suit :

```php
$sql = "SELECT * FROM users WHERE username = :username AND password = :password";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $u);
$stmt->bindParam(':password', $p);
$stmt->execute();

Limitation des privilèges des utilisateurs SQL :les privilèges de lecture (SELECT) et écriture (INSERT, UPDATE)

Échappement des entrées utilisateur :
$username = $db->quote($u);
$password = $db->quote($p);
$sql = "SELECT * FROM users WHERE username = $username AND password = $password";
$stmt = $db->query($sql);

Utilisation de frameworks ou ORM : $user = User::where('username', $u)->where('password', $p)->first();

 Logs et Monitoring des requêtes SQL : SET global general_log = 'ON';
