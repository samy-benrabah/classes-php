<?php
class userpdo
{ //définition de la classe de utilisateur
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function register($login, $password, $email, $firstname, $lastname){
        $this->login=$login;
        $this->email=$email;
        $this->password=$password;
        $this->firstname=$firstname;
        $this->lastname=$lastname;

        //nouvelle connextion à la bdd
      $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");

      

      // Hachage du mot de passe
      $pass_hache = password_hash($_POST['password'], PASSWORD_BCRYPT,['cost' =>12]);

      
      // Insertion dans la base de donnée
      $req = $bdd->prepare('INSERT INTO utilisateurs(login, email, password, firstname, lastname) VALUES(:login, :email, :password, :firstname, :lastname)');
      $req->execute(array(
          'login' => $this->login,
          'email' => $this->email,
          'password' => $this->pass_hache,
          'firstname' => $this->firstname,
          'lastname' => $this->lastname,
        ));
        $resultat = $req->fetch();

return($resultat);
      }

    public function connect($login, $password){

//nouvelle connexion à la bdd
      $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
      //  Récupération de l'utilisateur et du mot de passe chiffré
      $req = $bdd->prepare('SELECT id, login,password FROM utilisateurs WHERE login = :login');
      $req->execute(array(
          'login' => $login));
      $resultat = $req->fetch();

      // Comparaison du pass envoyé via le formulaire avec la base
      $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

      if (!$resultat)
      {
          echo 'Mauvais identifiant ou mot de passe !';
      }
      else
      {
        // les variables de session sont crées
          if ($isPasswordCorrect) {
              session_start();
              $_SESSION['id'] = $resultat['id'];
              $_SESSION['login'] = $login;
              echo 'Vous êtes connecté !';
          }
          else {
              echo 'Mauvais identifiant ou mot de passe !';
          }
          return($resultat);
      }


    }


       public function disconnect() {
           $_SESSION = array();
           session_destroy();
           session_start();
       }

       public function delete(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("DELETE FROM utilisateurs WHERE id = $this->$id");
         $req->execute();
       }


       public function update(
           $login,
           $password,
           $email,
           $firstname,
           $lastname
       )
{
           $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
    
         $data = [
          'id' =>$this->$id,
          'login' => $this->$login,
          'password' => $this->$password,
          'email' => $this->$email,
          'firstname' => $this->$firstname,
          'lastname' => $this->$lastname

      ];
      $req = "UPDATE utilisateurs SET login=:login, password=:password, email=:email, firstname=:firstname, lastname=:lastname WHERE id=:id";
      $resultat= $bdd->prepare($req);
      $resultat->execute($data);

    return($data);
    }

           public function isConnected()
    {

    if(isset($_SESSION['login'])){
      $session= true;
    }
    else {
     $session= false;
    }
    return $session;
    }

       public function getAllInfos(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT * FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         return($user);
       }


       public function getLogin(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT login FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         return($user);
       }


       public function getEmail(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT email FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         return($user);

       }


       public function getFirstname(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT firstname FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         return($user);
       }

       public function getLastname(){
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT lastname FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         return($user);
       }


       public function refresh()
       {
         $bdd = new PDO("mysql:host=localhost;dbname=classes","root","");
         $req = $bdd->prepare("SELECT firstname FROM utilisateurs WHERE id=:id");
         $req->execute(['id' =>$this->$id]);
         $user = $req->fetch();
         

       }


?>
