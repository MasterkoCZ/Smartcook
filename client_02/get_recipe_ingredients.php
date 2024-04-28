<?php
require_once("SmartCookClient.php");

try {
    $recipe_id = isset($_GET['recipe_id']) ? $_GET['recipe_id'] : null;

    if ($recipe_id === null) {
        throw new Exception('Recipe ID is missing.');
    }

    $response = (new SmartCookClient)
        ->sendRequest("recipes/{$recipe_id}/ingredients")
        ->getResponseData();

    header('Content-Type: application/json');

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
