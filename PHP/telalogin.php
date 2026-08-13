<?php
session_start();

$mensagem = "";
$tipo = ""; // danger para erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $servername = "localhost";
    $username   = "root";
    $passwordDB = "";
    $dbname     = "FITWAY";

    $conn = new mysqli($servername, $username, $passwordDB, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Email não existe
    if ($result->num_rows === 0) {
        $mensagem = "Email não encontrado!";
        $tipo = "danger";
    } else {
        $row = $result->fetch_assoc();

        // Senha errada
        if (!password_verify($senha, $row['senha'])) {
            $mensagem = "Senha incorreta!";
            $tipo = "danger";
        } else {
            // Login OK
            $_SESSION['usuario_email'] = $row['email'];
            header("Location: ../PHP/areadousuario.php");
            exit;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitway - Tela de Login</title>

    <link rel="stylesheet" href="../CSS/telalogin.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap só pros alerts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="wrapper">

    <!-- ALERTA DE ERRO (se houver) -->
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-<?php echo $tipo; ?> w-100 mt-2">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <a href="../HTML/telainicial.html">
            <button type="button" id="btn-back">
                <i class='bx bx-arrow-left-stroke' style='color:white'></i>
            </button>
        </a>

        <h1>Login</h1>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class='bx bx-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <i class='bx bx-eye-alt' id="toggleSenha" style="cursor:pointer;"></i>
        </div>

        <button type="submit" class="btn">Entrar</button>

        <div class="register-link"><br>
            <p>Não tem uma conta? <a href="telacadastro.php">Cadastre-se!</a></p>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleSenha    = document.getElementById('toggleSenha');
    const toggleConfirma = document.getElementById('toggleConfirma');
    const inputSenha     = document.getElementById('senha');
    const inputConfirma  = document.getElementById('confirma');

    if (toggleSenha && inputSenha) {
        toggleSenha.addEventListener('click', function () {
            if (inputSenha.type === 'password') {
                inputSenha.type = 'text';
            } else {
                inputSenha.type = 'password';
            }
        });
    }
});
</script>
</body>
</html>