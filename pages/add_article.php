<form action="add_article.php" method="POST">
    <label for="title">Title: </label>
    <input type="text" name="title">
    <br><br>
    <textarea name="text" cols="100" rows="30"></textarea>
    <br><br>    
    <input type="submit" value="Add article" name="add_btn">  
</form>
<?PHP
session_start();
include("../db/conn.php");

if (isset($_POST['add_btn'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);
    $sql = "INSERT INTO articles VALUES (null, '$title', '$text', now(), $_SESSION[id])";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo 'article added';
    }
    else {
        echo 'Error adding the article';
    }
}

?>