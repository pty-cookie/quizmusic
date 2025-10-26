<?php
// === SAUVEGARDE DES SCORES ===

// Nouveau score
$nouvelle_entree = [
    "joueur" => "Anonyme", // à remplacer plus tard par $_SESSION['nom'] si on gère les joueurs
    "theme" => $_SESSION['dernier_theme'] ?? "Inconnu",
    "score" => $_SESSION['dernier_score'] ?? 0,
    "total" => $_SESSION['total_questions'] ?? 5,
    "date" => date("Y-m-d H:i:s")
];

// Charger l’historique existant
$historique = [];
if (file_exists("scores.json")) {
    $contenu = file_get_contents("scores.json");
    $historique = json_decode($contenu, true) ?? [];
}

// Ajouter le nouveau score
$historique[] = $nouvelle_entree;

// Sauvegarder au format JSON lisible
file_put_contents("scores.json", json_encode($historique, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
?>
