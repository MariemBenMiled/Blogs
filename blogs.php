<?php
session_start(); // Démarre la session

// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $nom = $utilisateur['nom']; // Supposons que le champ dans la base de données s'appelle 'nom'
    $prenom = $utilisateur['prenom']; // Supposons que le champ dans la base de données s'appelle 'prenom'
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
include 'db.php'; 

// Récupération des données de la base de données
function getArticles($conn) {
    $sql = "SELECT article.*, utilisateurs.nom AS nom_utilisateur, utilisateurs.prenom AS prenom_utilisateur
    FROM article
    INNER JOIN utilisateurs ON article.id_user = utilisateurs.id";
    $result = $conn->query($sql);
    return $result;
}

// Ajout d'un nouvel article
if(isset($_POST['ajouter_article'])) {
    // Votre code d'ajout d'article ici...
}

// Suppression d'un article
if(isset($_POST['supprimer_article'])) {
    $id_article = $_POST['id_article'];
    $sql = "DELETE FROM article WHERE id=$id_article";
    
    if ($conn->query($sql) === TRUE) {
        echo "Article supprimé avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Votre CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark py-3">
        <div class="container-head">
        <h1 class="text-white head">Palstine's Blogs</h1>
        <h2 class="text-white name">Your Profile : &nbsp<a href="profile.php" class="link-profile nav-link"><?php echo $prenom . ' ' . $nom; ?></a></h2> <!-- Affichage du nom et du prénom -->

        </div>
    </header>
    <nav class="navbar1 navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand navbarlink" href="blogs.php">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profil (<?php echo $prenom . ' ' . $nom; ?>)</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </nav>
    <div class="container-blogs">
        <!-- Affichage des articles existants -->
        <?php
        $result = getArticles($conn);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<section class='articleb mt-4'>";
                echo "<h2 class='h2artb'>" . $row["titre"] . "</h2>";
                echo "<div class='img-containerb'>";
                echo "<img src='" . $row["chemin_image"] . "' class='img-fluid imgartb' alt='Photo de l'article'>";
                echo "</div>";
                echo "<p class='partb'>" . $row["contenu"] . "</p>";
                echo "<p>Publié par: " . $row["prenom_utilisateur"] . " " . $row["nom_utilisateur"] . "</p>";
                echo "<form method='post' class='formartb' action=''>";
                echo "<input type='hidden' name='id_article' class='inpartb' value='" . $row["id"] . "'>";
                echo "</form>";
                echo "</section>";
            }
        } else {
            echo "<p class='mt-4'>0 résultats</p>";
        }
        ?>
    </div>
    <?php
include 'footer.html'; // Include the footer file
?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
