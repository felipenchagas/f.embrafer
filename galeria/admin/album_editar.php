<?php

/*

 * @App     Dream Gallery 2.0

 * @Author  Rafael Clares <falecom@phpstaff.com.br> 

 * @Web     www.phpstaff.com.br

 */

@session_start();

if ($_SESSION['LOGADO'] == FALSE) {

    @header('location:login.php');

    exit;

}



require_once '../class/Album.php';

if (isset($_GET['id'])) {

    $album_id = $_GET['id'];

    $edit = new Album();

    $edit->setId($album_id);

    $edit->getAlbum();

}

?>

<!DOCTYPE html>

<html>

    <head>

        <?php require_once 'header.php'; ?>   

	<link rel="stylesheet" href="../plugins/summernote/dist/summernote.css">



        <link href="../plugins/dropzone/downloads/css/dropzone.css" rel="stylesheet">

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

            <div class="row">

                <form name="" id="" enctype="multipart/form-data" method="post"

                      action="album_fn.php?acao=atualizar">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h1 class="panel-title">

                                <span class="text-right btn-block">



                                    <button type="submit"  class="btn btn-primary">

                                        <i class="fa fa-refresh"></i>

                                        Atualizar Álbum

                                    </button>

                                </span>

                            </h1>

                        </div>

                        <div class="panel-body text-muted">

                            <?php

                            require_once '../class/Albumcat.php';

                            $cat = new Albumcat();

                            $cat->getAlbumcats();

                            ?>



                            <div class="form-group well well-sm">

                                <p class="text-right hide">

                                    <a  href="albumcat.php"  class="btn btn-default btn-xs">

                                        <i class="fa fa-plus-circle"></i>

                                        Nova Categoria

                                    </a>

                                </p>                                  

                                <label>Categoria do Álbum</label>

                                <select required class="form-control" id="album_albumcat" name="album_albumcat">

                                    <option value="">Selecione a categoria...</option>

                                    <?php

                                    if ($cat->bd->data >= 1) {

                                        foreach ($cat->bd->data as $c) {

                                            ?> 

                                            <option value="<?= $c->albumcat_id ?>"><?= $c->albumcat_nome ?></option>

                                            <?php

                                        }

                                    } else {

                                        ?>

                                        <option value="x">Cadastrar nova categoria...</option> 

                                        <?php

                                    }

                                    ?>

                                </select>                              

                            </div>



                            <div class="form-group well well-sm">

                                <label for="album_nome">Nome do Álbum</label>

                                <input type="text" class="form-control" id="album_nome"  name="album_nome" required="" placeholder="Titulo da foto" value="<?= $edit->album_nome ?>">

                            </div>





                            <div class="form-group well well-sm">

                                <label for="album_nome">Efeito do Álbum</label>

				<select name="album_fx" id="album_fx" class="form-control">

					<option value="">Nenhum</option>

					<option value="randomrot">Random Rot</option>

					<option value="fan">Fan</option>

					<option value="coverflow">Cover Flow</option>

					<option value="queue">Queue</option>

					<option value="spread">Spread</option>

					<option value="fanout">Fan Out</option>

					<option value="sideslide">Slides Slide</option>

					<option value="sidegrid">Side Grid</option>

					<option value="bouncygrid">Bouncy Grid</option>

					<option value="previewgrid">Preview GRid</option>

					<option value="cornergrid">Corner Grid</option>

					<option value="leaflet">Leaf Let</option>

					<option value="vertspread">Vert Spread</option>

					<option value="vertelastic">Vert Elastic</option>

				</select>

                            </div>



                            <div class="form-group well well-sm">

                                <label>Descrição do Álbum</label>

                                <textarea class="summernote" name="album_desc" id="album_desc" 

                                          style="min-height:270px;"><?= stripslashes($edit->album_desc) ?></textarea>

                            </div>

                        <div class="panel-heading">

                            <h1 class="panel-title">

                                <span class="text-right btn-block">

                                    <button type="submit"  class="btn btn-primary">

                                        <i class="fa fa-refresh"></i>

                                        Atualizar Álbum

                                    </button>

                                </span>

                            </h1>

                        </div>

                            <input type="hidden" id="album_id" name="album_id" value="<?= $album_id ?>">

                        </div>

                        <br />



                </form>



                <div class="modal fade" id="modal-drop">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                <h4 class="modal-title">ENVIAR FOTOS</h4>

                            </div>

                            <div class="modal-body">

                                <form id="form-dropzone" class="dropzone" style="margin: 15px !important;border: 1px solid #555;"

                                      action="upload.php?album_id=<?= $album_id ?>" 

                                      enctype="multipart/form-data" method="post">

                                    <div id="msg-drop">

                                        <h1 style="font-size:20px !important" class="text-center"><i class="fa fa-3x fa-cloud-upload"></i>  <br /> Arraste as fotos para cá ou clique aqui para enviar os arquivos</h1>

                                    </div>

                                </form>     

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times-circle"></i> CONCLUIR</button>

                            </div>

                        </div><!-- /.modal-content -->

                    </div><!-- /.modal-dialog -->

                </div><!-- /.modal -->



                <br />

                <div class="container">

                    <form method="post" id="form-remove" action="album_fn.php?acao=removerFoto&album_id=<?= $album_id ?>">

                        <?php

                        require '../class/Foto.php';

                        $album_id = $_GET['id'];

                        $foto = new Foto();

                        $foto->setAlbum("$album_id");

                        $foto->getFotos();

                        ?>

                        <?php $flag = ($foto->bd->data >= 1) ? 'show' : 'hide'; ?>



                        <div id="galeria" class="col-sm-12 col-md-12"

                             style="border:0px solid red;">

                                 <?php

                                 if ($foto->bd->data >= 1) {

                                     foreach ($foto->bd->data as $f) {

                                         ?>

                                    <div class="col-md-2  col-sm-3 col-xs-6" id="li_<?= $f->foto_id ?>">

                                        <input class="hide" type="checkbox" name="fotos[]" value="<?= $f->foto_id ?>" id="check_<?= $f->foto_id ?>"  />

                                        <img src="../thumb.php?w=150&h=100&zc=1&src=fotos/<?= $f->foto_url ?>" class="thumbnail tip click-remove" id="<?= $f->foto_id ?>"

                                             style="cursor: pointer;width: 150px; height: 100px;" title="marcar para remover" >

                                        <input type="text" class="form-control legenda-foto" name="foto_legenda" placeholder="Legenda" style="width: 150px; margin-top: -25px !important; margin-bottom: 20px; "

                                               id="lg_<?= $f->foto_id ?>" value="<?= $f->foto_legenda ?>"/>

                                    </div>

                                    <?php

                                }

                            }

                            ?>

                        </div>



                        <div class="row col-xs-12 div-btn-remove">

                            <p class="text-center">



                                <button type="button"  class="btn btn-info" id="btn-modal-drop">

                                    <i class="fa fa-cloud-upload"></i>

                                    ENVIAR FOTOS

                                </button>



                                <button type="button" class="btn btn-danger btn-sel-tudo <?= $flag ?>">

                                    <i class="fa fa-check-circle-o"></i>

                                    Selecionar Tudo

                                </button>

                                <button type="button" class="btn btn-danger btn-sel-nada hide">

                                    <i class="fa fa-undo"></i>

                                    Desmarcar Tudo

                                </button>

                                <button type="button" class="btn btn-danger" id="btn-submit-remove">

                                    <i class="fa fa-trash-o"></i>

                                    Remover  Selecionadas

                                </button>

                            </p>

                        </div>  

                </div>                                       

                </form> 

            </div>

        </div>

    </div>

