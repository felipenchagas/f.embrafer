<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Contatos</title>
    <!-- Link para o CSS -->
    <link rel="stylesheet" href="admin_styles2.css">
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
                        <td>
                            <?php echo htmlspecialchars($contato['telefone']); ?>
                            <!-- Ícone do WhatsApp clicável -->
                            <a href="https://api.whatsapp.com/send/?phone=55<?php echo preg_replace('/[^0-9]/', '', $contato['telefone']); ?>" target="_blank">
                                <img src="wts.svg" alt="WhatsApp" class="whatsapp-icon">
                            </a>
                        </td>
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
