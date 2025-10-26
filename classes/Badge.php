<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Badge.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$badgeManager = new Badge();
$tousBadges = $badgeManager->getAllBadges();
$badgesUtilisateur = $badgeManager->getBadgesUtilisateur($_SESSION['user_id']);

// Créer un tableau des IDs de badges obtenus
$badgesObtenusIds = array_column($badgesUtilisateur, 'id');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMusic 🎵 - Tous les badges</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        
        <!-- Navigation -->
        <nav class="flex justify-between items-center mb-8">
            <a href="profile.php" class="text-white text-lg font-semibold hover:text-purple-200 transition-colors">
                ← Retour au profil
            </a>
            <div class="text-white">
                <?php echo count($badgesObtenusIds); ?>/<?php echo count($tousBadges); ?> badges obtenus
            </div>
        </nav>

        <!-- En-tête -->
        <header class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                🏆 Tous les badges
            </h1>
            <p class="text-xl text-purple-200">
                Découvrez tous les badges à débloquer et votre progression
            </p>
        </header>

        <!-- Grille des badges -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($tousBadges as $badge): 
                $estObtenu = in_array($badge['id'], $badgesObtenusIds);
                $pourcentage = $badgeManager->getPourcentageObtention($badge['id']);
            ?>
            <div class="bg-white rounded-2xl shadow-xl p-6 <?php echo $estObtenu ? '' : 'opacity-75'; ?>">
                <!-- En-tête du badge -->
                <div class="text-center mb-4">
                    <div class="text-5xl mb-3 <?php echo $estObtenu ? '' : 'grayscale'; ?>">
                        <?php echo $badge['icone']; ?>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($badge['nom']); ?></h3>
                    <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars($badge['description']); ?></p>
                </div>

                <!-- Statut -->
                <div class="text-center mb-4">
                    <?php if ($estObtenu): ?>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            ✅ Obtenu
                        </span>
                    <?php else: ?>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                            🔒 À débloquer
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Statistiques -->
                <div class="text-center text-xs text-gray-500">
                    <?php echo $pourcentage; ?>% des joueurs ont ce badge
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>