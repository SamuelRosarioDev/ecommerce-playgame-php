<?php
$host = 'localhost'; 
$user = 'root';
$password_db = '';
$database = 'EcommercePlayGame';

$conn = new mysqli($host, $user, $password_db, $database);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$name = $email = $password_hash = $cep = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_hash = $_POST['password_hash'];
    $cep = $_POST['cep']; 
    if (empty($name) || empty($email) || empty($password_hash) || empty($cep)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $sql = "INSERT INTO Clients (name, email, password_hash, cep) VALUES ('$name', '$email', '$password_hash', '$cep')";

        if ($conn->query($sql) === TRUE) {
            $sucesso = "Novo registro criado com sucesso!";
        } else {
            $erro = "Erro: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Registrar Novo Usuário</h1>

        <?php if (!empty($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php elseif (!empty($sucesso)): ?>
            <div class="success"><?php echo $sucesso; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" >

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" >

            <label for="password_hash">Senha:</label>
            <input type="password" id="password_hash" name="password_hash" value="<?php echo $password_hash; ?>" >

            <label for="cep">Cep:</label>
            <input type="text" id="cep" name="cep" value="<?php echo $cep; ?>" >

            <button type="submit">Registrar</button>
        </form>

    </div>

    <?php
    $conn->close();
    ?>

</body>
</html>