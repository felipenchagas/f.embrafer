<?php
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    header('location:login.php');
    exit;
}
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
            <div class="rows">
                <form method="post" action="usuario_fn.php?acao=incluir">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div>
                                <h2 class="panel-title" style="font-family: 'Oswald', sans-serif;">Cadastrar Novo Usuário</h2>
                            </div>
                        </div>
                        <div class="panel-body text-muted">
                            <div class="col-md-8">
                                <div class="form-group well well-sm">
                                    <label for="usuario_nome">Nome</label>
                                    <input type="text" class="form-control" id="usuario_nome"  name="usuario_nome" required="" placeholder="Nome">
                                </div>  
                                <div class="form-group well well-sm"">
                                    <label for="usuario_email">Email</label>
                                    <input type="text" class="form-control" id="usuario_email"  name="usuario_email" required="" placeholder="Email">
                                </div>                    
                                <div class="form-group well well-sm">
                                    <label for="usuario_login">Login</label>
                                    <input type="text" class="form-control" id="usuario_login"  name="usuario_login" required="" placeholder="Login">
                                </div>
                                <div class="form-group well well-sm"">
                                    <label for="usuario_senha">Senha</label>
                                    <input type="password" class="form-control" id="usuario_senha"  name="usuario_senha" required="" placeholder="Senha">
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div> 
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>     
        <script src="../js/main.js"></script>
        <script>$('#user').addClass('active');</script>
    </body>
</html>