</div>

</div>  

<div class="container"><?= $foto->bd->link ?></div>  

<script src="../js/jquery-1.11.1.min.js"></script>

<script src="../js/jquery-ui.js"></script>  

<script src="../js/bootstrap.min.js"></script>   

<!-- BGN summernote plugin -->

<script type="text/javascript" src="../plugins/summernote/dist/summernote.js"></script>

<script type="text/javascript" src="../plugins/summernote/lang/summernote-pt-BR.js"></script>

<script type="text/javascript">

function summerNote() {

    $('.summernote').code('');

    $('.summernote').destroy();

    $('.summernote').summernote({

        toolbar: [

            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],

            ['font', ['fontname']],

            ['fontsize', ['fontsize']],

            ['color', ['color']],

            ['para', ['ul', 'ol', 'paragraph']],

            ['height', ['height']],

            ['insert', ['picture', 'video', 'link', 'table']],

            ['misc', ['undo', 'redo', 'codeview', 'fullscreen']]

        ],

        height: 200,

        lang: 'pt-BR'

    });

}



summerNote();

</script>	

<!-- END summernote plugin-->

<style>

    #sortable { list-style-type: none; margin: 0; padding: 0; width: 450px; }

    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }

</style>

<script>

    $(function () {

        reloadActions();

    });



    function reloadActions() {

        //var sortedIDs = $( ".selector" ).sortable( "toArray" );        

        $("#galeria").sortable({cursor: "move",

            stop: function (event, ui) {

                var ids = $("#galeria").sortable("toArray");

                var url = 'foto_fn.php?acao=posicao';

                $.post(url, {item: ids}, function (data) {

                    _alert('Posição atualizada com sucesso!');

                })

            }

        });

        $("#galeria").disableSelection();

        $('.legenda-foto').on('change', function () {

            var foto_id = $(this).attr('id').replace('lg_', '');

            var foto_legenda = $(this).val();

            var url = 'foto_fn.php?acao=atualizarLegenda';

            $.post(url, {foto_id: foto_id, foto_legenda: foto_legenda}, function (data) {

		_alert('Legenda atualizada com sucesso!');

            })

        });

        $('#btn-modal-drop').on('click', function () {

            $('#modal-drop').modal('show');

        })



    }

