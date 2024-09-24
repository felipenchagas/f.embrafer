<?php

/**
 * Description of conexao
 *
 * @author developer
 */
class Conexao {

    private $con;
    private $host = 'localhost';
    private $user = 'embrafer_admin';
    private $pass = 'embrafer8080';
    private $dbname = 'embrafer_galeria';
    public $query;
    public $data;
    public $result;
    public $rows;
    public $page = 0;
    public $perpage = 10;
    public $current = 1;
    public $url = null;
    public $link = '';
    public $total = '';
    public $pagination = false;

    public function conecta() {
        $this->con = @mysql_connect("$this->host", "$this->user", "$this->pass");
        mysql_select_db($this->dbname);
    }

    public function status() {
        if ($this->con) {
            echo 'conectado';
        } else {
            echo "erro na conexao com o banco [$this->dbname] ";
        }
    }

    public function query($query = '') {
        try {
            if ($query == '') {
                throw new Exception('mysql query: A query deve ser informada como parâmetro do método.');
            } else {
                $this->query = $query;
                if ($this->pagination == true) {
                    $this->result = @mysql_query($this->query);
                    $this->fetchAll();
                    $this->paginateLink();
                    $this->query .= " LIMIT $this->page, $this->perpage";
                    $this->pagination = false;
                }
                $this->result = @mysql_query($this->query);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        return $this;
    }

    public function fetchAll() {
        $this->data = "";
        $this->rows = 0;
        while ($row = @mysql_fetch_object($this->result)) {
            $this->data[] = $row;
        }
        if (isset($this->data[0])) {
            $this->rows = count($this->data);
        }
        return $this->data;
    }

    public function rowCount() {
        return @mysql_affected_rows();
    }

    public function getUrl($perpage) {
        $this->url = $_SERVER['REQUEST_URI'];
        return $this;
    }

    public function paginate($perpage) {
        $this->pagination = true;
        $this->perpage = $perpage;
        return $this;
    }

    public function paginateLink() {
        if ($this->url != null) {
            if (!preg_match('/\?/', $this->url)) {
                $this->url .= "?";
            } else {
                $this->url .= "&";
            }
        } else {
            //$this->url = "?";
        }
        if (isset($_GET['page'])) {
            $this->current = $_GET['page'];
            $this->page = $this->perpage * $_GET['page'] - $this->perpage;
            if ($_GET['page'] == 1) {
                $this->page = 0;
            }
        }
        $this->total = $this->rows;
        if ($this->rows > $this->perpage) {
            $this->link = "<ul class=\"pagination\">";
            $prox = "javascript:;";
            $ant = "javascript:;";
            if ($this->current >= 2) {
                $ant = $this->url . "page=" . ($this->current - 1);
            }
            if ($this->current >= 1 && $this->current < ($this->total / $this->perpage)) {
                $prox = $this->url . "page=" . ($this->current + 1);
            }
            $this->link .= '<li><a href="' . $ant . '">&laquo;</a></li>';
            $from = round($this->total / $this->perpage);
            if ($from == 1) {
                $from++;
            }

            for ($i = 1; $i <= $from; $i++) {
                if ($this->current == $i) {
                    $this->link .= "<li class=\"active\"><a>$i</a></li>\n";
                } else {
                    $this->link .= "<li><a href=\"" . $this->url . "page=$i\">$i</a></li>\n";
                }
            }
            $this->link .= '<li><a href="' . $prox . '">&raquo;</a></li>';
            $this->link .= "</ul>\n";
        }
        return $this;
    }

}


