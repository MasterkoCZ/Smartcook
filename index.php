<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <style>
        .recipe {
            width: 300px;
            float: left;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Recipes</h1>
    <div>
        <?php
        require_once("SmartCookClient.php");

        $request_data = [
            "attributes" => ["id", "name", "author"],
            "filter" => [
                "author" => ["Razák Josef"],
                "ingredient" => []
            ]
        ];

        try {
            $data = (new SmartCookClient)
                ->setRequestData($request_data)
                ->sendRequest("recipes")
                ->getResponseData();

            foreach ($data['data'] as $recipe) {
                echo "<div class='recipe'>";
                echo "<p><strong>Name:</strong> " . $recipe['name'] . "</p>";
                echo "<p><strong>Author:</strong> " . $recipe['author'] . "</p>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
