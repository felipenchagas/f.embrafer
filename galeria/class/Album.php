<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Album {

    public $bd;
    public $album_id;
    public $album_nome;
    public $album_desc;
    public $album_albumcat;
    public $result;
    public $erro = null;
    public $album_todos = array();

    public function __construct() {
        if (file_exists('../database/Connect.php')) {
            require_once '../database/Connect.php';
        } elseif (file_exists('database/Connect.php')) {
            require_once 'database/Connect.php';
        }
        $this->bd = new Conexao();
        $this->bd->conecta();
    }

    public function setId($album_id) {
        $this->album_id = $album_id;
    }

    public function getId() {
        return $this->album_id;
    }

    public function setNome($album_nome) {
        $this->album_nome = addslashes($album_nome);
    }

    public function getNome() {
        return stripslashes($this->album_nome);
    }

    public function setDesc($album_desc) {
        $this->album_desc = addslashes($album_desc);
    }
    public function setFX($album_fx) {
        $this->album_fx = addslashes($album_fx);
    }

    public function setCategoria($album_albumcat) {
        $this->album_albumcat = $album_albumcat;
    }
    public function getFX() {
        return $this->album_fx;
    }
    public function getCategoria() {
        return $this->album_albumcat;
    }

    public function setAlbumnome($albumcat_nome) {
        $this->albumcat_nome = $albumcat_nome;
    }

    public function getAlbumnome() {
        return $this->albumcat_nome;
    }

    public function setFoto($album_foto) {
        $this->album_foto = $album_foto;
    }

    public function getFoto() {
        return $this->album_foto;
    }

    public function incluir() {
        $sql = "INSERT INTO album (album_nome, album_albumcat,album_fx) VALUES ";
        $sql .= "('$this->album_nome', '$this->album_albumcat','$this->album_fx')";
        $this->result = mysql_query($sql) or die(mysql_error());
    }

    public function getAlbum() {
        $sql = "SELECT * FROM album WHERE album_id = $this->album_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($retorna = mysql_fetch_object($this->result)) {
                $this->setId($retorna->album_id);
                $this->setNome($retorna->album_nome);
                $this->setCategoria($retorna->album_albumcat);
                $this->setDesc($retorna->album_desc);
                $this->setFX($retorna->album_fx);
            }
        }
    }

    public function getAlbuns() {
        $sql = "SELECT * FROM album inner Join foto on (foto_album = album_id) group by album_id ORDER BY album_id DESC";
        $this->bd->query("$sql")->fetchAll();
        $this->album_todos = $this->bd->data;
    }

    public function getAlbumByAlbumcat() {
        $sql = "SELECT * FROM albumcat INNER JOIN album ON (album_albumcat = albumcat_id)  ORDER BY album_id DESC";
        $this->bd->query("$sql")->fetchAll();
        $this->album_todos = $this->bd->data;
    }

    public function getAlbumByCat($cat_id) {
        $sql = "SELECT * FROM albumcat INNER JOIN album ON (album_albumcat = albumcat_id) "
                . "WHERE albumcat_id = $cat_id  ORDER BY album_id DESC ";
        $this->bd->query("$sql")->fetchAll();
        $this->album_todos = $this->bd->data;
    }

    public function remover() {
        $sql = "SELECT * FROM foto WHERE foto_album = $this->album_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($linha = mysql_fetch_object($this->result)) {
                if (file_exists("../uploads/$linha->foto_url")) {
                    @unlink("../uploads/$linha->foto_url");
                }
            }
        }
        $sql = "DELETE FROM album WHERE album_id = $this->album_id";
        $this->result = mysql_query($sql);
    }

    public function atualizar() {
        $sql = "UPDATE album SET ";
        $sql .= "album_nome = '$this->album_nome', ";
        $sql .= "album_albumcat  = '$this->album_albumcat', ";
        $sql .= "album_fx  = '$this->album_fx', ";
        $sql .= "album_desc  = '$this->album_desc' ";
        $sql .= "WHERE album_id = $this->album_id";
        $this->result = mysql_query($sql);
    }

}
