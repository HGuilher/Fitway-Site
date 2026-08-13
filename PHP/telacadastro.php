<?php
session_start();

$mensagem = "";
$tipo = ""; // danger para erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'] ?? '';
    $senha    = $_POST['senha'] ?? '';
    $confirma = $_POST['confirma_senha'] ?? '';

    if ($senha !== $confirma) {
        $mensagem = "As senhas não coincidem!";
        $tipo = "danger";
    } elseif (empty($email) || empty($senha)) {
        $mensagem = "Preencha todos os campos.";
        $tipo = "danger";
    } else {
        // conectar para ver se tem algum email ja existente
        $servername = "localhost";
        $username   = "root";
        $passwordDB = "";
        $dbname     = "FITWAY";

        $conn = new mysqli($servername, $username, $passwordDB, $dbname);

        if ($conn->connect_error) {
            $mensagem = "Falha na conexão com o banco.";
            $tipo = "danger";
        } else {
            $sql  = "SELECT ID FROM Usuarios WHERE email = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $mensagem = "Este e-mail já está cadastrado. Use outro ou faça login.";
                $tipo = "danger";
            } else {
                // email livre
                $_SESSION['cad_email']      = $email;
                $_SESSION['cad_senha_hash'] = password_hash($senha, PASSWORD_DEFAULT);

                $stmt->close();
                $conn->close();

                header("Location: completarcadastro.php");
                exit;
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitway - Cadastro</title>

    <link rel="stylesheet" href="../CSS/telacadastro.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="wrapper">
    <a href="../PHP/telalogin.php">
        <button type="button" id="btn-back">
            <i class='bx bx-arrow-left-stroke' style='color:white'></i>
        </button>
    </a>


    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-<?php echo $tipo; ?> mt-3 w-100">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>


    <form method="POST" action="">
        <h1>Cadastro</h1>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class='bx bx-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <i class='bx  bx-eye-alt' id="toggleSenha" style="cursor:pointer;"></i>
        </div>

        <div class="input-box">
            <input type="password" name="confirma_senha" id="confirma" placeholder="Confirmar senha" required>
            <i class='bx  bx-eye-alt' id="toggleConfirma" style="cursor:pointer;"></i>
        </div>

        <button type="submit" class="btn">Continuar</button>
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

    if (toggleConfirma && inputConfirma) {
        toggleConfirma.addEventListener('click', function () {
            if (inputConfirma.type === 'password') {
                inputConfirma.type = 'text';
            } else {
                inputConfirma.type = 'password';
            }
        });
    }
});
</script>

</body>
</html>
