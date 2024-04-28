<?php
// get_recipe_ingredients.php

// Připojení k API nebo načtení potřebných knihoven
require_once("SmartCookClient.php");

try {
    // Získání ID receptu z parametru
    $recipe_id = isset($_GET['recipe_id']) ? $_GET['recipe_id'] : null;

    // Kontrola, zda bylo poskytnuto ID receptu
    if ($recipe_id === null) {
        throw new Exception('Recipe ID is missing.');
    }

    // Volání API pro získání ingrediencí konkrétního receptu
    $response = (new SmartCookClient)
        ->sendRequest("recipes/{$recipe_id}/ingredients") // Změna URL na získání ingrediencí konkrétního receptu
        ->getResponseData();

    // Nastavení hlavičky Content-Type na JSON
    header('Content-Type: application/json');

    // Výstup v JSON formátu
    echo json_encode($response);

} catch (Exception $e) {
    // V případě chyby vracíme chybovou zprávu
    echo json_encode(['error' => $e->getMessage()]);
}
?>
