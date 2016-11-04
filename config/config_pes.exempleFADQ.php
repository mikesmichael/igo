<?php
/**
 * @idCompFonc(2805)
 */

defined('FADQ_ID_COMP_FONC') or define('FADQ_ID_COMP_FONC', 2805);
require_once($_SERVER["DOCUMENT_ROOT"] . "/commun/inc/unite.inc.php");

 $serverApplicatif = preg_quote($_SERVER["HTTP_VULTURE_BASE_URL"]);

return array(
    'repertoireLogs' => '/tmp/log/', //Répertoire de logs
    'database' => array(
        'adapter'     => 'Oracle',
        //'host'        => 'oradev12c-scan.fadq.qc',
        'username'    => Config::get('donnees', 'oracle', 'usager'),
        'password'    => Config::get('donnees', 'oracle', 'motPasse'),
        'dbname'      => Config::get('donnees', 'oracle', 'serveur'),
        'schema'      => Config::get('donnees', 'oracle', 'usager'),
        'modelsMetadata' => 'Off' // valeurs possibles de configuration : Apc, Xcache, Off
    ),
    'data' => array(
        'adapter'     => 'Oracle',
        'username'    => Config::get('donnees', 'oracle', 'usager'),
        'password'    => Config::get('donnees', 'oracle', 'motPasse'),
        'dbname'      => Config::get('donnees', 'oracle', 'serveur'),
        'schema'      => Config::get('donnees', 'oracle', 'usager'),
        'modelsMetadata' => 'Off' // valeurs possibles de configuration : Apc, Xcache, Off
    ),
    'application' => array(
        // Permet de versionner les fichiers javascripts et css (possible de mettre 'aleatoire')
        'version'        =>  '1.0.0',
        // Mode debug: des fichiers non-compillés, aucune cache serveur, messages d'erreurs plus nombreux
        'debug'          => true,
        'navigateur'  => array(
            'controllersDir' => $baseNavigateurDir . 'app/controllers/',
            'modelsDir'      => $baseNavigateurDir . 'app/models/',
            'viewsDir'       => $baseNavigateurDir . 'app/views/',
            'pluginsDir'     => $baseNavigateurDir . 'app/plugins/',
            'libraryDir'     => $baseNavigateurDir . 'app/library/',
            'cacheDir'       => $baseNavigateurDir . 'app/cache/'
        ),
        'services'  => array(
            'dir' => $baseServicesDir,
            'controllersDir' => $baseServicesDir . 'igo_commun/app/controllers/',
            'viewsDir'       => $baseServicesDir . 'igo_commun/app/views/'
        ),
        'authentification' => array(
            'authentificationExterne' => false,
            'module' => 'AuthentificationPES',
            'moduleSession' => 'SessionControllerPES'
        ),
        //Répertoire où se situe les modules
        'modules' => $baseDir . '/modules'
    ),
    //url des différentes parties du projet
    'uri' => array(
        'navigateur'    => "/igo_navigateur/",
        'librairies'    => "/igo/librairie/",
        'services'      => "/igo/services/",
        'api'           => "/api/",
        'modules'       => '/igo/modules/'
    ),
    //Options des outils/panneaux à ajouter à une classe
    //Voir la documentation XML pour une liste plus complète
    //Les options définies dans le xml sont prédominantes.
    'navigateur' => array(
        'OutilAide'  => array('lien' => 'http://'.$_SERVER["SERVER_NAME"].'/aide/Nouveautes_IGO.pdf'),
        'OutilAjoutWMS'         => array('urlPreenregistre' => "http://xxxxxxxxxxxxxxxxxx/cgi-wms/adnInternetV2.fcgi,"
                                                            . "http://xxxxxxxxxxxxx/wms/toporama,"
                                                            . "http://xxxxxxxxxxxxxxxxxx/cgi-wms/inspq_icu.fcgi,"
                                                            . "http://xxxxxxxxxxxxxxxxxx/cgi-wms/gouvouvertqc.fcgi"),
	'OutilZoomPreselection'  => array('service' => '[zoomPreSelection]'), // [] -> Fait référence à servicesExternes->zoomPreSelection
        'OutilImportFichier'    => array('urlService' => "https://{$serveurGeo}:3000/convert",
                                         'formatSupporte'=> array('csv', 'zip', 'geojson', 'georss', 'gml', 'gpx', 'kml', 'kmz', 'sql')),
        'OutilExportFichier'        => array('urlService' => "https://xxxxxxxxxxxxx:3000/convert"),
        'Recherche'  => array(
            'service' => '[gloV6]',
            'format'  => 'json',
            'cle' => 'glo'
        ),                
        'Itineraire'     =>  array(
            'service' => "https://xxxxxxxxxxxxxxxxxx/Services/itineraire",
            'serviceGLO' => '[gloV6]',
            'cle' => 'glo'
        ),           
        'WMS'     =>  array(
            'infoFormat' => "application/vnd.ogc.gml"
        )
    ),
    'cles' => array(
        'glo'  => 'xxxxxxxxxxxx'
    ),
    //Services permis par le proxy
    'servicesExternes' => array(
        'gloV6'         => 'http://xxxxxxxxxxxxxxxxxx/Services/glo/V6/gloServeurHTTP.php',
        'regex'  =>  array(
            "#https://{$mapServer}/(.)+#", //FADQ
            "#https://{$serveurGeo}/(.)+#",
            "#".$serverApplicatif. "(.)+#"


        ),
        'zoomPreSelection'  => 'http://xxxxxxxxxxxxxxxxxx/libcommunes/MSPwidgets/coordonnees.php'
    ),
    // les configurations permettent d'appeler un fichier xml en mode rest et d'associer une clé avec un lien vers un fichier
    'configurations' => array(
        'defaut'        => $baseXmlDir . str_replace("https://", "", explode(".",$_SERVER["HTTP_VULTURE_BASE_URL"])[0]) .'.xml'
    ),
    'permissions' => true


);