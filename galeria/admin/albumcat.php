<?php
session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    header('Location: login.php');
    exit;
}
require_once '../class/Albumcat.php';
$cat = new Albumcat();
$cat->bd->url = "albumcat.php";
$cat->bd->paginate(12);
$cat->getAlbumcats();
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
                <div class="form-horizontal">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div>
                                <h2 class="panel-title" style="font-family: 'Oswald', sans-serif;">Categorias cadastradas</h2>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data" action="albumcat_fn.php?acao=incluir">
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="has-feedback col-md-6 col-sm-4 col-xs-8">
                                            <input type="text" name="albumcat_nome" id="categoria_nome " class="form-control" 
                                                   placeholder="Informe a categoria" required />
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4">
                                            <button type="submit" class="btn btn-primary" id="btn-add-update"><i class="fa fa-plus-circle"></i> <span>Cadastrar</span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-hover">
                                <tr class="text-muted">
                                    <th width="80">ID</th>
                                    <th>CATEGORIA</th> 
                                    <th width="100"><i class="fa fa-cog"></i> &nbsp;</th>
                                </tr>
                                <?php
                                if ($cat->bd->data >= 1) {
                                    foreach ($cat->bd->data as $c) {
                                        echo "<tr>";
                                        echo "<td style=\"vertical-align: middle\">$c->albumcat_id</td>";
                                        echo "<td style=\"vertical-align: middle\"><input class=\"form-control cat-editar\" type=\"text\" name=\"albumcat_nome\" id=\"$c->albumcat_id\" value=\"$c->albumcat_nome\"/> </td>";
echo "<td style=\"vertical-align: middle\">";
                                        echo "<a class=\"btn btn-danger btn-remove\" title=\"Remover\" data-url=\"albumcat_fn.php?acao=remover&id=$c->albumcat_id\" data-toggle=\"tooltip\" data-placement=\"top\"><i class=\"fa fa-trash\"></i></a> </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            <?php } else { ?>
                                <p class="alert alert-danger">Nenhum registro cadastrado!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!---=============================================BEGIN MODAL=================================================-->
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
                            Você está prestes à excluir um registro de forma permanente.<br />
                            Deseja realmente executar este procedimento?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btn-confirm-remove"><i class="fa fa-check"></i> Remover</button>
                        <input type="hidden" id="albumcat_id" name="albumcat_id" value="<?= $c->albumcat_id ?>">
                    </div>
                </div>
            </div>
        </div>
        <!---=============================================END MODAL=================================================-->
        <div class="container"><?= $cat->bd->link ?></div>  
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
        <script src="../js/main.js"></script>
        <script>
            $('#categoria').addClass('active');
            $('.btn-remove').on('click', function () {
                var url = $(this).attr('data-url');
                $('#ModalRemove').modal('show');
                $('#btn-confirm-remove').on('click', function () {
                    window.location = url;
                });
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

	   $('.cat-editar').on('change',function(){
		var albumcat_id = $(this).attr('id');
		var albumcat_nome = $(this).val();
		var url = 'albumcat_fn.php?acao=atualizar';
		$.post(url,{albumcat_id:albumcat_id,albumcat_nome:albumcat_nome},function(data){
		_alert('Categoria atualizada com sucesso!');
	   });
	   });
        </script>
    </body>
</html>

