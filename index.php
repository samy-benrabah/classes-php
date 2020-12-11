<?php
require "lpdo.php";
$construct = new lpdo();
$construct->constructeur('localhost', 'root', '', 'classes');
$construct->execute("SELECT FROM utilisateurs WHERE login = marwane");
