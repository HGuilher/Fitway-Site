<?php
session_start();

if (!isset($_SESSION['usuario_email'])) {
    header("Location: telalogin.php");
    exit;
}

$emailSessao = $_SESSION['usuario_email'];

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "FITWAY";

$conn = new mysqli($servername, $username, $password, $dbname);

$msg = "";

// se clicou para alterar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['alterar'])) {
    $novoNome     = $_POST['nome'] ?? '';
    $novoTelefone = $_POST['telefone'] ?? '';

    $novoTelefone = substr($novoTelefone, 0, 11);

    $sql = "UPDATE Usuarios SET nome = ?, telefone = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $novoNome, $novoTelefone, $emailSessao);
    $stmt->execute();
    $stmt->close();
    
    $msg = "Dados atualizados com sucesso!";
}

// buscar dados atuais
$sql = "SELECT nome, email, telefone, data_nascimento, data_cadastro 
        FROM Usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $emailSessao);
$stmt->execute();
$result = $stmt->get_result();

$usuario = $result->fetch_assoc();

$nome         = $usuario['nome'];
$email        = $usuario['email'];
$telefone     = $usuario['telefone'];
$dataNasc     = $usuario['data_nascimento'];
$dataCadastro = $usuario['data_cadastro'];

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área do Usuário - FitWay</title>

  <link rel="stylesheet" href="../CSS/areadousuario.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="profile-container">
  <h1>Área do Usuário</h1>

  <?php if (!empty($msg)): ?>
      <p class="success-msg"><?php echo $msg; ?></p>
  <?php endif; ?>

  <form method="POST" class="profile-form">
    <div class="profile-group">
      <label class="profile-label">Nome</label>
      <input class="profile-input" type="text" name="nome" id="campoNome"
             value="<?php echo htmlspecialchars($nome); ?>" readonly>
    </div>

    <button type="button" id="alterarNomeBtn" class="alterar-btn">Alterar Nome</button>


     <div class="profile-group">
      <label class="profile-label">Email</label>
      <input class="profile-input" type="email"
             value="<?php echo htmlspecialchars($email); ?>" readonly>
    </div>


    <div class="profile-group">
      <label class="profile-label">Telefone</label>
      <input class="profile-input" type="text" maxlength="11"
             name="telefone" id="campoTelefone"
             value="<?php echo htmlspecialchars($telefone); ?>" readonly>
    </div>

    <button type="button" id="alterarTelBtn" class="alterar-btn">Alterar Telefone</button>

    <div class="profile-group">
      <label class="profile-label">Data de nascimento</label>
      <input class="profile-input" type="text"
             value="<?php echo htmlspecialchars($dataNasc); ?>" readonly>
    </div>

    <div class="profile-group">
      <label class="profile-label">Conta criada em</label>
      <span class="profile-text"><?php echo htmlspecialchars($dataCadastro); ?></span>
    </div>

    <button type="submit" name="alterar" id="btnSalvar" class="salvar-btn" style="display:none;">
      Salvar alterações
    </button>

    <a href="../PHP/telalogin.php" class="logout-btn">Sair</a>
  </form>
</div>


<script>
// Manipulador Nome
document.getElementById("alterarNomeBtn").addEventListener("click", function () {
    const campoNome = document.getElementById("campoNome");
    campoNome.readOnly = false;

    document.getElementById("btnSalvar").style.display = "block";
});

// Manipulador Telefone
document.getElementById("alterarTelBtn").addEventListener("click", function () {
    const campoTelefone = document.getElementById("campoTelefone");
    campoTelefone.readOnly = false;

    document.getElementById("btnSalvar").style.display = "block";
});
</script>
</body>
</html>
