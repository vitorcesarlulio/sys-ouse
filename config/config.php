<?php

/**
 * Arquivos diretórios raízes
 */
$PastaInterna = ""; //Caso o sistema fique dentro de uma pasta, voce deve colocar o nome da pasta entre as aspats duplas. Exemplo: http://localhost/sys-ouse/ ($PastaInterna = "sys-ouse";)
define('DIRPAGE', "http://{$_SERVER['HTTP_HOST']}/{$PastaInterna}"); //CAMINHO DO SISTEMA NO LOCAL HOST (HTTP) URL. Exemplo: http://localhost/

//
/**
 * CAMINHO FISICO (C:...)
 * SE A ULTIMA LETRA DO SERVER FOR IGUAL A UMA BARRA
 */
if (substr($_SERVER['DOCUMENT_ROOT'], -1) == '/') {
    define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}{$PastaInterna}"); //NO LOCALHOST JA VEM COM A BARRA NO FINAL, MAS NA MAIORIA DOS SERVIDORES NAO
} else {
    define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}/{$PastaInterna}"); //ADICCIONANDO A BARRA NO FINAL CASO NAO TENHA A BARRA NO FINAL
}

/**
 * Diretórios Específicos
 */
define('DIRIMG',     "img/");
define('DIRCSS',     "css/");
define('DIRPLUGINS', "plugins/");
define('DIRJS',      "js/");

/**
 * Acesso ao banco de dados
 */
define('HOST', "localhost");
define('DB', "");
define('USER', "root");
define('PASS', "");

