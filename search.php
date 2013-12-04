<?php
include("classes/search.php");
include("classes/users.php");
$user = new users();
var_dump($_POST);
//convert passed in day/month/year into epoch times

$_POST['e_depart_time'] = mktime(0,0,0,intval(substr($_POST['depart'],0,2)),intval(substr($_POST['depart'],3,5)),intval(substr($_POST['depart'],6,9)));
$_POST['e_return_time'] = mktime(0,0,0,intval(substr($_POST['return'],0,2)),intval(substr($_POST['return'],3,5)),intval(substr($_POST['return'],6,9) ));


var_dump($_POST);
//find routes
$routes = new Search($_POST, $user);


?>