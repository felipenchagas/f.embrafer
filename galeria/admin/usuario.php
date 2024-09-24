<?php
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Usuario.php';
$usuario = new Usuario();
$usuario->getUsuarios();
$usuario->bd->url = "usuario.php";
$usuario->bd->paginate(12);
$usuario->getUsuarios();
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
                                <h2 class="panel-title" style="font-family: 'Oswald', sans-serif;">Lista de usuários</h2>
                            </div>
                        </div>
                        <div class="panel-body text-muted">
                            <p class="text-right"><a class=" btn btn-primary" href="usuario_novo.php"><i class="fa fa-plus-circle"></i> Novo Usuário</a></p>
                            <table class="table table-striped">
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Login</th>
                                    <th width="140">&nbsp;</th>
                                </tr>
                                <?php
                                if ($usuario->bd->data >= 1) {
                                    foreach ($usuario->usuario_todos as $u) {
                                        echo "<tr>";
                                        echo "<td style=\"vertical-align: middle\">$u->usuario_nome</td>";
                                        echo "<td style=\"vertical-align: middle\">$u->usuario_email</td>";
                                        echo "<td style=\"vertical-align: middle\">$u->usuario_login</td>";
                                        echo "<td>";
                                        echo "<a class=\"btn btn-primary\" href=\"usuario_editar.php?id=$u->usuario_id\"><i class=\"fa fa-edit\"></i></a> ";
                                        echo "<a style=\"vertical-align: middle\"><a class=\"btn btn-danger btn-remove\" data-url=\"usuario_fn.php?acao=remover&id=$u->usuario_id\"><i class=\"fa fa-trash\"></i></a>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </table>     
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--==================================BEGIN MODAL===============================================--->
        <div class="modal fade" id="ModalRemove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="myModalLabel">Remover Registro</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-danger">Atenção!</h4>
                        <p>
                            Você está prestes à excluir um registro de forma permanente o sistema precisa pelo menos de usúario ativo.<br />
                            Posteriormente não será possível logar.
                            Deseja realmente executar este procedimento?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btn-confirm-remove"><i class="fa fa-check"></i> Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--==================================END MODAL===============================================--->
        <div class="container"><?= $usuario->bd->link ?></div>       
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>     
        <script src="../js/main.js"></script>
        <script>
            $('#user').addClass('active');
            $('.btn-remove').on('click', function () {
                var url = $(this).attr('data-url');
                $('#ModalRemove').modal('show');
                $('#btn-confirm-remove').on('click', function () {
                    window.location = url;
                });

            });
        </script>
    </body>
</html>

