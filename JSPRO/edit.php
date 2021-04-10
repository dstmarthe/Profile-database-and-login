<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
    header('Location: index.php');
    return;
}


if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['headline']) && isset($_POST['email'])) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['email']) < 1|| strlen($_POST['headline']) < 1||  strlen($_POST['last_name']) < 1)  {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?user_id=".$_REQUEST['profile_id']);
        return;
    }
    elseif (strpos($_POST['email'], "@") === false){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: edit.php?profile_id=" . $_POST["profile_id"]);
return;
    } 

    $sql = "UPDATE Profile SET first_name = :first_name,
            last_name = :last_name, email = :email, headline = :headline, summary = :summary
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        'profile_id' => $_GET['profile_id']));
    $_SESSION['success'] = 'Record Edited';
    header( 'Location: index.php' ) ;
    return;
}


// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$hl = htmlentities($row['headline']);
$sm = htmlentities($row['summary']);

?>
<p>Update Resume</p>
<form method="post">
<p>first_name:
<input type="text" name="first_name" value="<?= $fn ?>"></p>
<p>last_name:
<input type="text" name="last_name" value="<?= $ln ?>"></p>
<p>email:
<input type="text" name="email" value="<?= $em ?>"></p>
<p>headline:
<input type="text" name="headline" value="<?= $hl ?>"></p>
<p>summary:
<input type="text" name="summary" value="<?= $sm ?>"></p>
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
