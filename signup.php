<?php
session_start(); // Démarre la session

// Paramètres de connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "blogs"; // Nom de la base de données

// Connexion
$connexion = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs soumises
    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];

    // Requête pour récupérer l'utilisateur à partir de l'email soumis
    $requete = "SELECT * FROM utilisateurs WHERE email = '$email'";
    
    $resultat = $connexion->query($requete);

    // Vérifier si l'email existe dans la base de données
    if ($resultat->num_rows > 0) {
        // Récupérer les données de l'utilisateur
        $utilisateur = $resultat->fetch_assoc();
      
        // Vérifier si le mot de passe correspond
        if ($motdepasse === $utilisateur["motdepasse"]) {
            // Authentification réussie, enregistrer les données de l'utilisateur dans la session
            $_SESSION['utilisateur'] = $utilisateur;
            // Rediriger vers la page des blogs
            header("Location: blogs.php");
            exit;
        } else {
            // Mot de passe incorrect
            $erreur = "Mot de passe incorrect";
        }
    } else {
        // Email non trouvé dans la base de données
        $erreur = "Adresse email non trouvée";
    }
}

// Fermer la connexion à la base de données
$connexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Votre CSS personnalisé -->
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Connexion</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="motdepasse" class="form-label">Mot de passe :</label>
                        <input type="password" id="motdepasse" name="motdepasse" class="form-control" required>
                    </div>
                    <?php if(isset($erreur)) { ?>
                        <p style="color: red;"><?php echo $erreur; ?></p>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
