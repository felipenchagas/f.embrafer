<?php
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Albumcat.php';
$id = intval($_GET['id']);
$edit = new Albumcat();
$edit->setId($id);
$edit->getAlbumcat();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once 'header.php'; ?>   
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
        <div class="nav navbar-inverse">
            <?php require_once 'menu.php'; ?>       
        </div>
        <br /> 
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">Editar Album</h2>
                </div>
                <div class="panel-body text-muted">
                    <div class="col-md-8">
                        <form  method="post" enctype="multipart/form-data" action="albumcat_fn.php?acao=atualizar">
                            <div class="form-horizontal well well-sm">
                                <label for="albumcat_nome">Categoria</label>
                                <input type="text" class="form-control" id="albumcat_nome"  name="albumcat_nome"  placeholder="Informe a categoria" value="<?= $edit->albumcat_nome ?>">
                                <input type="hidden" id="albumcat_id" name="albumcat_id" value="<?= $edit->albumcat_id ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
        <script src="../js/main.js"></script>
        <script>$('#categoria').addClass('active');</script>
    </body>
</html>
</body>
</html>

