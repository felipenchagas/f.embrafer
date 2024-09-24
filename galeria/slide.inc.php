<?php
/*
 * @App     Dream Gallery 2.0
 * @Author  Rafael Clares <falecom@phpstaff.com.br> 
 * @Web     www.phpstaff.com.br
 */
require_once './class/Slide.php';
$slide = new Slide();
$slide->bd->paginate(6); //6 é o numero de itens por página
$slide->getImagens();
$y = 0;$k = 0;
if (isset($slide->bd->data[0])):
?>
        <style>
            .carousel-inner img{
                margin: 0 !important;
                padding: 0  !important;
            }
            .carousel-control.left{
                background: none !important;
                color:#000000 !important;
                margin-top: 15% !important;
                left: -10px !important;
            }
            .carousel-control.right{
                background: none !important;
                color:#000000 !important;
                margin-top: 15% !important;
                right: -10px !important;
            }      
	  .carousel-control > span{font-size:68px !important;color:#fff}
	  .slide-bg{background: #dcdcdc; padding-top:30px; padding-bottom:20px;margin-top:-30px}
        </style>
        <div class="slide-bg">
        <div class="container">
                <div id="carousel-slide" class="carousel slide " data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($slide->bd->data as $img): ?>
        <li data-target="#carousel" <?= ($y == 0) ? 'class="active"' : ''; ?> data-slide-to="<?=$y?>" ></li>
	<?php $y++; ?>
        <?php endforeach; ?>
    </ol> 
                    <div class="carousel-inner min-slide">
                        <?php foreach ($slide->bd->data as $img): ?>
                            <div class="item <?= ($k == 0) ? 'active' : ''; ?>">
				<?php if($img->slide_link != ""):  ?>
				<a href="<?= $img->slide_link ?>">
				<?php endif;?>	
                                <img  src="fotos/slide/<?= $img->slide_foto ?>"  class="img-responsive" />
				<?php if($img->slide_link != ""):  ?>
				</a>
				<?php endif;?>	
                            </div>
		        <?php $k++; ?>
                        <?php endforeach; ?>
                    </div>                   
                    <a class="left carousel-control" href="#carousel-slide" role="button" data-slide="prev">
                        <span class="fa fa-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-slide" role="button" data-slide="next">
                        <span class="fa fa-chevron-right"></span>
                    </a>
                </div>
        </div>
	</div>
        <script>$('#slide').addClass('custom-active');</script>
<?php endif; ?>
