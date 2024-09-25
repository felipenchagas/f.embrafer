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

// Processa a adição de contatos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = htmlspecialchars(trim($_POST['nome']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars(trim($_POST['telefone']), ENT_QUOTES, 'UTF-8');
    $cidade = htmlspecialchars(trim($_POST['cidade']), ENT_QUOTES, 'UTF-8');
    $estado = htmlspecialchars(trim($_POST['estado']), ENT_QUOTES, 'UTF-8');
    $descricao = htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO orcamentos (nome, email, telefone, cidade, estado, descricao, data_envio) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $nome, $email, $telefone, $cidade, $estado, $descricao);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        exit();
    } else {
        die("Erro ao preparar a consulta de inserção: " . $conexao->error);
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

    // Atualiza o contato no banco de dados
    $sql = "UPDATE orcamentos SET nome=?, email=?, telefone=?, cidade=?, estado=?, descricao=? WHERE id=?";
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssssi", $nome, $email, $telefone, $cidade, $estado, $descricao, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        exit();
    } else {
        die("Erro ao preparar a consulta de edição: " . $conexao->error);
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <h1>Lista de Contatos</h1>
            <div class="top-bar-buttons">
                <button id="add-contact-btn">Adicionar Contato</button>
                <a href="logout.php" class="logout-btn">Sair</a>
                <div class="search-container">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="&nbsp &nbsp &nbsp Pesquisar...">
                </div>
            </div>
        </div>

        <?php if (!empty($contatos)): ?>
        <div class="table-container">
            <table id="contactsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Nome</th>
                        <th onclick="sortTable(1)">E-mail</th>
                        <th onclick="sortTable(2)">Telefone</th>
                        <th onclick="sortTable(3)">Cidade</th>
                        <th onclick="sortTable(4)">Estado</th>
                        <th onclick="sortTable(5)">Descrição do Orçamento</th>
                        <th onclick="sortTable(6)">Data de Envio</th>
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
                        <td><?php echo date("d/m/Y H:i", strtotime($contato['data_envio'])); ?></td>
                        <td>
                            <a href="?delete=<?php echo $contato['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este contato?');">
                                <i class="fas fa-trash-alt"></i>&nbsp &nbsp Del
                            </a>
                            <a href="#" class="edit-btn" onclick="openEditModal(<?php echo $contato['id']; ?>)">
                                <i class="fas fa-edit"></i>&nbsp &nbsp Editar
                            </a>
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

    <!-- Modal de adicionar contato -->
    <div id="add-contact-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Adicionar Novo Contato</h2>
            <form action="index.php" method="post" class="add-contact-form">
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
                        <textarea id="descricao" name="descricao" required></textarea>
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
        // Script para abrir e fechar o modal de adicionar contato
        var addModal = document.getElementById("add-contact-modal");
        var addBtn = document.getElementById("add-contact-btn");
        var addSpan = addModal.getElementsByClassName("close-btn")[0];

        addBtn.onclick = function() {
            addModal.style.display = "block";
        }

        addSpan.onclick = function() {
            addModal.style.display = "none";
        }

        // Script para abrir e fechar o modal de editar contato
        var editModal = document.getElementById("edit-contact-modal");
        var editSpan = editModal.getElementsByClassName("close-btn")[0];

        function openEditModal(id) {
            editModal.style.display = "block";

            var contato = <?php echo json_encode($contatos); ?>;
            var contatoSelecionado = contato.find(c => c.id == id);

            if (contatoSelecionado) {
                document.getElementById("edit-id").value = contatoSelecionado.id;
                document.getElementById("edit-nome").value = contatoSelecionado.nome;
                document.getElementById("edit-email").value = contatoSelecionado.email;
                document.getElementById("edit-telefone").value = contatoSelecionado.telefone;
                document.getElementById("edit-cidade").value = contatoSelecionado.cidade;
                document.getElementById("edit-estado").value = contatoSelecionado.estado;
                document.getElementById("edit-descricao").value = contatoSelecionado.descricao;
            } else {
                alert("Contato não encontrado.");
                editModal.style.display = "none";
            }
        }

        editSpan.onclick = function() {
            editModal.style.display = "none";
        }

        // Fecha os modais ao clicar fora deles
        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }

        // Função para ordenar as colunas
        let sortOrder = {};
        function sortTable(n) {
            let table = document.getElementById("contactsTable");
            let rows = Array.from(table.rows).slice(1);
            let isAscending = !sortOrder[n];

            rows.sort((row1, row2) => {
                let cell1 = row1.cells[n].innerText.toLowerCase();
                let cell2 = row2.cells[n].innerText.toLowerCase();

                // Verificação se a coluna é Data
                if (n === 6) {
                    // Converter para timestamp para comparação
                    cell1 = new Date(cell1.split('/').reverse().join('-') + ' ' + row1.cells[6].innerText.split(' ')[1]).getTime();
                    cell2 = new Date(cell2.split('/').reverse().join('-') + ' ' + row2.cells[6].innerText.split(' ')[1]).getTime();
                }

                if (cell1 < cell2) return isAscending ? -1 : 1;
                if (cell1 > cell2) return isAscending ? 1 : -1;
                return 0;
            });

            rows.forEach(row => table.appendChild(row));
            sortOrder[n] = isAscending;
        }

        // Função para pesquisar na tabela
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>
