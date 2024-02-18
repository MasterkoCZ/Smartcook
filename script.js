const recipes = [
    { name: "Avocado Toast with Chickpea Scramble",difficulty: 2, duration: 15, description: "A delicious and nutritious breakfast option. Top whole-grain toast with mashed avocado and a flavorful chickpea scramble. Season with salt, pepper, and your favorite spices for an extra kick", imageUrl: "https://skinnyms.com/wp-content/uploads/2019/11/Chickpea-Avocado-Toast-Photo-2.5.jpg" },
    { name: "Mushroom Risotto", difficulty: 3, duration: 45, description:"A creamy and flavorful mushroom risotto. Sauté mushrooms, onions, and garlic, then add Arborio rice and vegetable broth. Stir until the rice is cooked and creamy. Garnish with fresh herbs and vegan Parmesan cheese.", imageUrl: "https://hips.hearstapps.com/delish/assets/17/35/1504128527-delish-mushroom-risotto.jpg" },
    { name: "Quinoa-Stuffed Bell Peppers", difficulty: 3, duration: 50, description: "A wholesome dinner option. Cook quinoa, black beans, corn, and spices. Stuff bell peppers with the mixture, top with vegan cheese, and bake until the peppers are tender. Serve with a side of salsa or guacamole.", imageUrl: "https://www.thespruceeats.com/thmb/FC1kDitBHn08teDrh-gkYeg27VA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/quinoa-stuffed-peppers-2238585-08-43c24df24a3e4aa8991d22337e1ded40.jpg" },
    { name: "Vegan Chocolate Avocado Mousse", difficulty: 2, duration: 20, description: "A guilt-free and creamy chocolate mousse. Blend ripe avocados, cocoa powder, maple syrup, and vanilla extract until smooth. Chill the mixture in the refrigerator and serve cold.", imageUrl: "https://cdn.thelondoneconomic.com/wp-content/uploads/2021/07/093946de-vegan-chocolate-and-avocado-mousse-jonathan-hatchman-scaled.jpg" },
    { name: "Vegetarian Lentil Soup", difficulty: 2, duration: 20, description: "A hearty and wholesome vegetarian soup. Cook lentils, vegetables, and spices in vegetable broth. Season with herbs like thyme and rosemary. Serve hot for a satisfying meal.", imageUrl: "https://www.allrecipes.com/thmb/UeFtapHyGFBo4Lx-72GxgjrOGnk=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/13978-lentil-soup-DDMFS-4x3-edfa47fc6b234e6b8add24d44c036d43.jpg" },
    { name: "Tomato Basil Pasta", difficulty: 1, duration: 20, description: "A delightful Italian classic featuring pasta in a vibrant tomato and basil sauce.", imageUrl: "https://img1.wsimg.com/isteam/ip/c451c370-1b12-4117-85ed-4c20ffaa75b3/A63E29F4-A204-4BBC-8AD9-E309CED7C9CE_1_201_a.jpeg" },
    { name: "Roasted Vegetable Quiche", difficulty: 2, duration: 40, description: "A savory delight filled with roasted vegetables nestled in a light and fluffy egg custard, baked to golden perfection in a buttery crust.", imageUrl: "https://www.stonyfield.com/wp-content/uploads/2023/03/Fall-Vegetable-Quiche.png" },
    { name: "Spicy Thai Curry", difficulty: 2, duration: 30, description: "A tantalizing blend of vibrant spices, coconut milk, and fresh vegetables, simmered to perfection for a taste of authentic Thai cuisine with a fiery kick.", imageUrl: "https://www.surprising.recipes/wp-content/uploads/2023/12/Thai-chicken-coconut-curry-scaled.jpeg" },
    { name: "Mushroom Stroganoff", difficulty: 1, duration: 25, description: "A comforting dish featuring tender mushrooms cooked in a creamy sauce with onions, garlic, and a touch of tangy sour cream, served over a bed of noodles for a satisfying meal.", imageUrl: "https://www.stonyfield.com/wp-content/uploads/2023/03/Beef-Stroganoff.png" },
    { name: "Lemon Herb Grilled Salmon", difficulty: 2, duration: 20, description: "Succulent salmon fillets infused with zesty lemon and aromatic herbs, grilled to perfection for a light and flavorful seafood dish that's both healthy and delicious.", imageUrl: "https://img1.wsimg.com/isteam/ip/c451c370-1b12-4117-85ed-4c20ffaa75b3/IMG_7694.jpeg" },
  ];
  
  function displayRecipes(recipes) {
    const list = document.getElementById('recipe-list');
    list.innerHTML = '';
    recipes.forEach(recipe => {
      const item = document.createElement('div');
      item.className = 'recipe';
      item.innerHTML = `<img src="${recipe.imageUrl}" alt="${recipe.name}">
                        <h3>${recipe.name}</h3>
                        <p>${recipe.description}</p> <!-- Added recipe description here -->
                        <p><strong>Difficulty:</strong> ${recipe.difficulty}</p>
                        <p><strong>Duration:</strong> ${recipe.duration} mins</p>`;
      list.appendChild(item);
    });
  }


  function filterRecipes() {
    const searchQuery = document.getElementById('searchField').value.toLowerCase();
    const filteredRecipes = allRecipes.filter(recipe => recipe.name.toLowerCase().includes(searchQuery));
    displayRecipes(filteredRecipes);
  }
  
  function sortRecipes(event) {
    const sortBy = event.target.value;
    const sortedRecipes = recipes.sort((a, b) => (a[sortBy] > b[sortBy]) ? 1 : -1);
    displayRecipes(sortedRecipes);
  }
  
  displayRecipes(recipes);

