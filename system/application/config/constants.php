<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modo de Arquivos e Pastas
|--------------------------------------------------------------------------
|
| Estes prefs sуo usados quando a verificaчуo e modos a definir quando se 
| trabalha com o sistema de arquivos. Os padrѕes sуo bem em servidores com 
| seguranчa adequada, mas vocъ pode querer (ou mesmo necessidade) para alterar
| os valores em determinados ambientes (O Apache executar um processo separado 
| para cada usuсrio, PHP em CGI com Apache suEXEC, etc.) Octal valores deve ser
| sempre utilizado para definir o modo corretamente.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| Modos de fluxo de arquivo
|--------------------------------------------------------------------------
|
| Estes modos sуo usados quando se trabalha com fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // trunca o arquivo de dados existentes
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // trunca o arquivo de dados existentes
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* Fim do arquivo constants.php */
/* Localizaчуo: ./system/application/config/constants.php */