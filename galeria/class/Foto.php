<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Foto {

    public $bd;
    public $foto_id;
    public $foto_url;
    public $foto_legenda;
    public $foto_album;
    public $result;
    public $erro = null;
    public $foto_todos = array();

    public function __construct() {
        if (file_exists('../database/Connect.php')) {
            require_once '../database/Connect.php';
        } elseif (file_exists('database/Connect.php')) {
            require_once 'database/Connect.php';
        }
        $this->bd = new Conexao();
        $this->bd->conecta();
    }

    public function setId($foto_id) {
        $this->foto_id = $foto_id;
    }

    public function setLegenda($foto_legenda) {
        $this->foto_legenda = $foto_legenda;
    }

    public function getId() {
        return $this->foto_id;
    }

    public function setUrl($foto_url) {
        $this->foto_url = $foto_url;
    }

    public function setAlbum($foto_album) {
        $this->foto_album = $foto_album;
    }

    public function getUrl() {
        return $this->foto_url;
    }

    public function setFotoalbum($foto_album) {
        $this->foto_album = $foto_album;
    }

    public function getFotoalbum() {
        return $this->foto_album;
    }

    public function incluir() {
        $sql = "INSERT INTO foto (foto_url, foto_album) VALUES ";
        $sql .= "('$this->foto_url', '$this->foto_album')";
        $this->result = mysql_query($sql) or die(mysql_error());
        return mysql_insert_id();
    }

    public function getfoto() {
        $sql = "SELECT * FROM foto WHERE foto_id = $this->foto_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($retorna = mysql_fetch_object($this->result)) {
                $this->setId($retorna->foto_id);
                $this->setUrl($retorna->foto_url);
                $this->setCategoria($retorna->foto_album);
            }
        }
    }

    public function getFotos() {
        $sql = "SELECT * FROM foto  left join album on (foto_album = album_id) left join albumcat on (album_albumcat = albumcat_id) where foto_album = $this->foto_album ORDER BY foto_pos ASC ";

        $this->bd->query("$sql")->fetchAll();
        $this->foto_todos = $this->bd->data;
    }


    public function getFotosHome($album_id,$pg) {
        $sql = "SELECT foto_pos, foto_url FROM foto  where foto_album = $album_id ORDER BY foto_pos DESC limit 0,$pg";
        $this->bd->query("$sql")->fetchAll();
       return $this->bd->data;
    }

    public function getFotoCapa($album_id) {
        $sql = "SELECT * FROM foto where foto_album = $album_id ORDER BY foto_pos ASC limit 0,1";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($linha = mysql_fetch_object($this->result)) {
                $this->foto_url = $linha;
            }
            return $this->foto_url;
        }
    }

    public function remover() {
        $sql = "SELECT * FROM foto WHERE foto_id = $this->foto_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($linha = mysql_fetch_object($this->result)) {
                $this->foto_url = $linha->foto_url;
            }
        }
        if (file_exists("../fotos/$this->foto_url")) {
            @unlink("../fotos/$this->foto_url");
        }
        $sql = "DELETE FROM foto WHERE foto_id = $this->foto_id";
        $this->result = mysql_query($sql);
    }

    public function atualizar() {
        $sql = "UPDATE foto SET ";
        if ($this->foto_url != "") {
            $sql .= "foto_url = '$this->foto_url',";
        }
        if ($this->foto_album != "") {
            $sql .= "foto_album  = '$this->foto_album'";
        }
        //if ($this->foto_legenda != "") {
            $sql .= "foto_legenda  = '$this->foto_legenda'";
        //}
        $sql .= " WHERE foto_id = $this->foto_id";
        $this->result = mysql_query($sql);
    }

    public function updatePos() {
        $item = $_POST['item'];
        foreach ($item as $pos => $foto_id) {
            $foto_id = preg_replace('/li\_/', '', $foto_id);
            $this->bd->query("update foto set foto_pos = $pos where foto_id = $foto_id\n");
        }
    }

}
