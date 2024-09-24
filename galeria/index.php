<?php
/*
 * @App     Dream Gallery 2.0
 * @Author  Rafael Clares <falecom@phpstaff.com.br> 
 * @Web     www.phpstaff.com.br
 */
require_once './class/Foto.php';
require_once 'class/Album.php';
$album = new Album ();
?>

<!DOCTYPE HTML>

<html>

<head>
<title>Galeria Embrafer</title>
         <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.0/paper/bootstrap.min.css" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="plugins/stack/css/component.css" rel="stylesheet" type="text/css">
        <link href="css/main.css" rel="stylesheet" type="text/css">	







<!--Custom Css-->

<link href="../css/custom.css" rel="stylesheet" type="text/css" />

<!--Bootstrap Css-->

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />

<!--Bootstrap Responsive Css-->

<link href="../css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />

<!--Color Css-->

<link href="../css/color.css" rel="stylesheet" type="text/css" />

<!--Font Awesome Css-->

<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<!--Fevicon-->

<link rel="icon" href="../images/favicon.ico" type="image/x-icon" />

<!--Google Fonts-->

<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700' rel='stylesheet' type='text/css' />

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<!--Bxslider Css-->

<link href="../css/jquery.bxslider.css" rel="stylesheet" type="text/css" />

<!--Pretty Photo Css-->

<link rel="stylesheet" href="../css/prettyPhoto.css" type="text/css" media="screen"/>

<!--Html 5 Js-->

<script src="../js/html5.js" type="text/javascript"></script>

<!-- Color Css Files Start -->

<link rel="stylesheet" type="text/css" href="../css/color-red.css" title="styles1" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-red.css" title="styles1" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-skyblue.css" title="styles2" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-orange.css" title="styles3" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-green.css" title="styles4" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-blue.css" title="styles5" media="screen" />

<link rel="alternate stylesheet" type="text/css" href="../css/color-brown.css" title="styles6" media="screen" />

<!-- Color Css Files End -->



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



<!--Wrapper Start-->

