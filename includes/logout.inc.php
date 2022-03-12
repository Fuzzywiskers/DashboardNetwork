<?php

session_start();        //adds sessions//
session_unset();        //unsets variables in sessions//
session_destroy();      //destroys all session variables//

header("location: ../index.php");
exit();