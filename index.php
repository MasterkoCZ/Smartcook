<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCook</title>
    <style>
        /* Styly pro celou stránku */
        body {
            margin: 0;
            padding: 0;
            background-color: #fac564;
            background-image: url('https://www.transparenttextures.com/patterns/food.png');
            font-family: Arial, sans-serif;
            text-align: center; /* Zarovnání textu ve středu */
        }

        /* Styly pro nadpis */
        h1 {
            color: rgb(38,44,60);
            margin-top: 50px; /* Odsazení od horního okraje */
        }

        /* Styl pro kontejner receptů */
        .recipes-container {
            display: flex; /* Použití flexboxu */
            flex-wrap: wrap; /* Zalomení na další řádky */
            justify-content: center; /* Zarovnání doprostřed */
            margin-top: 20px; /* Odsazení od nadpisu */
        }

        /* Styl pro jednotlivé recepty */
        .recipe {
            color: rgb(38,44,60);
            width: 300px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(240, 248, 255, 0.9);
            box-shadow: 0 0 8px rgb(38,44,60);
            transition: transform 0.3s; /* Plynulý přechod */
            cursor: pointer; /* Změna kurzoru na ruku při najetí */
        }

        /* Při najetí myší na recept */
        .recipe:hover {
            transform: scale(1.05); /* Zvětšení o 5% */
        }

        /* Styl pro modální okno */
        .modal {
            display: none; /* Okno není zobrazeno */
            position: fixed;
            z-index: 1; /* Překrývá všechny ostatní prvky */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Scrollování, pokud obsah přesahuje velikost okna */
            background-color: rgba(0,0,0,0.4); /* Částečně průhledné pozadí */
        }

        /* Styl pro obsah modálního okna */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* Zarovnání na střed */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* Tlačítko pro zavření modálního okna */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        /* Styl pro tlačítko zavření, při najetí myší */
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

<!-- Skript pro zobrazení modálního okna s ingrediencemi receptu -->
<script>
function showIngredients(recipe_id) {
    // Získání ingrediencí receptu z API
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var ingredients = JSON.parse(this.responseText);
            displayIngredientsModal(ingredients);
        }
    };
    xhr.open("GET", "get_recipe_ingredients.php?recipe_id=" + recipe_id, true); // Oprava jména parametru
    xhr.send();
}

    // Funkce pro zobrazení modálního okna s ingrediencemi
    function displayIngredientsModal(ingredients) {
        var modalContent = "<div class='modal-content'>";
        modalContent += "<span class='close' onclick='closeModal()'>&times;</span>"; // Tlačítko zavření
        modalContent += "<h2>Ingredients</h2>";

        // Zkontrolujte, zda jsou ingredience polem
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

        // Vložení obsahu do modálního okna
        document.getElementById("modal").innerHTML = modalContent;

        // Zobrazení modálního okna
        document.getElementById("modal").style.display = "block";
    }

    // Funkce pro zavření modálního okna
    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }
</script>

    </div>

    <!-- Modální okno pro zobrazení ingrediencí -->
    <div id="modal" class="modal"></div>
</body>
</html>
