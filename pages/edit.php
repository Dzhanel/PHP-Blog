<link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/other.css">
<div>
    <a href='../index.php'><button class="btn">Main page</button></a>
</div>

<?PHP

session_start();
include("../db/conn.php");
$error = '';
if (isset($_POST['update'])) {
    if (strlen($_POST['title']) <= 0) {
        $error = '<div class="error">Title cannot be empty! ✘</div>';
    } else if (strlen($_POST['text']) <= 0) {
        $error = '<div class="error">Article text cannot be empty! ✘</div>';
    } else {
        $sql = "UPDATE articles 
                SET title_article = '$_POST[title]', text_article = '$_POST[text]' 
                WHERE '$_POST[id_article]' = id_article";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $error = '<div class="valid">Article updated ✔</div>';
            header("Location:../index.php");
        } else {
            $error = '<div class="error">Error updating the article ✘</div>';
        }
    }
} else if (isset($_POST['edit'])) {
    $id_article = mysqli_real_escape_string($conn, $_POST['id_article']);
    $sql = "SELECT title_article, text_article FROM `articles` WHERE id_article = '$id_article'";
    $result = mysqli_query($conn, $sql);
    $articleInfo = mysqli_fetch_array($result);
    
    echo '<form action="edit.php" method="POST">
        <input type="hidden" name="id_article" value="'.$id_article.'">
        <label for="title">Title: </label>
        <input type="text" name="title" value='.$articleInfo['title_article'].'>
        <br><br>
        <textarea name="text" value='.$articleInfo['text_article'].'>'.$articleInfo['text_article'].'</textarea>
        <br><br>
        <input type="submit" value="Update" name="update">
    </form>';

    
} else if (isset($_POST['delete'])) {
    $id_article = mysqli_real_escape_string($conn, $_POST['id_article']);
    echo '<form action="edit.php" method="POST">
    <input type="hidden" name="id_article" value="'.$id_article.'">
    <label for="delete">Are you sure you really want to delete the article permanently?</label>
    <input type="submit" value="Yes, delete" name="delete_confirm">
    </form>';
    
} else if(isset($_POST['delete_confirm'])) {
    $sql = "DELETE FROM articles WHERE '$_POST[id_article]' = id_article";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<br><div class=\"valid\">Deleted successfuly</div>";
    } else {
        echo "Something went wrong";
    }
}
echo $error;

?>
