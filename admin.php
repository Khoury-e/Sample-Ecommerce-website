<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<style>
    body {
        font-family: 'Arial', serif;
        color: white;
        background-color: #222;
    }

    h1 {
        text-align: center;
    }

    table {
        margin: 20px;
        color: black;
    }

    thead tr {
        background-color: grey;
    }

    tbody tr {
        background-color: white;
    }

    td {
        border: 1px solid white;
        margin: 0;
        padding: 5px;
        width: calc(100vw/9);
    }

    #forms {
        background-color: white;
        color: black;
        padding: 10px;  
        margin: 10px;
    }

</style>
<body>
    <h1>Admin Dashboard</h1>
   
    <div id="forms">
        <h3>Add A Product</h3>
        <form method="post" action='addProd.php' id='addprodform'>
            <label for="productName">Name:</label>
            <input type="text" name="productName" id="productName" required>

            <label for="productPrice">Price:</label>
            <input type="text" name="productPrice" id="productPrice" required>
            
            <button type="submit">Add Product</button>
        </form>
    </div>
    <div id='forms'>
        <h3>Edit A Product</h3>
        <form  method="post" action='editProd.php'>
            <label for="productId">Id:</label>
            <input name="productId" id="productId" required>

            <label for="productName">Name:</label>
            <input type="text" name="productName" id="productName" required>

            <label for="productPrice">Price:</label>
            <input type="text" name="productPrice" id="productPrice" required>

            <button type="submit">Save Product</button>
        </form>
    </div>

    <div id="product-table">
        <table>
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>Price (in $)</td>
                    <td>Offer (1 if there is an offer, 0 otherwise)</td>
                    <td>Offer Rate (%, 0% if there are no offer)</td>
                    <td>Final Price</td>
                    <td>Created At</td>
                    <td>Updated At</td>
                    <td>Deleted At</td>
                </tr>
            </thead>
            <tbody id='product-table-body'>
            <?php
                    $host = "127.0.0.1";
                    $username = "root";
                    $password = "";
                    $db = "groomifydb";
                
                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
                
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                        $sql = "SELECT Id, Name, Price, Offer, OfferRate, FinalPrice, CreatedAt, UpdatedAt, DeletedAt FROM `products`";
                        $stmt = $pdo->query($sql);
                
                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>{$row['Id']}</td>";
                        echo "<td>{$row['Name']}</td>";
                        echo "<td>{$row['Price']}</td>";
                        echo "<td>{$row['Offer']}</td>";
                        echo "<td>{$row['OfferRate']}</td>";
                        echo "<td>{$row['FinalPrice']}</td>";
                        echo "<td>{$row['CreatedAt']}</td>";
                        echo "<td>{$row['UpdatedAt']}</td>";
                        echo "<td>{$row['DeletedAt']}</td>";
                        echo "</tr>";
                    }
                    } catch (PDOException $e) {
                        echo "Connection failed: ".$e->getMessage();
                    } finally {
                        $pdo = null;
                    } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>