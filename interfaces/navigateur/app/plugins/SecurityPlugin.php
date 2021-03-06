<?php
use Phalcon\Mvc\User\Plugin;

$config = include __DIR__ . "/../config/config.php";
include $config->application->services->dir."fonctions.php";
/*
 * TODO !!!
 * Il faut nettoyer les fonctions non utilisées de cette classe.
 * Définir comment reconnaitre un utilisateur anonyme.
 */

class SecurityPlugin extends Plugin
{
    public function beforeExecuteRoute(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher){
        $authentificationModule = $this->getDI()->get("authentificationModule"); 
        if($authentificationModule == null){
            return;
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();              
        $config = $this->getDI()->get("config");

        if($controller === "connexion" || $controller === "error"){
            $config = $this->getDI()->get("config");
            $this->getDI()->get("view")->setViewsDir($config->application->services->viewsDir);
        }else if($controller === "igo" && ($action === "configuration" || $action === "index")){
            $configuration = $this->obtenirConfiguration($action, $dispatcher);
            if(isset($this->getDi()->getConfig()->configurations[$configuration])){
                $file = $this->getDi()->getConfig()->configurations[$configuration];
            } else {
                $file = $this->getDi()->getConfig()->configurationsDir . $configuration . '.xml';
            }
            if((!file_exists($file) && !curl_url_exists($file))){
                return $this->forwardToErrorPage();
            }
            if($this->estAuthentificationRequise($configuration) && !$this->estAnonyme() && !$this->estAuthentifie()){
                return $this->forwardToLoginPage();
            }else if($this->estAuthentificationRequise($configuration) && $this->estRoleSelectionneRequis() && !$this->estRoleSelectionne()){
                return $this->forwardToRolePage();
            } else if (!$this->estAuthentificationRequise($configuration) && !$this->estAuthentifie()){
                $authentificationModule = $this->getDI()->get("authentificationModule");
                if(!$this->session->has("info_utilisateur")) {
                    $this->session->set("info_utilisateur", new SessionController());
                }
                $configuration = $this->getDI()->get("config");
                if($configuration->offsetExists("database")) {
                    // Si la BD n'existe pas dans la config on n'ajoute pas de profil et on se base sur le xml
                    if($this->estRoleSelectionneRequis()){
                        $this->session->get("info_utilisateur")->profilActif = IgoProfil::findFirst("nom = '{$configuration->application->authentification->nomProfilAnonyme}'")->id;
                    } else if(isset($configuration->application->authentification->nomProfilAnonyme)){
                        $this->session->get("info_utilisateur")->profils = IgoProfil::find("nom = '{$configuration->application->authentification->nomProfilAnonyme}'");
                    } 
                }
                $this->session->get("info_utilisateur")->estAnonyme = true;
            } else if($this->estRoleSelectionneRequis() && !$this->estRoleSelectionne()){
                return $this->forwardToRolePage();
            }
            
            if($this->estAnonyme() && isset($config->application->authentification->permettreAccesAnonyme) && !$config->application->authentification->permettreAccesAnonyme){
                return $this->forwardToUnauthorizedPage();
            }

        }else if ($controller == "igo" && ($action == "contexte" || $action == "couche" || $action == "groupe")){                        
            if(!$this->estAnonyme() && !$this->estAuthentifie()){                
                return $this->forwardToLoginPage();
            }else if($this->estRoleSelectionneRequis() && !$this->estRoleSelectionne()){
                return $this->forwardToRolePage();
            }if($this->estAnonyme() && isset($config->application->authentification->permettreAccesAnonyme) && !$config->application->authentification->permettreAccesAnonyme){
                return $this->forwardToUnauthorizedPage();
            }            
        }                    
    }
    
    private function forwardToLoginPage(){
        $this->dispatcher->forward(array(
            "controller" => "connexion",
            "action" => "index"
        ));
        return;
    }
    
    private function forwardToErrorPage(){
        $this->dispatcher->forward(array(
            "controller" => "error",
            "action" => "error404"
        ));
        return;
    }
    
    private function forwardToUnauthorizedPage(){
        $this->dispatcher->forward(array(
            "controller" => "error",
            "action" => "error403"
        ));
        return;
    }    
    private function forwardToRolePage(){
        $this->dispatcher->forward(array(
            "controller" => "connexion",
            "action" => "role"
        ));
        return;
    }    
    
    private function estAuthentificationRequise($configuration){
        if(!isset($this->getDi()->getConfig()->application->authentification) ||
           $this->getDi()->getConfig()->application->authentification == false){
            return false;
        }
        if(isset($this->getDi()->getConfig()->configurations[$configuration])){
            $xmlPath = $this->getDi()->getConfig()->configurations[$configuration];
        } else {
            $xmlPath = $this->getDi()->getConfig()->configurationsDir . $configuration . '.xml';
        }
        if(file_exists($xmlPath)){
            $element = simplexml_load_file($xmlPath);            
        } else { //url externe
            $element = simplexml_load_string(curl_file_get_contents($xmlPath)); 
        }              
        if(isset($element->attributes()->authentification)){
            $authentification = $element->attributes()->authentification;
        }else{
            $authentification = "true"; // Est-ce qu'on devrait forcer l'authentification par defaut? En attendant de décider, on le force par défaut.
        }        
        // Si la configuration demande que l'utilisateur soit authentifié et qu'il ne l'est pas encore, le rediriger vers la fenetre de connexion        
        if($authentification == "true"){ 
            return true;
        }else{
            return false;
        }
    }
    
    private function estAuthentifie(){
        if($this->session->has("info_utilisateur")) {
            return $this->session->get("info_utilisateur")->estAuthentifie;
        }
        return false;
    }
    
    private function estAnonyme(){
        if($this->session->has("info_utilisateur")) {
            return $this->session->get("info_utilisateur")->estAnonyme;
        }
        return false;
    }
    
    private function estRoleSelectionneRequis(){
        if(isset($this->getDi()->getConfig()->application->authentification->activerSelectionRole)){
            return $this->getDi()->getConfig()->application->authentification->activerSelectionRole;
        }
        return false;
    }
    
    private function estRoleSelectionne(){
        if($this->session->has("info_utilisateur")) {
            return !is_null($this->session->get("info_utilisateur")->profilActif);
        }
        return false;
    }
    
    private function obtenirConfiguration($action, $dispatcher){
        if($action === "index"){
            $configuration = "defaut";
        }else {
            $configuration = $dispatcher->getParam("configuration");
        }
        return $configuration;
    }
    
}