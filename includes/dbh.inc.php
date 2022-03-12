<!--Data Base Handle-->
<?php

$serverName = "localhost";          //use 'localhost' since is runing on my computers local host//   
$dbUsername = "root";       //Data Base Username//
$dbPassword = "";        //Data Base Password | since I am using 'XMAPP' for the host, password is empty//
$dbName = "projectnetwork";           //Data Base Name | your choice to name it//

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);        //connection to database using 'MySQLi'//

//produce error message if connection fails//
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
