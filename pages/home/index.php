<?php
$host = 'localhost'; 
$user = 'root'; 
$password_db = ''; 
$database = 'EcommercePlayGame'; 

$conn = new mysqli($host, $user, $password_db, $database);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .links {
            text-align: center;
            margin-bottom: 20px;
        }

        .links a {
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 10px;
        }

        .product {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product:hover {
            transform: translateY(-10px);
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product h3 {
            font-size: 1.2em;
            margin-top: 15px;
            color: #333;
        }

        .product p {
            font-size: 0.9em;
            color: #666;
            margin: 10px 0;
        }

        .product .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }

        .btn-buy {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .btn-buy:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .products {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }

            .product {
                padding: 15px;
            }

            .product h3 {
                font-size: 1em;
            }

            .product .price {
                font-size: 1em;
            }

            .btn-buy {
                font-size: 0.9em;
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5em;
            }

            .links a {
                font-size: 16px;
            }

            .products {
                grid-template-columns: 1fr;
            }

            .product {
                padding: 10px;
            }

            .product h3 {
                font-size: 1em;
            }

            .product .price {
                font-size: 1.1em;
            }

            .btn-buy {
                font-size: 0.9em;
                padding: 8px 14px;
            }
        }
    </style>
</head>
<body>
    
    <div class="links">
        <h1>Produtos</h1>
        <a href="/pages/cart">Cart</a>
    </div>

    <div class="products">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<p class="price">R$ ' . number_format($row['price'], 2, ',', '.') . '</p>';
                echo '<button type="button" class="btn-buy" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] .'" data-description="' . $row['description'] . '">Comprar</button>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhum produto encontrado.</p>';
        }

        $conn->close();
        ?>
    </div>

</body>
<script src="./script.js"></script>
</html>
