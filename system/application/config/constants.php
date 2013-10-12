<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modo de Arquivos e Pastas
|--------------------------------------------------------------------------
|
| Estes prefs s�o usados quando a verifica��o e modos a definir quando se 
| trabalha com o sistema de arquivos. Os padr�es s�o bem em servidores com 
| seguran�a adequada, mas voc� pode querer (ou mesmo necessidade) para alterar
| os valores em determinados ambientes (O Apache executar um processo separado 
| para cada usu�rio, PHP em CGI com Apache suEXEC, etc.) Octal valores deve ser
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
| Estes modos s�o usados quando se trabalha com fopen()/popen()
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
/* Localiza��o: ./system/application/config/constants.php */