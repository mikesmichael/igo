<?php

//Global pour groupe de l'active directory qui ont été vérifiés
global $grpAD;

$grpAD = [];

/**
 * Définir le fichier de configuration XML à utiliser pour l'exécution
 * @param string $baseXmlDir: Répertoire contenant les fichiers xml de configuration
 * @return string nom du fichier xml à utiliser pour l'exécution
 */
function definirProfil($baseXmlDir)
{
    //Si un utilisateur "Kerberos" est défini
    if(isset($_SERVER['PHP_AUTH_USER']))
    {
        //Obtenir le code d'utilisateur
        $utilisateur = strtolower(stristr($_SERVER['PHP_AUTH_USER'], "@", true));


        //Si le code utilisateur fait partie du groupe analyse agroclimatique
        if(verifierGroupeLDAP($utilisateur, "ANALYSE_AGROCLIMATIQUE"))
        {
            //fichier Igo groupe avec droit agroclimatique
            return explode(".",$_SERVER["SERVER_NAME"])[0] .'Agroclimatique.xml';
        }

        //Si le code utilisateur a un fichier de configuration personnel
        if(file_exists($baseXmlDir . $utilisateur . ".xml"))
        {
            return $utilisateur . ".xml";
        }
    }

    //Utiliser le fichier de configuration de l'environnement
    return explode(".",$_SERVER["SERVER_NAME"])[0] .'.xml';
}

/**
 * Vérifier si l'utilisateur fait parti d'un groupe LDAP
 * @param string $utilisateur: code utilisateur
 * @param string $group: groupe LDAP à valider
 * @return bool true/false si l'utilisateur fait parti du groupe LDAP
 */

function verifierGroupeLDAP($utilisateur, $group)
{
    $user = 'igoldap';
    $password = '******************';
    $host = 'XX.XXX.X.XXX';
    $domain = 'XXXX.QC';
    $basedn = 'DC=fadq,DC=qc';

    $ad = ldap_connect("ldap://{$host}") or die('Could not connect to LDAP server.');
    ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
    @ldap_bind($ad, "{$user}@{$domain}", $password) or die('Could not bind to AD.');
    $userdn = getDN($ad, $utilisateur, $basedn);
    if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))) {
    //if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
       // echo "You're authorized as ".getCN($userdn);
        return true;
    } else {
        //echo 'Authorization failed';
        return false;
    }
    ldap_unbind($ad);
}

/*
* This function searchs in LDAP tree ($ad -LDAP link identifier)
* entry specified by samaccountname and returns its DN or epmty
* string on failure.
*/
function getDN($ad, $samaccountname, $basedn) {
    $attributes = array('dn');
    $result = ldap_search($ad, $basedn,
        "(samaccountname={$samaccountname})", $attributes);
    if ($result === FALSE) { return ''; }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count']>0) { return $entries[0]['dn']; }
    else { return ''; };
}

/*
* This function retrieves and returns CN from given DN
*/
function getCN($dn) {
    preg_match('/[^,]*/', $dn, $matchs, PREG_OFFSET_CAPTURE, 3);
    return $matchs[0][0];
}

/*
* This function checks group membership of the user, searching only
* in specified group (not recursively).
*/
function checkGroup($ad, $userdn, $groupdn) {
    $attributes = array('members');
    $result = ldap_read($ad, $userdn, "(memberof={$groupdn})", $attributes);
    if ($result === FALSE) { return FALSE; };
    $entries = ldap_get_entries($ad, $result);
    return ($entries['count'] > 0);
}

/*
* This function checks group membership of the user, searching
* in specified group and groups which is its members (recursively).
*/
function checkGroupEx($ad, $userdn, $groupdn) {

	//Vérifier que le groupe n'a pas déjà été vérifé/contrer le problème de 2 groupes qui s'inclus mutuellement
	global $grpAD;
    if(!in_array($userdn, $grpAD))
        array_push($grpAD, $userdn);
    else {
        return false;
    }

    $attributes = array('memberof');
    $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
    if ($result === FALSE) {
        return FALSE;
    }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count'] <= 0) {
        return FALSE;

    }
    if (empty($entries[0]['memberof'])) {
        return FALSE;

    } else {
        for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
            if ($entries[0]['memberof'][$i] == $groupdn) {
                return TRUE;

            }
            elseif (checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn)) {
                return TRUE;

            }
        }
    }
    return FALSE;
}
