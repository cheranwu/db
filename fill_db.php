<?php
include("classes/users.php");

$users = new users();
$blah = $users->reset_db();

?>

<?=$blah?>
