<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit();
}

// Caminho para o arquivo de contatos
$arquivo_contatos = '../../contatos.txt';

// Funções para carregar e salvar contatos
function carregarContatos($arquivo) {
    $contatos = array();
    if (file_exists($arquivo)) {
        $conteudo = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($conteudo as $linha) {
            $contatos[] = json_decode($linha, true);
        }
    }
    return $contatos;
}

function salvarContatos($arquivo, $contatos) {
    $conteudo = '';
    foreach ($contatos as $contato) {
        $conteudo .= json_encode($contato) . PHP_EOL;
    }
    file_put_contents($arquivo, $conteudo);
}

// Processa a exclusão de contatos
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    $contatos = carregarContatos($arquivo_contatos);
    if (isset($contatos[$index])) {
        unset($contatos[$index]);
        $contatos = array_values($contatos); // Reindexa o array
        salvarContatos($arquivo_contatos, $contatos);
    }
    header('Location: index.php');
    exit();
}

// Processa a adição de contatos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $novo_contato = array(
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'lista_espera' => $_POST['lista_espera'],
        'data_envio' => date('Y-m-d H:i:s')
    );
    $contatos = carregarContatos($arquivo_contatos);
    $contatos[] = $novo_contato;
    salvarContatos($arquivo_contatos, $contatos);
    header('Location: index.php');
    exit();
}

// Carrega os contatos
$contatos = carregarContatos($arquivo_contatos);
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

<!-- Botão Flutuante -->
<div class="floating-button">
  <button id="openModalBtn">Solicitar Orçamento</button>
</div>

<!-- Modal -->
<div id="contactModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Solicitar Orçamento</h2>
    
    <form action="processa_formulario.php" method="post" id="contact-form">
      <div class="input-group">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
      </div>
      
      <div class="input-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
      </div>
      
      <div class="input-group">
        <label for="telefone">Telefone</label>
        <div class="phone-fields">
          <input type="text" id="ddd" name="ddd" placeholder="DDD" maxlength="2" required>
          <input type="text" id="telefone" name="telefone" placeholder="Número" required>
        </div>
      </div>
      
<div class="form-row">
  <div class="input-group cidade">
    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
  </div>
  <div class="input-group estado">
    <label for="estado">Estado</label>
    <input type="text" id="estado" name="estado" placeholder="Digite" maxlength="2" required>
  </div>
</div>
      
      <div class="input-group">
        <label for="descricao">Descrição do Orçamento</label>
        <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
      </div>
      
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>
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
                        <th>Lista de Espera</th>
                        <th>Data de Envio</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($contatos as $index => $contato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contato['nome']); ?></td>
                        <td><?php echo htmlspecialchars($contato['email']); ?></td>
                        <td><?php echo htmlspecialchars($contato['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($contato['cidade']); ?></td>
                        <td><?php echo htmlspecialchars($contato['estado']); ?></td>
                        <td><?php echo htmlspecialchars($contato['lista_espera']); ?></td>
                        <td><?php echo htmlspecialchars($contato['data_envio']); ?></td>
                        <td><a href="?delete=<?php echo $index; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este contato?');">Deletar</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>Nenhum contato encontrado.</p>
        <?php endif; ?>

        <!-- Modal de adicionar contato (inicialmente oculto) -->
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
                        <div class="input-group">
                            <label>Lista de Espera</label>
                            <div class="radio-group">
                                <label><input type="radio" id="sim" name="lista_espera" value="Sim" required> Sim</label>
                                <label><input type="radio" id="nao" name="lista_espera" value="Não"> Não</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit">Adicionar Contato</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Script para abrir e fechar o modal
        var modal = document.getElementById("add-contact-modal");
        var btn = document.getElementById("add-contact-btn");
        var span = document.getElementsByClassName("close-btn")[0];

        btn.onclick = function() {
            modal.classList.add("show");
        }

        span.onclick = function() {
            modal.classList.remove("show");
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove("show");
            }
        }
    </script>
</body>
</html>
