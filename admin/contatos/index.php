<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit();
}

// Conectar ao banco de dados
$servidor = "localhost"; // Coloque o IP do servidor, se necessário
$usuario = "embra_usuario";
$senha = "uRXA1r9Z7pv~Cw";
$banco = "embra_orcamentos";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Funções para carregar e salvar contatos
function carregarContatos($conexao) {
    $contatos = array();
    $sql = "SELECT * FROM orcamentos";
    $result = $conexao->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contatos[] = $row;
        }
    }
    return $contatos;
}

// Processa a exclusão de contatos
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM orcamentos WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: index.php');
    exit();
}

// Processa a adição de contatos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    // Função para sanitizar os dados de entrada
    function sanitizar($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // Captura e sanitiza os dados do formulário
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $telefone = sanitizar($_POST['telefone']);
    $cidade = sanitizar($_POST['cidade']);
    $estado = sanitizar($_POST['estado']);
    $descricao = sanitizar($_POST['descricao']);

    // Validação básica dos campos obrigatórios
    $erros = array();

    if (empty($nome)) {
        $erros[] = 'O campo Nome é obrigatório.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'E-mail inválido.';
    }

    if (empty($telefone)) {
        $erros[] = 'Telefone inválido.';
    }

    if (empty($cidade)) {
        $erros[] = 'O campo Cidade é obrigatório.';
    }

    if (empty($estado)) {
        $erros[] = 'O campo Estado é obrigatório.';
    }

    if (empty($descricao)) {
        $erros[] = 'O campo Descrição do Orçamento é obrigatório.';
    }

    // Se houver erros, redireciona de volta para o formulário com mensagens de erro
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header('Location: index.php?erro=true');
        exit();
    }

    // Prepara a inserção no banco de dados
    $sql = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $email, $telefone, $cidade, $estado, $descricao);
    $stmt->execute();
    $stmt->close();

    // Redireciona para a página de sucesso
    header('Location: index.php');
    exit();
}

// Processa a edição de contatos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $telefone = sanitizar($_POST['telefone']);
    $cidade = sanitizar($_POST['cidade']);
    $estado = sanitizar($_POST['estado']);
    $descricao = sanitizar($_POST['descricao']);

    // Atualiza o contato no banco de dados
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
    <!-- Link para o CSS -->
    <link rel="stylesheet" href="admin_styles3.css">
    <!-- Fonte Personalizada -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Meta viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <a href="?delete=<?php echo $contato['id']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este contato?');">Deletar</a>
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

        <!-- Modal de adicionar contato -->
        <div id="add-contact-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Adicionar Novo Contato</h2>
                <form action="" method="post" class="add-contact-form">
                    <input type="hidden" name="adicionar" value="1">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>
                        <div class="input-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" required>
                        </div>
                        <div class="input-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="descricao">Descrição do Orçamento</label>
                            <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
                        </div>
                    </div>
                    <button type="submit">Adicionar Contato</button>
                </form>
            </div>
        </div>

        <!-- Modal de edição de contato -->
        <div id="edit-contact-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Editar Contato</h2>
                <form action="" method="post" class="edit-contact-form">
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
    </div>

    <!-- Scripts -->
    <script>
        var addModal = document.getElementById("add-contact-modal");
        var addBtn = document.getElementById("add-contact-btn");
        var addSpan = document.getElementsByClassName("close-btn")[0];

        addBtn.onclick = function() {
            addModal.classList.add("show");
        }

        addSpan.onclick = function() {
            addModal.classList.remove("show");
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.classList.remove("show");
            }
        }

        // Função para abrir o modal de edição com os dados corretos
        function openEditModal(id) {
            var modal = document.getElementById("edit-contact-modal");
            modal.classList.add("show");

            // Carrega os dados do contato no modal de edição
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

        var editSpan = document.getElementsByClassName("close-btn")[1];
        editSpan.onclick = function() {
            var modal = document.getElementById("edit-contact-modal");
            modal.classList.remove("show");
        }

        window.onclick = function(event) {
            var modal = document.getElementById("edit-contact-modal");
            if (event.target == modal) {
                modal.classList.remove("show");
            }
        }
    </script>
</body>
</html>