<?php
session_start();

// se não veio do cadastro, volta
if (!isset($_SESSION['cad_email'], $_SESSION['cad_senha_hash'])) {
    header("Location: telacadastro.php");
    exit;
}

$mensagem = "";
$tipo = ""; // success ou danger

$email      = $_SESSION['cad_email'];
$senha_hash = $_SESSION['cad_senha_hash'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome            = $_POST['nome'] ?? '';
    $telefone        = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    // segurança extra: limita telefone a 11 no backend
    if (strlen($telefone) > 11) {
        $mensagem = "Telefone deve ter no máximo 11 caracteres.";
        $tipo = "danger";
    } elseif (empty($nome) || empty($telefone) || empty($data_nascimento)) {
        $mensagem = "Preencha todos os campos.";
        $tipo = "danger";
    } else {

        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "FITWAY";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            $mensagem = "Falha na conexão com o banco.";
            $tipo = "danger";
        } else {
            $sql = "INSERT INTO Usuarios 
                       (nome, email, senha, telefone, data_nascimento, data_cadastro) 
                    VALUES (?, ?, ?, ?, ?, CURDATE())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nome, $email, $senha_hash, $telefone, $data_nascimento);

            if ($stmt->execute()) {
                $mensagem = "Cadastro concluído com sucesso!";
                $tipo = "success";

                // limpa a sessão do cadastro parcial
                unset($_SESSION['cad_email'], $_SESSION['cad_senha_hash']);
            } else {
                $mensagem = "Erro ao salvar no banco. Talvez o email já exista.";
                $tipo = "danger";
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Completar cadastro - FitWay</title>

  <link rel="stylesheet" href="../CSS/telacadastro.css">
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="wrapper">

    <!-- Botão de voltar pro login (se quiser mudar o destino, pode) -->
    <a href="../PHP/telalogin.php">
        <button type="button" id="btn-back">
            <i class='bx bx-arrow-left-stroke' style='color:white'></i>
        </button>
    </a>

    <form method="POST" action="">
        <h1>Complete seu cadastro</h1>

        <div class="input-box">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <i class='bx  bx-user' style='color:#ffffff'></i> 
        </div>

        <div class="input-box">
            <!-- Limite de 10 caracteres no HTML -->
            <input type="tel" name="telefone" placeholder="Telefone" maxlength="11" required>
            <i class='bx  bx-phone' style='color:#ffffff'></i> 
        </div>

        <div class="input-box">
            <input type="date" name="data_nascimento" required>
        </div>

        <button type="submit" class="btn">Salvar dados</button>
    </form>
</div>

<!-- MODAL DE RESULTADO -->
<div class="modal fade" id="resultadoModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content <?php echo $tipo ? "border-$tipo" : ""; ?>">
      <div class="modal-header bg-<?php echo $tipo ?: 'secondary'; ?> text-white">
        <h5 class="modal-title">
            <?php 
              if ($tipo == "success") echo "Sucesso!";
              elseif ($tipo == "danger") echo "Erro!";
              else echo "Aviso";
            ?>
        </h5>
      </div>
      <div class="modal-body">
        <p><?php echo $mensagem; ?></p>
      </div>
      <div class="modal-footer">
        <?php if ($tipo == "success"): ?>
            <a href="../PHP/telalogin.php" class="btn btn-success">Ir para login</a>
        <?php else: ?>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($mensagem)): ?>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
    myModal.show();
</script>
<?php endif; ?>

</body>
</html>
