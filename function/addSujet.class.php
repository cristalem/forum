<?php include_once 'function.php';/*on recupere les fonctions dont on a besoin*/
/*recuperation des donnees dans la base et definition de la classe*/ 
class addSujet{
    
    private $name;
    private $sujet;
    private $categorie;
    private $bdd;
    
    public function __construct($name,$sujet,$categorie) {
        
        $this->name = htmlspecialchars($name);
        $this->sujet = htmlspecialchars($sujet);
        $this->categorie = htmlspecialchars($categorie);
        $this->bdd = bdd();
        
    }
    
    
    public function verif(){
        
        if(strlen($this->name) > 1 AND strlen($this->name) < 60 ){ /*Si le nom du sujet est bon**/
            
            if(strlen($this->sujet) > 0){ /*Si on a bien un sujet*/
                
                return 'ok';
            }
            else {/*Si on a pas de contenu*/
                $erreur = 'Veuillez entrer le contenu du sujet';
                return $erreur;
            }
            
        }
        else { /*Si le nom du sujet est mauvais*/
            $erreur = 'Le nom du sujet doit contenir entre 1 et 60 caractères';
            return $erreur;
        }
        
    }
    /*ajout dans la base de donnees*/
    public function insert(){
        
        $requete = $this->bdd->prepare('INSERT INTO sujet(name,categorie) VALUES(:name,:categorie)');
        $requete->execute(array('name'=> $this->name,'categorie'=>  $this->categorie));
        
        $requete2 = $this->bdd->prepare('INSERT INTO postsujet(propri,contenu,date,sujet) VALUES(:propri,:contenu,NOW(),:sujet)');
        $requete2->execute(array('propri'=>$_SESSION['id'],'contenu'=>  $this->sujet,'sujet'=>  $this->name));
        
        return 1;
    }
}
