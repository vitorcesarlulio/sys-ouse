<?php

namespace Classes;

use Traits\TraitParseUrl;

class ClassDispatch
{

    private $init;
    private $url;
    private $dir = null;
    private $cont;
    private $file;
    private $page;

    use TraitParseUrl;

    public function __construct()
    {
        $this->url = TraitParseUrl::parseUrl();
        $this->cont = count($this->url);
        $this->verificaParametros();
    }

    #Verificar se existem parâmetros digitados pelo usuário
    private function verificaParametros()
    {
        if ($this->cont == 1 && empty($this->url[0])) {
            $this->page = DIRREQ . 'views/index.php'; //se for '/' 
        } else {
            $this->verificaDir();
        }
    }

    #Verificar se o índice digitado pelo usuário é um diretório
    private function verificaDir()
    {
        $this->init = $this->url[0] . '/';

        for ($i = 0; $i < $this->cont; $i++) {
            if (is_dir($this->init)) {
                if ($i == 0) {
                    $this->dir .= $this->init;
                } elseif (is_dir($this->dir . $this->url[$i])) {
                    $this->dir .= $this->url[$i] . '/';
                } else {
                    $this->file = $this->url[$i];
                    break;
                }
            } else {
                if ($i == 0) {
                    $this->dir .= 'views/';
                }

                if (is_dir($this->dir . $this->url[$i])) {
                    $this->dir .= $this->url[$i] . '/';
                } else {
                    $this->file = $this->url[$i];
                    break;
                }
            }
        }

        $this->dir = str_replace("//", "/", $this->dir);
        $this->verificaFile();
    }

    #Verificar se existe o arquivo requisitado, se não existir ele chama o index.php, senão chama a pagina 404.
    private function verificaFile()
    {
        $dirAbs = DIRREQ . $this->dir;
        if (file_exists($dirAbs . $this->file . '.php')) {
            $this->page = $dirAbs . $this->file . '.php';
        } elseif (file_exists($dirAbs . 'index.php')) {
            $this->page = $dirAbs . 'index.php';
        } else {
            $this->page = DIRREQ . 'views/404.php';
        }
    }

    #Retornar a página final para o sistema
    public function getInclusao()
    {
        return $this->page;
    }
}
