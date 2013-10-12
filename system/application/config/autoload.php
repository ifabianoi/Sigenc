<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| Este arquivo especifica quais sistemas devem ser carregados por padr�o.
|
| A fim de manter a estrutura leve quanto poss�vel, apenas os recursos
| absolutos s�o carregados por padr�o.
| O banco de dados n�o est� conectado automaticamente uma vez que nenhuma 
| suposi��o � feita a respeito de se voc� pretende us�-lo.  Esse arquivo 
| permite que voc� defina quais sistemas voc� gostaria de carregar com cada
| solicita��o.
|
| -------------------------------------------------------------------
| Instru��es
| -------------------------------------------------------------------
|
| Estas s�o as coisas que voc� pode carregar automaticamente:
|
| 1. Bibliotecas
| 2. Arquivos de Ajuda
| 3. Plugins
| 4. Arquivos de Configa��o
| 5. Arquivos de Linguagem
| 6. Modelos
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Bibliotecas
| -------------------------------------------------------------------
| Estas s�o as classes localizado no sistema de pasta / bibliotecas
| ou no sistema/pasta/aplica��es/bibliotecas.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'session', 'xmlrpc');
*/

$autoload['libraries'] = array('database','session','email');


/*
| -------------------------------------------------------------------
|  Auto-load Arquivos de Ajuda
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array('url','form','text','date','security','autenticate','dateutils','browser_detection');


/*
| -------------------------------------------------------------------
|  Auto-load Plugins
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['plugin'] = array('captcha', 'js_calendar');
*/

$autoload['plugin'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Arquivos de Configura��es
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTA: Este item deve ser utilizado somente se tiver criado os 
| arquivos de configura��o personalizados. Caso contr�rio, deixar em branco.
|
*/

$autoload['config'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Arquivos de Linguagem
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTA: N�o inclua o "_lang" na parte de seu arquivo. por exemplo
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Modelos
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('model1', 'model2');
|
*/

$autoload['model'] = array('MCategoria','MCusto','MUsuario', 'MParcelas', 'MEntrada', 'MContato');



/* Fim do arquivo autoload.php */
/* Localiza��o: ./system/application/config/autoload.php */