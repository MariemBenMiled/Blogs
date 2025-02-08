<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=blogs', 'root', '');

            // Classe pour gérer les opérations CRUD sur les utilisateurs
            class GestionUtilisateurs {
                private $bdd;

                public function __construct($bdd) {
                    $this->bdd = $bdd;
                }

                public function creerUtilisateur($nom, $prenom, $email, $motdepasse) {
                    $requete = $this->bdd->prepare("INSERT INTO utilisateurs (nom, prenom, email, motdepasse) VALUES (?, ?, ?, ?)");
                    $requete->execute([$nom, $prenom, $email, $motdepasse]);
                    return $requete->rowCount();
                }
            }

            $gestionUtilisateurs = new GestionUtilisateurs($bdd);
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $motdepasse = $_POST['motdepasse'];
            $resultat = $gestionUtilisateurs->creerUtilisateur($nom, $prenom, $email, $motdepasse);
            if ($resultat) {
                echo "<p class='success'>Utilisateur créé avec succès.</p>";
            } else {
                echo "<p class='error'>Erreur lors de la création de l'utilisateur.</p>";
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Création d'utilisateur</title>
</head>
<body class='body-sign'>
    <div class="container_sign">
        <h1>Création d'utilisateur</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="motdepasse" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
            </div>
            
            <button type="submit" class="btn btn-danger">Créer l'utilisateur</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


