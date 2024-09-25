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

// Processa a edição de contatos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nome = htmlspecialchars(trim($_POST['nome']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars(trim($_POST['telefone']), ENT_QUOTES, 'UTF-8');
    $cidade = htmlspecialchars(trim($_POST['cidade']), ENT_QUOTES, 'UTF-8');
    $estado = htmlspecialchars(trim($_POST['estado']), ENT_QUOTES, 'UTF-8');
    $descricao = htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE orcamentos SET nome=?, email=?, telefone=?, cidade=?, estado=?, descricao=? WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssssi", $nome, $email, $telefone, $cidade, $estado, $descricao, $id);
    $stmt->execute();
    $stmt->close();

    // Redireciona para a página de sucesso
    header('Location: index.php');
    exit();
}

// Carrega os contatos
$contatos = carregarContatos($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Contatos</title>
    <link rel="stylesheet" href="admin_styles3.css">
</head>

<body>
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

    <!-- Modal de edição de contato -->
    <div id="edit-contact-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Editar Contato</h2>
            <form action="index.php" method="post" class="edit-contact-form">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="editar" value="1">
                <div class="form-row">
                    <div class="input-group">
                        <label for="edit-nome">Nome Completo</label>
                        <input type="text" id="edit-nome" name="nome" required>
                    </div>
                    <div class="input-group">
                        <label for="edit-email">E-mail</label>
                        <input type="email" id="edit-email" name="email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label for="edit-telefone">Telefone</label>
                        <input type="text" id="edit-telefone" name="telefone" required>
                    </div>
                    <div class="input-group">
                        <label for="edit-cidade">Cidade</label>
                        <input type="text" id="edit-cidade" name="cidade" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label for="edit-estado">Estado</label>
                        <input type="text" id="edit-estado" name="estado" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label for="edit-descricao">Descrição do Orçamento</label>
                        <textarea id="edit-descricao" name="descricao" required></textarea>
                    </div>
                </div>
                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        var editModal = document.getElementById("edit-contact-modal");
        var editSpan = document.getElementsByClassName("close-btn")[0];

        // Função para abrir o modal de edição com os dados corretos
        function openEditModal(id) {
            editModal.style.display = "block";

            // Debug: Verifique se a função está sendo chamada corretamente
            console.log("Abrindo modal para o ID:", id);

            var contato = <?php echo json_encode($contatos); ?>;
            var contatoSelecionado = contato.find(c => c.id == id);

            // Preenche os campos com os dados do contato
            document.getElementById("edit-id").value = contatoSelecionado.id;
            document.getElementById("edit-nome").value = contatoSelecionado.nome;
            document.getElementById("edit-email").value = contatoSelecionado.email;
            document.getElementById("edit-telefone").value = contatoSelecionado.telefone;
            document.getElementById("edit-cidade").value = contatoSelecionado.cidade;
            document.getElementById("edit-estado").value = contatoSelecionado.estado;
            document.getElementById("edit-descricao").value = contatoSelecionado.descricao;
        }

        // Função para fechar o modal
        editSpan.onclick = function() {
            editModal.style.display = "none";
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
