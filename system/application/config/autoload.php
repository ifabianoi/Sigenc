<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| Este arquivo especifica quais sistemas devem ser carregados por padrуo.
|
| A fim de manter a estrutura leve quanto possэvel, apenas os recursos
| absolutos sуo carregados por padrуo.
| O banco de dados nуo estс conectado automaticamente uma vez que nenhuma 
| suposiчуo щ feita a respeito de se vocъ pretende usс-lo.  Esse arquivo 
| permite que vocъ defina quais sistemas vocъ gostaria de carregar com cada
| solicitaчуo.
|
| -------------------------------------------------------------------
| Instruчѕes
| -------------------------------------------------------------------
|
| Estas sуo as coisas que vocъ pode carregar automaticamente:
|
| 1. Bibliotecas
| 2. Arquivos de Ajuda
| 3. Plugins
| 4. Arquivos de Configaчуo
| 5. Arquivos de Linguagem
| 6. Modelos
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Bibliotecas
| -------------------------------------------------------------------
| Estas sуo as classes localizado no sistema de pasta / bibliotecas
| ou no sistema/pasta/aplicaчѕes/bibliotecas.
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
|  Auto-load Arquivos de Configuraчѕes
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTA: Este item deve ser utilizado somente se tiver criado os 
| arquivos de configuraчуo personalizados. Caso contrсrio, deixar em branco.
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
| NOTA: Nуo inclua o "_lang" na parte de seu arquivo. por exemplo
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
/* Localizaчуo: ./system/application/config/autoload.php */