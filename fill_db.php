<?php
//this might take a while to run
session_start();
include("classes/users.php");

$users = new users();
$blah = $users->reset_db();

?>

<?=$blah?>
