<html>
<head>
<title>Dale Stmarthe</title>
<?php
    require_once "pdo.php"; 
   session_start(); 
   
   if ( isset($_POST['delete']) && isset($_GET['user_id']) ) {
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':user_id' => $_GET['user_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}
    if (isset($_POST['logout']))
    {
        header( 'Location: logout.php' ) ;
    return;
    }
   
   ?>
</head>
<body>
<div class="container">
<p>
<h1>Welcome to this Profile/resume Database</h1>
<a href="login.php">Please log in</a>
</p>
</div>
<div class="container">
<table border="2">
<?php
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ( $rows === false || ! isset($_SESSION['name'])) {
echo "No rows found";
} else
{
    foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']));
    echo("</td><td>");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">View</a> / ');
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}
?>
</table>
<?php


if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>


<p><a href="add.php">Add New Entry</a></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</table>

</div>
</body>
</html>

