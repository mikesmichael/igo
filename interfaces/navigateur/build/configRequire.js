require.config({
        paths:{
                analyseurConfig: 'js/app/analyseur/analyseurConfig',
                analyseurGML: 'js/app/analyseur/analyseurGML',
                analyseurGeoJSON: 'js/app/analyseur/analyseurGeoJSON',
                contexteMenu: 'js/app/contexteMenu/contexteMenu',
                contexteMenuArborescence: 'js/app/contexteMenu/contexteMenuArborescence',
                contexteMenuCarte: 'js/app/contexteMenu/contexteMenuCarte',
                contexteMenuTable: 'js/app/contexteMenu/contexteMenuTable',
                gestionCouches: 'js/app/couche/gestionCouches',
                OSM: 'js/app/couche/protocole/OSM',
                TMS: 'js/app/couche/protocole/TMS',
                WMS: 'js/app/couche/protocole/WMS',
                blanc: 'js/app/couche/protocole/blanc',
                couche: 'js/app/couche/protocole/couche',
                google: 'js/app/couche/protocole/google',
                marqueurs: 'js/app/couche/protocole/marqueurs',
                vecteur: 'js/app/couche/protocole/vecteur',
                vecteurCluster: 'js/app/couche/protocole/vecteurCluster',
                ligne: 'js/app/occurence/geometrie/ligne',
                limites: 'js/app/occurence/geometrie/limites',
                multiPoint: 'js/app/occurence/geometrie/multiPoint',
                multiLigne: 'js/app/occurence/geometrie/multiLigne',
                multiPolygone: 'js/app/occurence/geometrie/multiPolygone',
                occurence: 'js/app/occurence/occurence',
                cluster: 'js/app/occurence/cluster',
                point: 'js/app/occurence/geometrie/point',
                polygone: 'js/app/occurence/geometrie/polygone',
                style: 'js/app/occurence/style',
                aide: 'js/app/helper/aide',
                browserDetect: 'js/app/helper/browserDetect',
                contexte: 'js/app/helper/contexte',
                evenement: 'js/app/helper/evenement',
                fonctions: 'js/app/helper/fonctions',
                metadonnee: 'js/app/helper/metadonnee',
                requireAide: 'js/app/helper/requireAide',
                arborescence: 'js/app/menu/arborescence',
                googleItineraire: 'js/app/menu/googleItineraire',
                googleStreetView: 'js/app/menu/googleStreetView',
                impression: 'js/app/menu/impression',
                itineraire: 'js/app/menu/itineraire',
                localisation: 'js/app/menu/localisation',
                recherche: 'js/app/menu/recherche/recherche',
                rechercheAdresse: 'js/app/menu/recherche/rechercheAdresse',
                rechercheBorne: 'js/app/menu/recherche/rechercheBorne',
                rechercheCadastreReno: 'js/app/menu/recherche/rechercheCadastreReno',
                rechercheGPS: 'js/app/menu/recherche/rechercheGPS',
                rechercheHQ: 'js/app/menu/recherche/rechercheHQ',
                rechercheLieu: 'js/app/menu/recherche/rechercheLieu',
                rechercheInverseAdresse: 'js/app/menu/recherche/rechercheInverseAdresse',
                outil: 'js/app/outil/outil',
                outilAide: 'js/app/outil/outilAide',
                outilAjoutWMS: 'js/app/outil/outilAjoutWMS',
                outilAnalyseSpatiale: 'js/app/outil/outilAnalyseSpatiale',
                outilControleMenu: 'js/app/outil/outilControleMenu',
                outilDeplacement: 'js/app/outil/outilDeplacement',
                outilDeplacerCentre: 'js/app/outil/outilDeplacerCentre',
                outilDessin: 'js/app/outil/outilDessin',
                outilEdition: 'js/app/outil/outilEdition',
                outilHistoriqueNavigation: 'js/app/outil/outilHistoriqueNavigation',
                outilInfo: 'js/app/outil/outilInfo',
                outilItineraire: 'js/app/outil/outilItineraire',
                outilMenu: 'js/app/outil/outilMenu',
                outilMesure: 'js/app/outil/outilMesure',
                outilPartagerCarte: 'js/app/outil/outilPartagerCarte',
                outilProfil: "js/app/outil/outilProfil",
                outilRapporterBogue: 'js/app/outil/outilRapporterBogue',
                outilSelection: 'js/app/outil/outilSelection',
                outilTableSelection: 'js/app/outil/outilTableSelection',
                outilZoomEtendueMaximale: 'js/app/outil/outilZoomEtendueMaximale',
                outilZoomPreselection: 'js/app/outil/outilZoomPreselection',
                outilZoomRectangle: 'js/app/outil/outilZoomRectangle',
                panneau: 'js/app/panneau/panneau',
                panneauAccordeon: 'js/app/panneau/panneauAccordeon',
                panneauCarte: 'js/app/panneau/panneauCarte',
                panneauEntete: 'js/app/panneau/panneauEntete',
                panneauInfo: 'js/app/panneau/panneauInfo',
                panneauMenu: 'js/app/panneau/panneauMenu',
                panneauOnglet: 'js/app/panneau/panneauOnglet',
                panneauTable: 'js/app/panneau/panneauTable',
                barreOutils: 'js/app/barreOutils',
                carte: 'js/app/carte',
                navigateur: 'js/app/navigateur',
                css: 'libs/require/src/css',
                text: 'libs/require/src/text',
                hbars: 'libs/require/src/hbars',
                async: "libs/require/src/async",
                noAMD: "libs/require/src/noAMD",
                proj4js: 'libs/proj/Proj4js',
                epsgDef: 'libs/proj/epsgDef',
                dateTimeIntervalPicker: 'libs/extension/Extjs/DateTimeIntervalPicker',
                MSPDatePicker: 'libs/extension/Extjs/MSPDatePicker',
                layerTreeBuilderBuild: 'empty:',
                kmlMsp: 'empty:',
                fileUploadField: 'empty:',
                getInfo: 'empty:',
                handlebars: 'empty:',
                IGODatePicker: 'empty:'
        }
});