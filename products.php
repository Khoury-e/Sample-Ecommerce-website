<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groomify</title>
    <style>
        @media screen and (max-width: 500px) {
            nav {
                padding: 11px;
            }

            nav button {
                font-size: medium;
                margin-left: 5px;
            }

            nav a {
                font-size: medium;
                margin-left: 5px;
            }

            section {
                padding: 10px;
                text-align: center;
            }

            h2 {
                font-size: 15px;
            }

            .product-card {
                font-size: 18px;
                width: 350px;
            }
        }

        @media screen and (min-width: 501px) {
            nav {
                padding: 20px;
            }

            nav button {
                font-size: larger;
                margin-left: 20px;
            }

            nav a {
                font-size: larger;
                margin-left: 20px;
            }

            section {
                padding: 20px;
                text-align: center;
            }

            h2 {
                font-size: 28px;
            }
            
            .product-card {
                font-size: 20px;
                width: 250px;
            }
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #222;
            color: #fff;
        }

        nav {
            font-size: large;
            display: flex;
            justify-content: left;
            align-items: center;
            background-color: #444;
        }

        nav input {
            border: none;
            border-radius: 20px;
            padding: 11px;
            margin: 0 10px;
            font-size: large;
            width: 40vw;
        }

        nav button {
            color: white;
            background-color: #444;
            border: none;
            padding: 10px;
            text-decoration: underline;
        }

        nav a {
            color: white;
        }

        #product {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .product-card {
            border: 1px solid #555;
            border-radius: 8px;
            margin: 10px;
            padding: 20px;
            background-color: #333;
        }

        .product-image {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-purchase
        {
            background-color: black;
            color: white;
            font-size: medium;
            padding: 8px;
            margin: 10px;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="search">
            <input id="searchbar" type="text" placeholder="Search" onkeyup="search()">
        </div>
        <form action="logout.php" method="post">
            <button name="logout" id="logoutBtn">Log Out</button>
        </form>
        <a href="bill.php" id="checkout">Checkout</a>
        
    </nav>
    <section>
        <h2>Groomify's Featured Products</h2>

        <div id="product">
           <?php
            session_start();
            $host = "127.0.0.1";
            $username = "root";
            $password = "";
            $db = "groomifydb";


            $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT Id, Name, Price, Image FROM `products`";
            $stmt = $pdo->query($sql);

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $pdo = null;
           ?>
        </div>
    </section>
    <script type='text/javascript'>
        
        document.addEventListener("DOMContentLoaded", () => {
        const cart = [];
        const productContainer = document.getElementById("product");
        const productData = <?php echo json_encode($data); ?>; 
        productData.forEach(product => {
            const productCard = document.createElement("div");
            productCard.classList.add("product-card");

            // add image later
            productCard.innerHTML = `
                <img alt='image of product here'>
                <h3 class='prod-name'>${product.Name}</h3>
                <p>Price:$${product.Price}</p>
                <button class="product-purchase">Add to Cart</button>
            `;
            productContainer.appendChild(productCard);
        });

        const productCards = document.querySelectorAll(".product-card");
        productCards.forEach(card => {
            card.querySelector(".product-purchase").addEventListener("click", () => {
                const name = card.querySelector("h3").textContent;
                const price = card.querySelector("p").textContent.slice(6).replace("$", "");
                addToCart(name, price);
            });
        });

        function addToCart(name, price) {
            cart.push({name, price});
            console.log(cart);
        }
    });

        function search() {
            var input = document.getElementById("searchbar");
            var filter = input.value.toUpperCase();
            var products = document.getElementsByClassName("product-card");

            for (let i=0;i<products.length;i++) {
                    let n = products[i].getElementsByTagName("h3")[0];
                    var productVal = n.textContent || n.innerText;
                    if (productVal.toUpperCase().indexOf(filter) > -1) {
                        products[i].style.display = "";
                    }
                    else {
                        products[i].style.display = "none";
                    }
            }
        }    
    </script>
</body>
</html>
