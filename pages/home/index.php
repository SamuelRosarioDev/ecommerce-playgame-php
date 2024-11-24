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
    <link rel="stylesheet" href="styles.css">
    <title>Produtos</title>
</head>
<body>
    
    <nav class="navbar">
        <div class="logo">
            <p>Play Game</p>
        </div>
        <ul class="nav-links">
            <li><a href="/pages/login">Logar</a></li>
            <li><a href="/pages/cart">Carrinho</a></li>
            <li><a href="/pages/contact">Contato</a></li>
        </ul>
    </nav>

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

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 EcommercePlayGame. Todos os direitos reservados.</p>
            <ul class="footer-links">
                <li><a href="/pages/privacy">Política de Privacidade</a></li>
                <li><a href="/pages/terms">Termos de Serviço</a></li>
                <p>Feito por Luis e Samuel.</p>
            </ul>
        </div>
    </footer>

</body>
<script src="./script.js"></script>
</html>
