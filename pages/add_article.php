<link rel="stylesheet" href="../css/form.css">
<link rel="stylesheet" href="../css/article.css">
<link rel="stylesheet" href="../css/other.css">
<div>
    <a href='../index.php'><button class="btn">Main page</button></a>
</div>
<form action="add_article.php" method="POST">
    <label for="title">Title: </label>
    <input type="text" name="title">
    <br><br>
    <textarea name="text"></textarea>
    <br><br>
    <input type="submit" value="Add article" name="add_btn">
</form>
<?PHP

session_start();
include("../db/conn.php");
$error = '';

if (isset($_POST['add_btn'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);
    if (strlen($title) <= 0) {
        $error = '<div class="error">Title cannot be empty! ✘</div>';
    } else if (strlen($text) <= 0) {
        $error = '<div class="error">Article text cannot be empty! ✘</div>';
    } else {
        $sql = "INSERT INTO articles VALUES (null, '$title', '$text', now(), $_SESSION[id])";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $error = '<div class="valid">Article added ✔</div>';
            header("Location:../index.php");
        } else {
            $error = '<div class="error">Error adding the article ✘</div>';
        }
    }
}

?>