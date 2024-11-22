<?php
$host = 'localhost';
$user = 'root';
$password_db = '';
$database = 'EcommercePlayGame';

$conn = new mysqli($host, $user, $password_db, $database);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$cart = isset($_GET['cart']) ? json_decode($_GET['cart'], true) : [];
$total_geral = 0;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = 1;
    $payment_method = $_POST['payment'] ?? null;

    if (!$payment_method) {
        $error_message = "Por favor, selecione uma opção de pagamento.";
    } elseif (!empty($cart)) {
        foreach ($cart as $product) {
            $id_product = $product['id'];
            $quantity = $product['quantity'];
            $total = $product['price'] * $quantity;

            $stmt = $conn->prepare("INSERT INTO ORDERS (id_client, id_product, quantity, total, payment_method) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiids", $id_client, $id_product, $quantity, $total, $payment_method);
            $stmt->execute();
            $stmt->close();
        }

        echo "<script>
                localStorage.removeItem('cart');
                alert('Compra finalizada com sucesso!');
                window.location.href = '../home';
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div id="cart-container">
    <h1>Seu Carrinho</h1>

        <?php if (empty($cart)): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <?php foreach ($cart as $product): ?>
                <?php
                $total_produto = $product['price'] * $product['quantity'];
                $total_geral += $total_produto;
                ?>
                <div class="product">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="details">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <p>Preço Unitário: R$ <?= number_format($product['price'], 2, ',', '.') ?></p>
                        <p>Total: R$ <?= number_format($total_produto, 2, ',', '.') ?></p>
                        <div class="actions">
                            <button onclick="updateQuantity('<?= $product['id'] ?>', -1)">-</button>
                            <span><?= htmlspecialchars($product['quantity']) ?></span>
                            <button onclick="updateQuantity('<?= $product['id'] ?>', 1)">+</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <h3>Total Geral: R$ <?= number_format($total_geral, 2, ',', '.') ?></h3>
        <?php endif; ?>
        <div id="payment-options">
        <h2>Opções de Pagamento</h2>
        <?php if ($error_message): ?>
            <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>
                <input type="radio" name="payment" value="Boleto"> Boleto Bancário
            </label><br>
            <label>
                <input type="radio" name="payment" value="Cartão"> Cartão de Crédito
            </label><br>
            <label>
                <input type="radio" name="payment" value="PIX"> PIX
            </label><br>
            <button type="submit">Finalizar Compra</button>
        </form>
    </div>
    </div>



    <script>
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        const query = encodeURIComponent(JSON.stringify(cart));
        if (!window.location.href.includes('?cart=')) {
            window.location.href = `${window.location.pathname}?cart=${query}`;
        }

        function updateQuantity(id, change) {
            const updatedCart = cart.map(product => {
                if (product.id === id) {
                    product.quantity += change;
                    if (product.quantity <= 0) {
                        return null;
                    }
                }
                return product;
            }).filter(Boolean);

            localStorage.setItem('cart', JSON.stringify(updatedCart));
            const updatedQuery = encodeURIComponent(JSON.stringify(updatedCart));
            window.location.href = `${window.location.pathname}?cart=${updatedQuery}`;
        }
    </script>
</body>
</html>