<div id="wrapper"> 

  <!--Headre Start-->

  <header id="header"> 

    <!--Head Topbar Start-->

    <div class="head-topbar">

      <div class="container">

        <div class="row-fluid">

          <div class="left">

            <ul>

              <li><a href="../estrutura-metalica.html">Estrutura Metálica</a></li>

              <li><a href="../contato-embrafer.html">Entre em Contato</a></li>

              <li><strong class="number">(41) 3082-8850</strong></li>

            </ul>

          </div>

          <ul class="header-social">

            <li><a href="https://www.facebook.com/metalicapr"><i class="fa fa-facebook-square"></i></a></li>

            <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>

            <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>

            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>

            <li><a href="#"><i class="fa fa-tumblr-square"></i></a></li>

            <li><a href="#"><i class="fa fa-instagram"></i></a></li>

            <li><a href="#"><i class="fa fa-flickr"></i></a></li>

          </ul>

        </div>

      </div>

    </div>

    <!--Head Topbar End--> 

    <!--Menu Row Start-->

   <div class="menu-row">

      <div class="container">

        <div class="row-fluid"> <strong class="logo"><a href="https://www.embrafer.com"><img src="../images/logo.png" alt="img"></a></strong> </div>

      </div>

      <!--Navigation Area	Start-->

      <section class="navigation-area">

        <div class="container">

          <div class="row-fluid"> <a href="../contato-embrafer.html" class="btn-donate"><i></i>Orçamento</a> 

            <!--Navbar Start-->

            <div class="navbar margin-none">         



			  <!-- DELETAR -->

			<div class="container">

                <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

                <div class="nav-collapse collapse">

                  <div id="navbar">

                    <ul id="nav">

                      <li class="active"><a href="https://www.embrafer.com">Inicio</a></li>

                      <li><a href="../empresa-embrafer-estruturas-metalicas.html">Empresa</a></li>

                      <li><a href="#">Serviços</a>

                        <ul>

                          <li><a href="../estrutura-metalica.html">Estrutura Metálica</a></li>

                          

                          <li><a href="../mezaninos-metalicos.html">Mezaninos</a></li>

                          <li><a href="../galpoes-barracoes-casas-estrutura-metalica.html">Galpões e Barracões</a></li>

                        </ul>

                      </li>

                      <li><a href="../estrutura-metalica.html">Estrutura Metálica</a></li>

                      

                      <li><a href="../obras-empresa-embrafer.html">Galeria de Obras</a></li>

                      <li><a href="../contato-embrafer.html">Contato</a></li>

                    </ul>

                  </div>

                </div>

              </div>

              <a href="#" id="no-active-btn" class="search"><i class="fa fa-search"></i></a>

              <div class="search-box">

                <input name="" type="text" class="top-search-input" placeholder="Search for...">

                <button value="" class="top-search-btn"><i class="fa fa-search"></i></button>

              </div>

            </div>

            <!--Navbar End--> 

          </div>

        </div>

      </section>

      <!--Navigation Area	End--> 

    </div>

    <!--Menu Row End--> 

  </header>

  <!--Headre End-->

  

  <div id="main"> 

    <!--Banner Start-->

    <div id="banner">

      <div id="inner-banner">

        <div class="container">

          <div class="row-fluid">

            <h1>Nossa Galeria de Obras</h1>

            <p>Contrate uma empresa de confiança para fazer este projeto tão importante.</p>

          </div>

        </div>

      </div>

    </div>

    <!--Banner Ent--> 

    

    <!--Welcome Text Box Start-->



    <!--Welcome Text Box End--> 

    

    <!--About Me Section Start-->

    <section class="about-section">

      <div class="container">

        <div class="row-fluid">

          <div class="span3">



          </div>

          <!--About Me Text Box Start-->

          <div class="span12">

            <div class="about-me-text">

              <h2>Galeria de Obras</h2>





        <div class="container">
            <?php
            if (isset($_GET['categoria'])) :
                $cat_id = intval($_GET['categoria']);
                $album->bd->url = "index.php?categoria=$cat_id";
                $album->bd->paginate(12);     //12 é o numero de itens por página              
                $album->getAlbumByCat($cat_id);
            else:
                $album->bd->url = "index.php";
                $album->bd->paginate(12);  //12 é o numero de itens por página                              
                $album->getAlbuns();
            endif;
            if ($album->bd->data >= 1):
                foreach ($album->bd->data as $a):
			if (isset($_GET['fx'])) {
			    if (isset($fx_list[intval($_GET['fx'])])) {
				$a->album_fx = $fx_list[intval($_GET['fx'])];
			    }
			    $a->album_fx = $_GET['fx'];
			}

                    $foto = new Foto();
                    $pg = 4;
                    if ($a->album_fx == 'coverflow' || $a->album_fx == 'sideslide' || $a->album_fx == 'peekaboo') {
                        $pg = 3;
                    }
                    if ($a->album_fx == ''  ){
                        $pg = 1;
                    }
                    $foto->getFotosHome($a->album_id,$pg);
                    if (isset($foto->bd->data[0])) :
                        $tfoto = count($foto->bd->data);
                        ?>
                        <div class="col-md-3 col-xs-12 col-sm-12 album-d">
                            <section>
                                <figure class="stack stack-<?= $a->album_fx ?> <?= ($tfoto >= 2) ? 'for-active' : 'no-active'; ?>" id="<?= $a->album_id ?>">
                                    <?php
                                    foreach ($foto->bd->data as $f):
                                        if (isset($f->foto_url)):
                                            if (!file_exists("fotos/$f->foto_url")):
                                                $f->foto_url = "nopic.jpg";
                                            endif;
                                        else:
                                            $f->foto_url = "nopic.jpg";
                                        endif;
                                        ?>

                                        <img src="thumb.php?w=600&h=500&zc=1&src=fotos/<?= $f->foto_url ?>" 
                                             class=" img-responsive" style="max-height:500px;" />

                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </figure>
                            <h1> <?= $a->album_nome ?></h1>
                        </section>
                    </div>

                    <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="container"><?= $album->bd->link ?></div>
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="plugins/stack/js/classie.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            window.onload = function () {
                setTimeout(function () {
                    $('.for-active').addClass('active');
                }, 900);
                setTimeout(function () {
                    $('.for-active').removeClass('active');
	    	    // comente a linha acima de desejar que o efeito fique fixo ao 
		    // invés de aparece apenas quando passa o mouse
                }, 2000);
            }
            $('.for-active').hover(
                    function () {
                        $(this).addClass('active')
                    },
                    function () {
                        $(this).removeClass('active')
                    }
            );
            $('figure').on('click', function () {
                window.location = 'album.php?id=' + $(this).attr('id');
            });         
            $('.efx').on('click', function () {
                window.location = 'index.php?fx=' + $(this).attr('id') + '#album-set';
            });
        </script>













			  </div>

          </div>

          <!--About Me Text Box End--> 

        </div>

      </div>

    </section>

    <!--About Me Section End--> 

   



    

      <!--RODA PEH-->

    <section id="footer"> 

      <!--Footer Top Start-->

      <div class="footer-top">

        <div class="container">

          <div class="row-fluid">

            <div class="span3">

              <div class="box-1">

                <h4>Sobre</h4>

                <p>Atuamos no mercado de Estrutura Metálica e todo o Brasil. Serviços, fabricação e instalação de Mezaninos, coberturas metálicas, galpões, barracões e edificações.</p>

                <a href="../cidades-estados-atendidas.html" class="btn-readmore">Cidades Atendidas</a> </div>

            </div>

            <div class="span3">

              <div class="box-1">

                <h4>Rapidinhas</h4>

                <ul>

                  <li>

                    <div class="post-area">

                      <div class="frame"><img src="../images/recent-blog-img-1.jpg" alt="img"></div>

                      <div class="text"> <strong class="title">Planejamento em equipe e orientação na obra...</strong> <strong class="mnt"><i class="fa fa-clock-o"></i>Janeiro 15, 2016</strong> </div>

                    </div>

                  </li>

                  <li>

                    <div class="post-area">

                      <div class="frame"><img src="../images/recent-blog-img-2.jpg" alt="img"></div>

                      <div class="text"> <strong class="title">Trabalho em equipe e um bom relacionamento com os colaboradores...</strong> <strong class="mnt"><i class="fa fa-clock-o"></i>Junho 01, 2014</strong> </div>

                    </div>

                  </li>

                  <li>

                    <div class="post-area">

                      <div class="frame"><img src="../images/recent-blog-img-3.jpg" alt="img"></div>

                      <div class="text"> <strong class="title">Reciclagem de todos os funcionários...</strong> <strong class="mnt"><i class="fa fa-clock-o"></i>Junho 06, 2014</strong> </div>

                    </div>

                  </li>

                </ul>

              </div>

            </div>

            <div class="span3">

              <div class="box-1">

                <h4>Galeria</h4>

                <div class="flicker">

                  <ul>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-1.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-2.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-3.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-4.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-5.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-6.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-7.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-8.jpg" alt="img"></a></li>

                    <li><a href="../obras-empresa-embrafer.html"><img src="../images/flicker-img-9.jpg" alt="img"></a></li>

                  </ul>

                </div>

              </div>

            </div>

            <div class="span3">

              <div class="box-1">

                <h4>Entre em Contato</h4>

                <p>Entre em contato conosco, orçamento sem compromisso ou dúvidas da área.</p>

                <form class="get-touch-form">



                  <strong class="title">Não se preocupe, nós cuidamos de tudo!</strong>

                </form>

              </div>

            </div>

          </div>

        </div>

      </div>

      <!--Footer Top End--> 

      <!--Footer Social Start-->

      <div class="footer-social">

        <div class="container">

          <div> <strong class="footer-logo"><a href="https://www.embrafer.com">EMBRAFER</a></strong>

            <div class="footer-social-box">

              <ul>

                <li><a href="https://www.facebook.com/metalicapr"><i class="fa fa-facebook-square"></i></a></li>

                <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>

                <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>

                <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>

                <li><a href="#"><i class="fa fa-tumblr-square"></i></a></li>

                <li><a href="#"><i class="fa fa-instagram"></i></a></li>

                <li><a href="#"><i class="fa fa-flickr"></i></a></li>

              </ul>

            </div>

            <div class="menu">

              <div id="page">

                <div class="header-nav" id="no-bottom-active-btn"> <a href="#menu"></a> <i class="fa fa-bars"></i> </div>

                <ul class="footer-menu" >

                  <li><a href="https://www.embrafer.com">Inicio</a></li>

                  <li><a href="../alambrados-instalacao-fabricacao.html">Alambrados</a></li>

                  <li><a href="../contato-embrafer.html">Contato</a></li>

                </ul>

              </div>

            </div>

          </div>

        </div>

      </div>

      <!--Footer Social End--> 

      <!--Footer Copyright Start-->

      <div class="footer-copyright"><strong class="copy">Todos os direitos reservados &amp; Desenvolvimento próprio: <a href="../http://www.embrafer.com/" class="web" target="_blank">EMBRAFER</a></strong></div>

      <!--Footer Copyright End--> 

    </section>

    <!--Footer End--> 

  </div>

</div>

<!--Wrapper End--> 

<!--Jquery Js--> 

<script src="../js/jquery.js" type="text/javascript"></script> 

<!--Bootstrap Js--> 

<script src="../js/bootstrap.js" type="text/javascript"></script> 

<!--Upcoming News Times Js--> 

<script src="../js/jquery.plugin.js"></script> 

<!--Upcoming News Times Js--> 

<script src="../js/jquery.countdown.js"></script> 

<!--Bxslider Js--> 

<script src="../js/jquery.bxslider.min.js"></script> 

<!--Filterable JS--> 

<script type="text/javascript" src="../js/jquery-filterable.js"></script> 

<!--Flex Timeline JS--> 

<script type="text/javascript" src="../js/jquery.flexisel.js"></script> 

<!--Pretty Photo Js--> 

<script src="../js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script> 

<!-- Style Switcher --> 

<script type="text/javascript" src="../js/styleswitch.js"></script> 

<script type="text/javascript" src="../js/jquery.tabSlideOut.v1.3.js"></script> 

<!--Costom Js--> 

<script src="../js/custom.js" type="text/javascript"></script>

</body>

</html>

