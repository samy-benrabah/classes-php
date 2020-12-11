<?php

class user
{

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function register($login, $password, $email, $firstname, $lastname)
    {

        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $reqtab = "SELECT *FROM users WHERE login='$login'";
        $querytab = mysqli_query($bdd, $reqtab);
        $num = mysqli_num_rows($querytab);

        if ($num == 0) {
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $requser = "INSERT INTO users VALUES(NULL, '$login', '$hash', '$email','$firstname','$lastname')";
            $queryuser = mysqli_query($bdd, $requser);

            return array(
                'login' => $this->login,
                'email' => $this->email,
                'password' => $this->pass_hache,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
            );

        } else {
            return "login déjà existant";
        }

    }

    public function connect($login, $password)
    {

        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $query = "SELECT * FROM users WHERE login='$login'";
        $result = mysqli_query($bdd, $query);
        $row = mysqli_fetch_array($result);

        if (password_verify($password, $row['password'])) {
            $this->id = $row['id'];
            $this->login = $login;
            $this->email = $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];

            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            return (var_dump($row));
        } else {
            return "Login ou mot de passe incorrect";
        }

    }

    public function disconnect()
    {
        session_destroy();
        return "Vous êtes bien déconnecté";
    }

    public function delete()
    {

        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $bdd = mysqli_connect("localhost", "root", "", "classes");
            $del = "DELETE FROM users WHERE login='$login'";
            mysqli_query($bdd, $del);
            session_destroy();
        }

    }

    public function update($login, $password, $email, $firstname,
        $lastname) {
        if (isset($_SESSION['login'])) {

            $bdd = mysqli_connect("localhost", "root", "", "classes");
            $log = $_SESSION['login'];
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $update = "UPDATE users SET login='$login', password='$hash', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$log'";
            mysqli_query($bdd, $update);
        }
    }

    public function isConnected()
    {
        $connected = false;
        if (isset($_SESSION['login'])) {
            $connected = true;
        } else {
            $connected = false;
        }

        return ($connected);

    }

    public function getAllInfos()
    {
        if (isset($_SESSION['login'])) {
            return ($login);
        } else {

            return "Il n'y a personne connecté à ce nom";
        }
    }

    public function getLogin()
    {
        return ($this->login);
    }

    public function getEmail()
    {
        return ($this->email);
    }

    public function getFirstname()
    {
        return ($this->firstname);
    }

    public function getLastname()
    {
        return ($this->lastname);
    }

    public function refresh()
    {
        $bdd = mysqli_connect("localhost", "root", "", "classes");
        $login = $_SESSION['login'];
        $queryuser = "SELECT *from users WHERE login='$login'";
        $resultuser = mysqli_query($bdd, $queryuser);
        $tabuser = mysqli_fetch_array($resultuser);

        $this->id = $tabuser['id'];
        $this->login = $tabuser['login'];
        $this->email = $tabuser['email'];
        $this->firstname = $tabuser['firstname'];
        $this->lastname = $tabuser['lastname'];
    }
}
