<?php
require_once('profilage.php');
$baseEditionDir = $baseDir . 'edition/';
$fichierXml = definirProfil($baseXmlDir);
return array(
    'repertoireLogs' => '/tmp/log/', //Répertoire de logs
    'database' => array(
        'adapter'     => 'Oracle',
        //'host'        => 'oradev12c-scan.fadq.qc',
        'username'    => Config::get('donnees', 'oracle', 'usager'), 
        'password'    => Config::get('donnees', 'oracle', 'motPasse'),
        'dbname'      => Config::get('donnees', 'oracle', 'serveur'),
        'schema'      => Config::get('donnees', 'oracle', 'usager'),
        //'dbname' => '//oradev12c-scan.fadq.qc:1521/dev.fadq.qc',
        'modelsMetadata' => 'Off' // valeurs possibles de configuration : Apc, Xcache, Off
    ),
    'data' => array(
        'adapter'     => 'Oracle',
       // 'host'        => 'oradev12c-scan.fadq.qc',
        'username'    => Config::get('donnees', 'oracle', 'usager'),
        'password'    => Config::get('donnees', 'oracle', 'motPasse'),      
        'dbname'      => Config::get('donnees', 'oracle', 'serveur'),
        //'dbname' => '//oradev12c-scan.fadq.qc:1521/dev.fadq.qc',
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
        'edition' => array(
            'fieldsDir' => $baseEditionDir . 'app/fields/',
            'utilDir' => $baseEditionDir . 'app/util/',
            'servicesDir' => $baseEditionDir . 'app/services/',
            'exemplesServicesDir' => $baseEditionDir . 'app/services/exemple/',
            'controllersDir' => $baseEditionDir . 'app/services/fadq/'
        ),        
        'services'  => array(
            'dir' => $baseServicesDir,
            'controllersDir' => $baseServicesDir . 'igo_commun/app/controllers/',
            'viewsDir'       => $baseServicesDir . 'igo_commun/app/views/'     
        ),
        'authentification' => array(
            'authentificationExterne' => true,  
            'module' => 'AuthentificationExterne'
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
        'modules'       => '/igo/modules/',
        'edition'      => "/igo/edition/", 
        'requeteSpatiale' => "/igo/requete-spatiale/"
    ),
    //Options des outils/panneaux à ajouter à une classe
    //Voir la documentation XML pour une liste plus complète
    //Les options définies dans le xml sont prédominantes.
    'navigateur' => array(
        
        'OutilAide'  => array('lien' => 'http://'.$_SERVER["SERVER_NAME"].'/aide/Nouveautes_IGO.pdf'),
        'OutilAjoutWMS'         => array('urlPreenregistre' => "http://xxxxxxxxxxx/cgi-wms/adnInternetV2.fcgi,"
                                                            . "http:/xxxxxxxxxxxxx/wms/toporama,"
                                                            . "http://xxxxxxxxxxxxxx/cgi-wms/inspq_icu.fcgi,"
                                                            . "http://xxxxxxxxxxxxx/cgi-wms/gouvouvertqc.fcgi"),
      /*  'OutilImportFichier'    => array('urlService' => 'http://ogre.adc4gis.com/convert'), //Version en ligne du service
        'OutilExportSHP'        => array('urlService' => 'http://ogre.adc4gis.com/convertJson'), //Version en ligne du service
       */
	'OutilZoomPreselection'  => array('service' => '[zoomPreSelection]'), // [] -> Fait référence à servicesExternes->zoomPreSelection 
        'OutilImportFichier'    => array('urlService' => "http://{$serveurGeo}:3000/convert", 
                                         'formatSupporte'=> array('csv', 'zip', 'geojson', 'georss', 'gml', 'gpx', 'kml', 'kmz', 'sql')),
       // 'OutilExportSHP'        => array('urlService' => "http://{$serveurGeo}:3000/convert"),
        'OutilExportFichier'        => array('urlService' => "http://{$serveurGeo}:3000/convert"),
        'Recherche'  => array(
            'service' => '[gloV6]',
            'format'  => 'json',
            'cle' => 'glo'
        ),
        'RechercheCadastreReno' => array('url' => "http://www.xxxxxxxxxxxxxxxxxxx/mapserver/find_lot_v2.php"),
        'Itineraire'     =>  array(
            'service' => "http://xxxxxxxxxxxxxxxxxxx/Services/itineraire",
            'serviceGLO' => '[xxxxxxx]',
            'cle' => 'xxxxx'
        ),
        'WMS'     =>  array(
            'infoFormat' => "application/vnd.ogc.gml"
        )
    ),
    'cles' => array(
        'glo'  => 'xxxxxxxxxxxxxxxx'
    ),
    //Services permis par le proxy
    'servicesExternes' => array(
        'gloV6'         => 'http://xxxxxxxxxxxxxxxxxxxx/Services/glo/V6/gloServeurHTTP.php',  
        'regex'  =>  array(),
        'zoomPreSelection'  => 'http://xxxxxxxxxxxxxxxxxx/libcommunes/MSPwidgets/coordonnees.php'
    ),
    // les configurations permettent d'appeler un fichier xml en mode rest et d'associer une clé avec un lien vers un fichier
    'configurations' => array(
        'defaut'        => $baseXmlDir . $fichierXml,
 //       'defaut'        => $baseXmlDir . explode(".",$_SERVER["SERVER_NAME"])[0] .'.xml',
//        'defaut'          => $baseXmlDir . 'igo.xml',
        'exemple'          => $baseXmlDir . "exemple.xml"
    ),
    'services' => array(
        'MaoPointFeatureService',
        'MaoLineFeatureService',
        'MaoSurfFeatureService'
    ),
    'grouping' => 'SchemaService'                    
);