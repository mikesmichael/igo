<?php

session_save_path('/tmp/');
$baseDir = __DIR__ . '/../';
$baseNavigateurDir = $baseDir . 'interfaces/navigateur/';
$baseEditionDir = $baseDir . 'edition/';
$baseServicesDir = $baseDir . 'services/';
$baseXmlDir = __DIR__ . '/../xml/';

//require_once($_SERVER['DOCUMENT_ROOT'] . '/commun/autoload.php');
if(!defined("FADQ_CONFIG_SERVICE_PATH_COMMUN")){
    define("FADQ_CONFIG_SERVICE_PATH_COMMUN", $_SERVER["DOCUMENT_ROOT"] . "/commun");
}
require_once(FADQ_CONFIG_SERVICE_PATH_COMMUN . '/class/Config.class.php');
require_once(FADQ_CONFIG_SERVICE_PATH_COMMUN . '/config/config.php');
$serveurGeo = Config::get('geo', 'serveurGeo');
$mapServer = Config::get('geo', 'serveurMapServer');
$mapServer = preg_quote($mapServer);
$serviceZoo = preg_quote(Config::get('geo', 'serviceZoo'));

//Si l'utilisateur est défini au niveau de Kerberos, utiliser la configuration interne
if(isset($_SERVER['PHP_AUTH_USER']))
{
    return include 'config_interne.php';
}
else //Sinon environnement PES
{        
    return include 'config_pes.php';
}
