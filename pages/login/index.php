<?php
$host = 'localhost';
$user = 'root';
$password_db = ''; 
$database = 'EcommercePlayGame'; 
$conn = new mysqli($host, $user, $password_db, $database);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$email = $password = "";
$erro = "";
$usuario_logado = null; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $sql = "SELECT id, name, email, password_hash, cep, isAdmin FROM Clients WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password_hash']) {
                $usuario_logado = $row;
            } else {
                $erro = "Senha incorreta!";
            }
        } else {
            $erro = "E-mail não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <link rel="stylesheet" href="styles.css?version=1.0">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>

            <button type="submit">Entrar</button>
        </form>
        <div class="back-to-register">
            <a href="/pages/register">Ir para o Registro</a>
        </div>
    </div>

    <script>
        <?php if ($usuario_logado): ?>
            const usuario = {
                id: "<?php echo $usuario_logado['id']; ?>",
                name: "<?php echo $usuario_logado['name']; ?>",
                email: "<?php echo $usuario_logado['email']; ?>",
                password_hash: "<?php echo $usuario_logado['password_hash']; ?>",
                cep: "<?php echo $usuario_logado['cep']; ?>",
                isAdmin: "<?php echo $usuario_logado['isAdmin']; ?>",
            };

            localStorage.setItem('client', JSON.stringify(usuario));

            window.location.href = "../home";
        <?php endif; ?>
    </script>

    <?php
    $conn->close();
    ?>

</body>
</html>
