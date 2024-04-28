<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCook</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fac564;
            background-image: url('https://www.transparenttextures.com/patterns/food.png');
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h1 {
            color: rgb(38,44,60);
            margin-top: 50px;
        }

        .recipes-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .recipe {
            color: rgb(38,44,60);
            width: 300px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(240, 248, 255, 0.9);
            box-shadow: 0 0 8px rgb(38,44,60);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .recipe:hover {
            transform: scale(1.05);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }


        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>SmartCook 2024</h1>
    <div class="recipes-container">
    <?php
    require_once("SmartCookClient.php");

    $request_data = [
        "attributes" => ["id", "name", "author"],
    ];

    try {
        $data = (new SmartCookClient)
            ->setRequestData($request_data)
            ->sendRequest("recipes")
            ->getResponseData();

        foreach ($data['data'] as $recipe) {
            echo "<div class='recipe' onclick='showIngredients(" . $recipe['id'] . ")'>";
            echo "<p><strong>Name:</strong> " . $recipe['name'] . "</p>";
            echo "<p><strong>Author:</strong> " . $recipe['author'] . "</p>";
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>

<script>
function showIngredients(recipe_id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var ingredients = JSON.parse(this.responseText);
            displayIngredientsModal(ingredients);
        }
    };
    xhr.open("GET", "get_recipe_ingredients.php?recipe_id=" + recipe_id, true);
    xhr.send();
}

    function displayIngredientsModal(ingredients) {
        var modalContent = "<div class='modal-content'>";
        modalContent += "<span class='close' onclick='closeModal()'>&times;</span>";
        modalContent += "<h2>Ingredients</h2>";

        if (Array.isArray(ingredients) && ingredients.length > 0) {
            modalContent += "<ul>";
            ingredients.forEach(function(ingredient) {
                modalContent += "<li>" + ingredient.name + "</li>";
            });
            modalContent += "</ul>";
        } else {
            modalContent += "<p>No ingredients found.</p>";
        }

        modalContent += "</div>";

        document.getElementById("modal").innerHTML = modalContent;

        document.getElementById("modal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }
</script>

    </div>

    <div id="modal" class="modal"></div>
</body>
</html>
