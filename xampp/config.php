<?php

/** RUTAS GENERALES **/
define('PROJECT_STATUS', 'test');
if(PROJECT_STATUS == "test")
{
	define('DOC_ROOT', '/opt/lampp/htdocs');
	define('WEB_ROOT', 'http://localhost');

	define('SQL_HOST', '127.0.0.1');
	define('SQL_DATABASE', 'huerin');
	define('SQL_USER', 'root');
	define('SQL_PASSWORD', '');
}
else
{
//echo $_SERVER['DOCUMENT_ROOT'];
	define('DOC_ROOT', '/home/avantikads/domains/avantikads.com/public_html/despacho');
	define('WEB_ROOT', 'http://avantikads.com/despacho');
	
	define('SQL_HOST', 'localhost');
	define('SQL_DATABASE', 'avantikads_demoEventos');
	define('SQL_USER', 'avantikads');
	define('SQL_PASSWORD', 'admonavanti');
}
echo "jere";

/** BASE DE DATOS **/
define("USER_PAC", "STI070725SAA");
define("PW_PAC", "oobrotcfl");

/** SMTP **/
define('SMTP_HOST','');
define('SMTP_PORT','');
define('SMTP_USER','');
define('SMTP_PASS','');

/** PAGINACION **/
define('ITEMS_PER_PAGE', '20');

//instancias
define("SERVICIOS_NOMINA", "5, 6, 7");

?>
