<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit();
}

// Gera um token CSRF para exclusão segura
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Conectar ao banco de dados
$servidor = "localhost";
$usuario = "embra_usuario";
$senha = "uRXA1r9Z7pv~Cw";
$banco = "embra_orcamentos";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Função para carregar contatos com verificação de erros
function carregarContatos($conexao) {
    $contatos = array();
    $sql = "SELECT * FROM orcamentos ORDER BY data_envio DESC";
    $result = $conexao->query($sql);
    
    // Verifica se houve erro na execução da consulta SQL
    if ($result === false) {
        die("Erro na consulta SQL: " . $conexao->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contatos[] = $row;
        }
    }

    return $contatos;
}

// Processa a exclusão de contatos com verificação de token CSRF
if (isset($_GET['delete']) && isset($_GET['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM orcamentos WHERE id=?";
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        exit();
    } else {
        die("Erro ao preparar a consulta de exclusão: " . $conexao->error);
    }
}

// Carrega os contatos
$contatos = carregarContatos($conexao);

// Verifica se os contatos foram carregados corretamente
if (empty($contatos)) {
    echo "Nenhum contato encontrado.";
} else {
    // Debug: Exibe os contatos carregados (apenas para depuração)
    echo "<pre>";
    var_dump($contatos);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Contatos</title>
    <!-- Link para o CSS -->
    <link rel="stylesheet" href="admin_styles3.css">
</head>

<body>
    <!-- Conteúdo principal -->
    <div class="container">
        <div class="top-bar">
            <h1>Lista de Contatos</h1>
            <div class="top-bar-buttons">
                <button id="add-contact-btn">Adicionar Contato</button>
                <a href="logout.php" class="logout-btn">Sair</a>
            </div>
        </div>

        <?php if (!empty($contatos)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Descrição do Orçamento</th>
                        <th>Data de Envio</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($contatos as $contato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contato['nome']); ?></td>
                        <td><?php echo htmlspecialchars($contato['email']); ?></td>
                        <td><?php echo htmlspecialchars($contato['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($contato['cidade']); ?></td>
                        <td><?php echo htmlspecialchars($contato['estado']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($contato['descricao'])); ?></td>
                        <td><?php echo htmlspecialchars($contato['data_envio']); ?></td>
                        <td>
                            <a href="?delete=<?php echo $contato['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este contato?');">Deletar</a>
                            <a href="#" class="edit-btn" onclick="openEditModal(<?php echo $contato['id']; ?>)">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>Nenhum contato encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script>
        // Função para abrir o modal de edição com os dados corretos
        function openEditModal(id) {
            var modal = document.getElementById("edit-contact-modal");
            modal.classList.add("show");

            var contato = <?php echo json_encode($contatos); ?>;
            var contatoSelecionado = contato.find(c => c.id == id);

            document.getElementById("edit-id").value = contatoSelecionado.id;
            document.getElementById("edit-nome").value = contatoSelecionado.nome;
            document.getElementById("edit-email").value = contatoSelecionado.email;
            document.getElementById("edit-telefone").value = contatoSelecionado.telefone;
            document.getElementById("edit-cidade").value = contatoSelecionado.cidade;
            document.getElementById("edit-estado").value = contatoSelecionado.estado;
            document.getElementById("edit-descricao").value = contatoSelecionado.descricao;
        }
    </script>
</body>
</html>
