<?php
session_start();
require_once "pdo.php";

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

// If the user requested logout go to logout.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<h1> Profile Resumes and such</h1>

<table border="1">
<?php
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, headline, summary FROM Profile WHERE profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Record Not Found';
    header( 'Location: index.php' ) ;
    return;
}
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']));
    echo("</td><td>");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['email']));
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td><td>");
    echo(htmlentities($row['summary']));
    echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
}

?>
<p><a href="add.php">Add A New Entry</a></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</table>

</body>
</html>