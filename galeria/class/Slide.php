<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Slide {

    public $bd;
    public $slide_id;
    public $slide_foto;
    public $result;
    public $erro = null;
    public $slide_todos = array();
    public $slide_link;

    public function __construct() {
        if (file_exists('../database/Connect.php')) {
            require_once '../database/Connect.php';
        } elseif (file_exists('database/Connect.php')) {
            require_once 'database/Connect.php';
        }
        $this->bd = new Conexao();
        $this->bd->conecta();
    }

    public function setId($slide_id) {
        $this->slide_id = $slide_id;
    }

    public function getId() {
        return $this->slide_id;
    }

    public function setFoto($slide_foto) {
        $this->slide_foto = $slide_foto;
    }

    public function getFoto() {
        return $this->slide_foto;
    }

    public function getSlid() {
        $sql = "SELECT * FROM slide WHERE slide_id = $this->slide_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($retorna = mysql_fetch_object($this->result)) {
                $this->setId($retorna->slide_id);
            }
        }
    }

    public function getSlids() {
        $sql = "SELECT * FROM slide";
        $this->bd->query("$sql")->fetchAll();
        $this->slide_todos = $this->bd->data;
    }

    //função pra trazer todas imagens
    public function getImagens() {
        $sql = "SELECT * FROM slide order by slide_id desc";
        $this->bd->query("$sql")->fetchAll();
        $this->slide_todos = $this->bd->data;
    }

    public function remover() {
        $sql = "DELETE FROM slide WHERE slide_id = $this->slide_id";
        $this->result = mysql_query($sql);
    }

    public function incluir() {
        $sql = "INSERT INTO slide (slide_foto, slide_link) VALUES ";
        $sql .= "('$this->slide_foto','$this->slide_link')";
        $this->result = mysql_query($sql) or die(mysql_error());
    }

    public function atualizar() {
        $sql = "UPDATE slide SET ";
        if ($this->slide_foto != "") {
            $sql .= "slide_foto = '$this->slide_foto' ";
        }
	$sql .= "slide_link = '$this->slide_link' ";
        $sql .= "WHERE slide_id = $this->slide_id";
        $this->result = mysql_query($sql);
    }

    public function upload() {
        require_once '../class/Upload.class.php';
        $this->slide_foto = "";
        $dir_dest = '../fotos/slide';
        $file = $_FILES['slide_foto'];

        $handle = new Upload($file);
        if ($handle->uploaded) {
            $handle->file_overwrite = true;
            //$handle->image_convert = 'png';
            //Configuracoes de redimensionamento paisagem
            $plMax = 1300; //largura maxima permitida
            $paMax = 450; // altura maxima permitida
            if ($handle->image_src_x > $plMax || $handle->image_src_y > $paMax) {
                //$handle->image_ratio_x = true;
                $handle->image_resize = true;
                $handle->image_x = 1000;
                $handle->image_y = 380;
            }

            $handle->file_new_name_body = md5(uniqid($file['name']));
            $handle->Process($dir_dest);
            if ($handle->processed) {
                $this->slide_foto = $handle->file_dst_name;
            }
        }
    }

    public function paginaErro() {
        
    }

    public function removerFoto() {
        $sql = "SELECT * FROM slide WHERE slide_id = $this->slide_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($linha = mysql_fetch_object($this->result)) {
                $this->slide_foto = $linha->slide_foto;
            }
        }
        if (file_exists("../fotos/slide/$this->slide_foto")) {
            @unlink("../fotos/slide/$this->slide_foto");
        }
    }

}
