<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
    header('Location: index.php');
    return;
}

if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

if ( isset($_POST['first_name']) && isset($_POST['last_name']) 
     && isset($_POST['headline'])) 
     {
         if (strlen($_POST['first_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 ||  strlen($_POST['last_name']) < 1)
         {
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
        return;
         
         }
         
         else {
            $stmt = $pdo->prepare('INSERT INTO Profile
            (user_id, first_name, last_name, email, headline, summary)
            VALUES ( :uid, :fn, :ln, :em, :he, :su)');
          
          $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'])
          );
      $_SESSION['success'] = "added";
header("Location: index.php");
return;
    } 
}

?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<h1><strong>Add Your Profile</strong></h1>
<p>Add A New Car</p>
<form method="post">
<p>first_name
<input type="text" name="first_name" size="40"></p>
<p>last_name
<input type="text" name="last_name"></p>
<p>email
<input type="text" name="email"></p>
<p>headline
<input type="text" name="headline"></p>
<p>summary
<input type="text" name="summary"></p>
<p><input type="submit" value="Add New Entry"/></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</form>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
</html>