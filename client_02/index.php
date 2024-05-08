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
            echo "<div class='recipe' onclick='showIngredients(" . $recipe['id'] . ")'>"; // Opraveno na recipe['id']
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
    fetch('get_recipe_ingredients.php?recipe_id=' + recipe_id)
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
            var modalContent = "<h2>" + data.title + "</h2>";

            fetch('req-ingredients.php?recipe_id=' + recipe_id)
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error " + response.status);
                }
                return response.text();
            })
            .then(text => {
                let startIndex = text.indexOf('{');
                let endIndex = text.lastIndexOf('}') + 1;
                let jsonResponse = text.slice(startIndex, endIndex);
                
                console.log('Final JSON Response:', jsonResponse);
                const ingredientsData = JSON.parse(jsonResponse);

                if (ingredientsData.data && Array.isArray(ingredientsData.data) && ingredientsData.data.length > 0) {
                    modalContent += "<ul>";
                    ingredientsData.data.forEach(function(ingredient) {
                        modalContent += "<li>" + ingredient.name + "</li>";
                    });
                    modalContent += "</ul>";
                } else {
                    modalContent += "<p>No ingredients found.</p>";
                }

                document.getElementById("modal").innerHTML = modalContent;
                document.getElementById("modal").style.display = "block";
            })
            .catch(err => {
                console.log('Chyba při zpracování ingrediencí:', err);
            });
        })
        .catch(err => {
            console.log('Chyba při získávání názvu receptu:', err);
        });
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
</script>


    </div>

    <div id="modal" class="modal"></div>
</body>
</html>
