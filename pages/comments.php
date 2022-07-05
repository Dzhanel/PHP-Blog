<link rel="stylesheet" href="../css/form.css">
<link rel="stylesheet" href="../css/article.css">
<link rel="stylesheet" href="../css/other.css">
<div>
    <a href='../index.php'><button class="btn">Main page</button></a>
</div>
<?PHP
session_start();
include("../db/conn.php");
if (isset($_SESSION['id'])) {
    echo '<form action="comments.php" method="POST">
    <label for="text">Add comment</label>
    <textarea name="text"></textarea>
    <br><br>
    <input type="submit" value="Comment" name="comment_btn">
    <input type="hidden" name="id_article" value="' . $_POST['id_article'] . '">
    </form>';
    if (isset($_POST["comment_btn"])) {
        $text = $_POST['text'];
        $comment_text = $_POST["text"];
        $author = $_SESSION['id'];
        $sql = "INSERT INTO `comments` (`id_comment`, `text_comment`, `date_comment`, `author_comment`, `article_comment`) 
                VALUES (NULL, '$text', now(), '$author', '$_POST[id_article]');";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($result) {
                echo '<div class="valid">Comment added ✔</div>';
            } else {
                echo '<div class="error">Error adding the comment ✘</div>';
            }
        }
    }
} else {
    echo '<div class="error">You should be logged in in order to post a comment!</div>';
}
?>