</script>

<script src="../js/main.js"></script>

<script type="text/javascript" src="../plugins/dropzone/downloads/dropzone.js"></script>

<script type="text/javascript">

    $('#album_albumcat').on('change', function () {

        if ($('#album_albumcat option:selected').val() === 'x') {

            window.location = 'albumcat.php';

            return false;

        }

    });

    $('#album').addClass('active');

    $('#album_albumcat').val('<?= $edit->album_albumcat ?>');

    $('#album_fx').val('<?= $edit->album_fx ?>');

    $(function () {

        Dropzone.autoDiscover = false;

        $(".dropzone").dropzone({

            url: "upload.php?album_id=<?= $album_id ?>",

            accept: function (file, done) {

                done();

            },

            maxFilesize: 2000, // MB

            complete: function (file) {

                //console.log($('#form-dropzone').html())

                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                    $('.dz-preview').each(function () {

                        $(this).fadeOut(1000);

                    });

                    $('#msg-drop').html('<h1 style="font-size:20px !important" class="text-center"><i class="fa fa-3x fa-thumbs-up"></i>  <br /> Upload Concluído</h1>>');

                    setTimeout(function () {

                        $('#msg-drop').html('<h1 style="font-size:20px !important" class="text-center"><i class="fa fa-3x fa-cloud-upload"></i>  <br /> Arraste as fotos para cá ou clique aqui para enviar os arquivos</h1>');

                        /*

                         $('.click-remove').on('click', function () {

                         var id = $(this).attr('id');

                         $('#check_' + id).trigger('click');

                         $('#' + id).toggleClass('btn-danger');

                         });

                         */

                        $('.div-btn-remove').removeClass('hide').show();



                    }, 2000);

                }



                var f = $.parseJSON(file.xhr.response);

                var div = '';

                div += '    <div class="col-md-2"> ';

                div += '        <input class="hide" type="checkbox" name="fotos[]" value="' + f.foto_id + '" id="check_' + f.foto_id + '"  />';

                div += '        <img src="../thumb.php?w=150&h=100&zc=1&src=fotos/' + f.foto_url + '" class="thumbnail tip click-remove" id="' + f.foto_id + '" ';

                div += '             style="cursor: pointer;width: 150px; height: 100px;" title="marcar para remover" >';

                div += '         <input type="text" class="form-control legenda-foto" name="foto_legenda" placeholder="legenda" style="width: 150px; margin-top: -25px !important; margin-bottom: 20px;"   id="lg_' + f.foto_id + '" />';

                div += '    </div>';

                $('#galeria').append(div);

                reloadActions();



                $('#' + f.foto_id).on('click', function () {

                    var id = f.foto_id

                    $('#check_' + id).trigger('click');

                    $('#' + id).toggleClass('btn-danger');



                    if ($('input:checked').length >= 1) {

                        $('#btn-submit-remove').show();

                    } else {

                        $('#btn-submit-remove').hide();

                    }

                });

            },

            sending: function (file, xhr, formData) {

                formData.append("album_id", "<?= $album_id ?>");

                if (xhr.readyState == 4) {

                    //console.log(xhr.response)

                }

            },

            totaluploadprogress: function () {

            }

        });

    });

    $('#btn-submit-remove').hide();



    $('#btn-submit-remove').on('click', function () {

        if ($('input:checked').length >= 1) {

            $('#form-remove').submit();

        }

    });



    $('.click-remove').on('click', function () {

        var id = $(this).attr('id');

        $('#check_' + id).trigger('click');

        $('#' + id).toggleClass('btn-danger');



        if ($('input:checked').length >= 1) {

            $('#btn-submit-remove').show();

        } else {

            $('#btn-submit-remove').hide();

        }

    });



    $('.btn-sel-tudo').on('click', function () {

        $('.click-remove').each(function () {

            var id = $(this).attr('id');

            $('#' + id).addClass('btn-danger');

            $('#check_' + id).attr('checked', 'checked');

        });

        $('.btn-sel-tudo').hide();

        $('.btn-sel-nada').removeClass('hide').show();



        if ($('input:checked').length >= 1) {

            $('#btn-submit-remove').show();

        } else {

            $('#btn-submit-remove').hide();

        }

        $('#btn-submit-remove').show();

    });



    $('.btn-sel-nada').on('click', function () {

        $('.click-remove').each(function () {

            var id = $(this).attr('id');

            $('#' + id).removeClass('btn-danger');

            $('#check_' + id).removeAttr('checked');

        });

        $('.btn-sel-tudo').show();

        $('.btn-sel-nada').hide();



        if ($('input:checked').length >= 1) {

            $('#btn-submit-remove').show();

        } else {

            $('#btn-submit-remove').hide();

        }

    });

</script> 

</body>

</html>

