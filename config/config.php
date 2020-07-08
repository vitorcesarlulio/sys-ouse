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
define('DIRIMG',     "../img/");
define('DIRCSS',     "../css/");
define('DIRPLUGINS', "../plugins/");
define('DIRJS',      "../js/");

/**
 * Acesso ao banco de dados
 */
define('HOST', "127.0.0.1");
define('DATABASE', "database_sys_ouse");
define('USER', "root");
define('PASSWORD', "");

/*outra dica que eu dou é você usar o $_SERVER['HTTP_HOST'] caso o arquivo fique numa public igual o laravel ele não precisa entrar na pasta só no host direto.

function asset($value) {
       return $_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR.$value;
}
ai quando quiser usar uma imagem, css e js só chama asset('css/style.css'); 
asset('js/script.js');
asset('img/image.png');
*/

