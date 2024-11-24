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

// Função para calcular o frete com base no valor total do carrinho
function calcularFrete($cep, $cart) {
    $total_carrinho = 0;

    // Calculando o valor total do carrinho
    foreach ($cart as $product) {
        $total_carrinho += $product['price'] * $product['quantity'];
    }

    // Definindo o valor do frete com base no valor total do carrinho
    if ($total_carrinho >= 100) {
        $frete = 20.00; // Frete mais barato para pedidos acima de R$100
    } else {
        $frete = 30.00; // Frete mais caro para pedidos abaixo de R$100
    }

    // Verificando o CEP para aplicar um desconto ou frete diferente
    if (substr($cep, 0, 3) === "660") {
        $desconto_frete = 10.00;
        $frete -= $desconto_frete; // Aplica o desconto ao frete
    } elseif (substr($cep, 0, 3) === "668") {
        $desconto_frete = 5.00;
        $frete -= $desconto_frete;
    } else {
        $desconto_frete = 0; // Sem desconto
    }

    return [$frete, $desconto_frete]; // Retorna o valor do frete e o desconto aplicado
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = 1; // ID do cliente fixo para exemplo
    $payment_method = $_POST['payment'] ?? null;
    $cep = $_POST['cep'] ?? null; // Recebe o CEP do cliente via formulário

    // Valida se o CEP foi fornecido
    if (!$cep) {
        $error_message = "Por favor, insira seu CEP para continuar.";
    } else {
        // Remove caracteres não numéricos do CEP
        $cep = preg_replace('/[^0-9]/', '', $cep);
        $viacep_url = "https://viacep.com.br/ws/$cep/json/";

        // Consulta à API ViaCEP
        $viacep_response = file_get_contents($viacep_url);
        $viacep_data = json_decode($viacep_response, true);

        if (isset($viacep_data['erro']) && $viacep_data['erro'] === true) {
            $error_message = "O CEP informado é inválido.";
        } elseif (!$payment_method) {
            $error_message = "Por favor, selecione uma opção de pagamento.";
        } elseif (!empty($cart)) {
            // Calcula o valor do frete e o desconto
            list($frete, $desconto_frete) = calcularFrete($cep, $cart);
            
            foreach ($cart as $product) {
                $id_product = $product['id'];
                $quantity = $product['quantity'];
                $total = $product['price'] * $quantity;

                // Agora inclui o valor do desconto diretamente na tabela ORDERS
                $stmt = $conn->prepare("INSERT INTO ORDERS (id_client, id_product, quantity, total, payment_method, cep, frete, desconto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiidssss", $id_client, $id_product, $quantity, $total, $payment_method, $cep, $frete, $desconto_frete);
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
}
?>

<!-- Código HTML permanece o mesmo -->


<?php
// O restante do seu código PHP continua o mesmo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="styles.css?version=1.0">
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
            <?php
                // Cálculo do frete
                if (isset($cep) && $cep && !$error_message) {
                    list($frete, $desconto_frete) = calcularFrete($cep, $cart);
                    echo "<p>Frete: R$ " . number_format($frete, 2, ',', '.') . "</p>";
                }
            ?>
        <?php endif; ?>

        <div id="payment-options">
            <?php if ($error_message): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" required placeholder="Insira seu CEP" readonly>
                
                <h3>Formas de Pagamento</h3>
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
        const user = JSON.parse(localStorage.getItem('client')) || {};  // Supondo que o usuário esteja armazenado no localStorage
        
        const query = encodeURIComponent(JSON.stringify(cart));
        if (!window.location.href.includes('?cart=')) {
            window.location.href = `${window.location.pathname}?cart=${query}`;
        }

        // Preenche o campo de CEP com o valor do usuário, se disponível
        if (user && user.cep) {
            document.getElementById('cep').value = user.cep;
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
