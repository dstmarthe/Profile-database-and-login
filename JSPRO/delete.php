<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['user_id']) ) {
    die('Not logged in');
    header('Location: index.php');
    return;
}

if ( isset($_POST['delete'])) {
    $sql = "DELETE * FROM Profile WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':profile_id' => $_GET['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}
?>
<html>
<head><title>Dale Stmarthe</title></head>
<body>
<div class= "container"
<h2> Confirm: Deleting profile id: <?$_GET['profile_id']?> ?</h2>
<form method="POST">
    <p><input type="submit" name="Delete"></p>
 </form>
 <p><a href="index.php">Cancel</a></p>
    </div>
</form>
</body>
</html>