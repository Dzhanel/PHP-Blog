<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jani's blog</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/article.css">
    <link rel="stylesheet" href="css/other.css">
</head>

<body>
    <?PHP
    session_start();
    //Login form html
    $loginForm = "
    <div class=\"form\">
    <form action=\"pages/login.php\" method=\"POST\">
    <p>
    <label for=\"username\">Email</label><br>
    <input id=\"username\" type=\"text\" name=\"username\" placeholder=\"Email goes here\">
    <br>
    </p>
    <p>
    <label for=\"password\">Password</label><br>
    <input type=\"password\" name=\"password\" placeholder=\"Password goes here\">
    </p>
    <input type=\"submit\" value=\"Login\" name=\"login\"><br>or you can
    <a href=\"pages/register.php\">Register</a>
    </form></div>";

    if (isset($_SESSION['name'])) {
        echo '<h1 style="font-family: arial;">Hi, ';
        echo $_SESSION['name'] . "</h1>";
        echo '<a href="pages/add_article.php" style="font-family: arial;"><button class="btn">Add article</button></a>';
        echo '<a href="pages/logout.php" style="font-family: arial;"><button class="btn">Log out</button></a>';
    } else if (isset($_SESSION['login_error'])) {
        echo $loginForm;
        if ($_SESSION['login_error'] != "false") {
            echo "<div class='error'>" . $_SESSION['login_error'] . "</div>";
            $_SESSION['login_error'] = "false";
        }
    } else {
        echo $loginForm;
    }
    ?>
    <div>

        <?PHP
        include('db/conn.php');

        //Article sql
        $sql = "SELECT * FROM articles as A LEFT
            JOIN USERS AS U ON 
            A.author_article = U.id_us ORDER BY
            A.date_article desc";

        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);
        //End of article sql

        if ($rows > 0) {
            while ($article = mysqli_fetch_array($result)) {

                //Article
                echo '<div class="article"><div class="title">' . nl2br($article['title_article']) . "<br><div class=\"date\">" . change_date($article['date_article']) . "</div></div>";
                echo "<div class='text'>" . nl2br($article['text_article']) . "</div>";
                echo "<div class='author'>" . $article['name_us'] . "</div></div>";
                //End of article

                //Option buttons
                if (isset($_SESSION['id']) && $_SESSION['id'] == $article['author_article']) {
                    echo '<div class="options">
                        <form action="pages/edit.php" method="POST"> 
                        <input type="hidden" name="id_article" value="' . $article['id_article'] . '">
                        <input type="submit" name="edit" value="edit">
                        <input type="submit" name="delete" value="delete">
                        </form>
                        </div>';
                }
                //End of option buttons

                //Comments

                //Comment sql
                $comment_sql = "SELECT * FROM comments as C
                                LEFT JOIN users AS U ON
                                C.author_comment = U.id_us
                                LEFT JOIN articles AS A ON
                                C.article_comment = A.id_article
                                WHERE '$article[id_article]' = C.article_comment
                                ORDER BY C.date_comment";
                $comment_result = mysqli_query($conn, $comment_sql);
                $comment_rows = mysqli_num_rows($comment_result);
                //End of comment sql

                //Display comments under every article
                if (isset($_SESSION["id"])) {
                    echo '<div class="add_comment">
                        <form action="pages/comments.php" method="POST">
                            <input type="hidden" name="id_article" value="' . $article['id_article'] . '">
                            <input type="submit" name="add_comment_btn" value="add comment">
                        </form>
                        </div>';
                    while ($comment = mysqli_fetch_array($comment_result)) {
                            echo '<div class="comment">
                                <div class="comment_text">' . $comment['text_comment'] . '</div>
                                <div class="comment_author">' . $comment['name_us'] . '</div>
                                <div class="comment_date">' . change_date($comment['date_comment']) . '</div>
                                </div>';
                        
                    }
                }
                //end of comments
            }
        } else {
            echo 'No articles yet';
        }
        ?>
    </div>
    </div>
</body>

</html>