<?php
require_once("SmartCookClient.php");

try {
    if (isset($_GET['recipe_id'])) {
        $response = (new SmartCookClient)
            ->setRequestData(['recipe_id' => $_GET['recipe_id']])
            ->sendRequest("ingredients")
            ->getResponseData();

        if ($response['stat'] === "ok") {
            echo json_encode($response['data']);
        } else {
            http_response_code(400);
            echo $response['error_message'];
        }
    } else {
        http_response_code(400);
        echo 'No recipe id provided';
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
?>
