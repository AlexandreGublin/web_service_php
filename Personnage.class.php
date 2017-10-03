<?php

require_once("LabyrintheDefaut.class.php");

class Personnage extends LabyrintheDefaut{

    /**
    * @var int 
    * @private
    */
    private $_iIdPersonnage;

    /**
    * @var string 
    * @private
    */
    private $_sNomPersonnage;

    /**
    * @var int 
    * @private
    */
    private $_iPdd_personnage;

    /**
    *   @param int $iIdPersonnage 
    *   @constructor
    */
    public function __construct($iIdPersonnage){ 
        $oConnexion = self::getConnexion();
        $sPersonnage = "SELECT * FROM personnage WHERE id_personnage = ".$iIdPersonnage;
        $oResult = $oConnexion->query($sPersonnage);

        $aPersonnage = $oResult->fetch();

        $this->_iIdPersonnage = $iIdPersonnage;
        $this->_sNomPersonnage = $aPersonnage["nom_personnage"];
        $this->_iPdd_personnage = $aPersonnage["pdd_personnage"];                          
    }


    public static function all(){
        $oConnexion = self::getConnexion();
        $sListPersonnages = "SELECT id_personnage, nom_personnage, pdd_personnage FROM personnage ORDER BY nom_personnage";
        $oResult = $oConnexion->query($sListPersonnages);

        $aPersonnage = array();
        foreach($oResult as $aRow){
            $aPersonnage[] = new Personnage($aRow['id_personnage']);
        }
        
        return $aPersonnage;
    }

     /**
    *   Retourne l'id du personnage
    *   @return string Id du personnage 
    */
    public function getIdPersonnage(){
        return $this->_iIdPersonnage;
    }

    /**
    *   Retourne le nom du personnage
    *   @return string Nom du personnage 
    */
    public function getNomPersonnage(){
        return $this->_sNomPersonnage;
    }

    public function setNomPersonnage($sNomPersonnage){

        $sRequete = "UPDATE personnage SET nom_personnage = '". $sNomPersonnage ."' WHERE id_personnage = ".$this->_iIdPersonnage;
        $oConnexion->exec($sRequete);
        $this->_sNomPersonnage = $sNomPersonnage;
    }

    /**
    *   Retourne le nombre de pdd du personnage
    *   @return string Pdd du personnage 
    */
    public function getPddPersonnage(){
        return $this->_iPdd_personnage;
    }

    public function setPddPersonnage($iPdd_personnage){
        
        $oConnexion = self::getConnexion();
        $sRequete = "UPDATE personnage SET pdd_personnage = '". $iPdd_personnage ."' WHERE id_personnage = ".$this->_iIdPersonnage;
        $oConnexion->exec($sRequete);
        $this->_iPdd_personnage = $iPdd_personnage;
    }


    /**
    *   @param string $sNomPersonnage 
    *   @param int $iPdd_personnage
    *   @constructor
    */
    public static function creer ($sNomPersonnage, $iPdd_personnage){ 
        $oConnexion = self::getConnexion();

        $sRequete = "INSERT INTO personnage (nom_personnage, pdd_personnage) VALUES ('". $sNomPersonnage ."', ". $iPdd_personnage .")";        

        $oResult = $oConnexion->query($sRequete);  

        $oPersonnage = new Personnage($oConnexion->lastInsertId());
        
        return $oPersonnage;
    
    }

}