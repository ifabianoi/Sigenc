<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| CONFIGURA��ES DA CONEX�O COM O BANCO DE DADOS
| -------------------------------------------------------------------
| Este arquivo ir� conter as configura��es necess�rias para acessar o banco de dados.
| -------------------------------------------------------------------
| EXPLICA��O DE VARI�VEIS
| -------------------------------------------------------------------
|
|	['hostname'] O nome do servidor de banco de dados.
|	['username'] O nome de usu�rio usado para conectar ao banco de dados
|	['password'] A senha usada para conectar ao banco de dados
|	['database'] O nome do banco de dados que vamos conectar
|	['dbdriver'] O tipo de banco de daods. ie: mysql.  Atualmente suportados:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] Podemos adicionar prefixos, que ser� adicionado
|				 para o nome da tabela ao usar a classe Active Record
|	['pconnect'] TRUE/FALSE - Se usar uma conex�o persistente
|	['db_debug'] TRUE/FALSE - Se os erros de banco de dados deve ser exibido.
|	['cache_on'] TRUE/FALSE - Ativa / desativa o cache de consulta
|	['cachedir'] O caminho para a pasta onde os arquivos de cache deve ser armazenado
|	['char_set'] O conjunto de caracteres usado na comunica��o com o banco de dados
|	['dbcollat'] O agrupamento de caracteres usado na comunica��o com o banco de dados
|
| A variavel $active_group permite que voc� escolha qual o grupo de conex�o para
| tornar ativo. Por padr�o h� apenas um grupo (o grupo "default").
|
| A variavel $active_record permite determinar se deve ou n�o carregar
| a classe Active Record
*/

$active_group = "default";
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "root";
$db['default']['database'] = "projetofinal";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/* Fim do arquivo database.php */
/* Localiza��o: ./system/application/config/database.php */