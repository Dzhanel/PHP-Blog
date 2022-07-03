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
    } else if(isset($_SESSION['login_error'])) {
        echo $loginForm;
        if ($_SESSION['login_error'] != "false") {
            echo "<div class='error'>".$_SESSION['login_error']."</div>";
            $_SESSION['login_error'] = "false";           
        }
    }
    else {
        echo $loginForm;
    }
    ?>
    <div>
        
        <?PHP
            include('db/conn.php');
            $sql = "SELECT * FROM articles 
                    ORDER BY date_article DESC";
            $result = mysqli_query($conn, $sql);
            $rows = mysqli_num_rows($result);
            if ($rows > 0) {
                while ($article = mysqli_fetch_array($result)) {
                    echo '<div class="article"><div class="title">'.nl2br($article['title_article'])."</div>";
                    echo "<div class='text'>".nl2br($article['text_article'])."</div>";
                    echo '<br/><br/></div>';
                }
                
            } else {
                echo 'No articles yet';
            }
        ?>
    </div>
</body>

</html>