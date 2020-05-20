# Sys Ouse

## Pré requisitos

- [PHP](https://www.php.net/) **Versao de desenvimento: 7.4.4** *Obrigatório.*
- [Composer](https://getcomposer.org/) *Obrigatório.*
- [Servidor - Apache](https://httpd.apache.org/) *Obrigatório, porem pode ser outro como [Xammp](https://www.apachefriends.org/pt_br/index.html) (já vem com PHP e Apache embutidos), Wammp (Linux).*
- [MySQL](https://www.mysql.com/) **Versao de desenvimento: ** *Obrigatório.*
- [Git](https://git-scm.com/) *Não Obrigatório.*

### Para rodar localmente o sistema siga os seguintes passos
**No arquivo httpd.conf fazer os seguintes passos:**
- Geralmente localizado em: ```C:\Apache24\conf\httpd.conf```
Remova o ```#``` na linha: ```LoadModule rewrite_module modules/mod_rewrite.so```

**No arquivo httpd-vhosts.conf fazer os seguintes passos:**
- Geralmente localizado em: ```C:\Apache24\conf\extra```

```<VirtualHost *:80>    
    DocumentRoot "caminho-do-sistema" 
    ServerName nome para abrir no navegador
    ErrorLog "logs/sys-ouse-error.log"
    CustomLog "logs/sys-ouse-access.log" common
</VirtualHost>```

Exemplo:
```<VirtualHost *:80>    
    DocumentRoot "C:\Apache24\htdocs\sys-ouse\public" 
    ServerName local.sys-ouse
    ErrorLog "logs/sys-ouse-error.log"
    CustomLog "logs/sys-ouse-access.log" common
</VirtualHost>```

**No arquivo php.ini fazer os seguintes passos:**
- Geralmente localizado em: ```C:\Apache24\conf\httpd.conf```

**Ir ate o host do windows e fazer os seguintes passos:**
- Geralmente localizado em: ```C:\Windows\System32\drivers\etc\host```

Adicione no final do arquivo: ```127.0.0.1       local.sys-ouse```
OBS: o nome deve ser o mesmo colocado na opção ```ServerName``` no arquivo ```httpd-vhosts.conf```.


### Utilizando o Composer
Dentro da pasta src/ voce ira observar um arquivo chamado **composer.json** ele é o responsavel de fazer a ponte entre a aplicação (sistema) e o composer. Composer é um gerenciador de depencias, resumindo, ele que possibilita eu utilizar componentes externos da minha aplicação (desenvolvido por outra pessoa) e tambem é responsavel por atualizar esses componente! 
Irei descrever um pouco sobre algumas linhas do arquivo:
 ```"autoload":``` é onde voce deve especificar onde se encontram suas classes, metodos e etc. Com essa linha do codigo voce pode substituir o ```require``` (geralmente utilizado para chamar uma classe) por require ```require vendor/autoload.php``` e apenas essa linha de codigo ja vai "ler" todas suas classes em que voce apontou no diretorio abaixo.
 ```"files":``` utilizado para possibilitar usar o que tiver dentro do arquivo em que voce especificou (no caso estao as constantes do sistema, como citadas acima).
 ```"require":``` responsavel por requisitar os componente externos.
 
```
 "autoload": {
    "psr-4": {
      "App\\": "../app/",
      "Src\\": "../src/"
    },
    "files": [
      "../config/config.php"
    ]
  },
  "require": {
    "jenssegers/blade": "^1.3",
    "erandir/plug-route": "^3.7"
  }, 
```

#### Componentes externos utilizados
**[Blade](https://github.com/jenssegers/blade):** utilizado para reaproveitar codigos HTML(tambem utilizado no Framework PHP Laravel). Ainda nesse arquivo resumo a utilização do componente Blade.
**[Plug Route](https://github.com/erandirjunior/plug-route):** utilizado para definir as rotas do sistema (URL em que o usuario ira acessar). Ainda nesse arquivo resumo a utilização do componente Plug Route.

#### Exemplo de implementação de um novo componente
abra o caminho da pasta no terminal e rode o seguinte codigo: ```composer require componente-que-deseja-implementar```

#### Atualizar componentes para versoes mais atuais
abra o caminho da pasta no terminal e rode o seguinte codigo: ```composer update```

### Alteraçoes no arquivo composer.json
Sempre que executamos ```compositor dump-autoload ou compositor dump-o```, o Composer relê o arquivo composer.json para criar a lista de arquivos a serem carregados automaticamente.


###Exeplicando alguns arquivos
**public/.htaccess:** arquivo responsavel pela segurança e algumas confuguraçoes do projeto. No arquivo voce pode alterar algumas opçoes de acordo com seu projeto ou modificaçoes nesse projeto:
```DirectoryIndex public/index.php```: essa linha diz que o primiero arquivo em que meu servidor vai procurar esta dentro da pasta ```public``` e é o ```index.php```. 
```RewriteRule ^public\index.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]```: mesmo caminho que voce colocar na opção acima deve colocar onde esta ```^public\index.php``` (Exemplo: caso voce coloque o arquivo  ```index.php``` em uma outra pastas  ```^nova-pasta\index.php```).

**config/config.php:** arquivo onde contem constantes que sao utilizadas em todo o projeto, tais como:
- Diretorio padrao da URL: ```http://localhost/sys-ouse/```
- Cola uma barra no caminho da URL caso nao tenha (no localhost ja vem a barra no final, ja nos servidores pode ser que nao).
- Diretorio padrao fisico do sistema: ```C:\Apache24\htdocs\sys-ouse```
- Constantes passando onde se localiza os Assests (CSS, JS): ```define('DIRJS', "js/")```
- Acesso ao Banco de Dados 

**.gitignore:** onde voce ira especificar os arquivos em que nao deseja subir para o GitHub.


##[Plug Route](https://github.com/erandirjunior/plug-route)
Para utilização do mesmo, siga a documentação do componente.

###Exemplificando o componente [Plug Route](https://github.com/erandirjunior/plug-route)
Primerio voce deve "baixar" o componente rodando o comando: composer require erandir/plug-route

```Basic usage

use \PlugRoute\PlugRoute;
use \PlugRoute\RouteContainer;
use \PlugRoute\Http\RequestCreator;

$route = new PlugRoute(new RouteContainer(), RequestCreator::create());

$route->get('/home', function() {
    echo '</h1>Pagina Inicial</h1>';
});

$route->on();```

Onde esta ```'/'``` é onde voce especifica sua rota e abaixo o que deseja exibir/fazer.


##[Blade](https://github.com/jenssegers/blade)
Para utilização do mesmo, siga a documentação do componente.

###Exemplificando o componente [Blade](https://github.com/jenssegers/blade)
Primerio voce deve "baixar" o componente rodando o comando: composer require jenssegers/blade

```use Jenssegers\Blade\Blade;

$blade = new Blade('pasta/caminho onde ira conter todas suas paginas html', 'pasta/caminho onde ira ser armazenado o cache');

echo $blade->make('nome-do-arquivo')->render(); ```

Exemplo:
```
$blade = new Blade('../app/View/', '../app/View/cache');

$route->get('/cadastro', function() use ($blade) {
    echo $blade->render('cadastro.cadastro');
});```

###Comandos basicos
- ```@extends('templates.default')```: caminho do arquivo onde seja extender codigos padroes.
- ```@yield('title')```: criando uma variavel onde voce ira passar o valor dela em outro arquivo com o seguinte codigo abaixo
- ```@section('title')
		aqui é onde vai seu codigo HTML
		Exemplo: Pagina Inicial
- @endsection```:fim da seção criada para inserir codigo HTML

##Efeitos Javascript/JQuery









