<?php  session_start();
include_once 'function.php'; /*on recupere les fonctions dont on a besoin*/


class inscription{
    
   private $NOM;
   private $Prenom;
   private $email;
   private $mdp;
   private $mdp2;
   private $bdd;
    
    public function __construct($NOM,$Prenom,$email,$mdp,$mdp2){
        
        
        $NOM = htmlspecialchars($NOM);
        $Prenom = htmlspecialchars($Prenom);
        $email = htmlspecialchars($email);
        
        $this->NOM = $NOM; 
        $this->Prenom = $Prenom;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->mdp2 = $mdp2;
        $this->bdd = bdd();
        
        
    }
    
    public function verif(){
        
        if(strlen($this->NOM) AND strlen($this->Prenom)  > 2 AND strlen($this->NOM) AND strlen($this->Prenom) < 20 ){ /*Si le NOM est bon*/
          
           $syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
           if(preg_match($syntaxe,$this->email)){ /*email bon*/
               
               if(strlen($this->mdp) > 5 AND strlen($this->mdp) < 20 ){ /*Si le mot de passe à le bon format*/
                  
                   if($this->mdp == $this->mdp2){/*Deux mots de passe bon*/
                       return 'ok';
                   }
                   else { /*Mot de passe !=*/
                       $erreur = 'Les mots de passe doivent être identique';
                       return $erreur;
                   }
               }
               else {/*Mauvais format du mot de passe*/
                   $erreur = 'Le mot de passe doit contenir entre 5 et 20 caractères';
                   return $erreur;
               }
               
               
           }
           else { /*email mauvais*/
               $erreur = 'Syntaxe de l\'adresse email incorrect ';
               return $erreur;
           }
        }
        else { /*NOM mauvais*/
            $erreur = 'Le NOM doit contenir entre 3 et 20 caractères';
            return $erreur;
        }
        
    }
    
    
    public function enregistrement(){
        
        $requete = $this->bdd->prepare('INSERT INTO membre(NOM,Prenom,email,mdp) VALUES(:NOM,:Prenom,:email,:mdp)');
        $requete->execute(array(
            'NOM'=>  $this->NOM,
            'Prenom'=>  $this->Prenom,
            'email' => $this->email,
            'mdp' => $this->mdp 
        ));
        
        return 1; 
       
    }
    
    public function session(){
        $requete = $this->bdd->prepare('SELECT id FROM membre WHERE NOM = :NOM ');
        $requete->execute(array('NOM'=>  $this->NOM));
        $requete = $requete->fetch();
        $_SESSION['id'] = $requete['id'];
        $_SESSION['NOM'] = $this->NOM;
        
        return 1;
    }
    
    
    
}

