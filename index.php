<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jani's blog</title>
</head>

<body>
    <?PHP
    session_start();
    //Login form html
    $loginForm = "<form action=\"pages/login.php\" method=\"POST\">
    <p>
    <label for=\"username\">Username: </label>
    <input id=\"username\" type=\"text\" name=\"username\" placeholder=\"Email goes here\">
    <br>
    </p>
    <p>
    <label for=\"password\">Password: </label>
    <input type=\"password\" name=\"password\" placeholder=\"Password goes here\">
    </p>
    <br>
    <input type=\"submit\" value=\"Login\" name=\"login\"> 
    </form>";  

    if (isset($_SESSION['name'])) {
        echo '<h1 style="font-family: arial;">Hi, ';
        echo $_SESSION['name'] . "</h1>";
        echo '<a href="pages/add_article.php" style="font-family: arial;"><button>Add article</button></a>';
        echo '<a href="pages/logout.php" style="font-family: arial;"><button>Log out</button></a>';
    } else if(isset($_SESSION['login_error'])) {
        echo $loginForm;
        if ($_SESSION['login_error'] != "false") {
            echo $_SESSION['login_error'];
            print_r($_SESSION);
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
                    echo $article['title_article'];
                    echo "<br/>";
                    echo $article['text_article'];
                    echo '<br/><br/>';
                }
                
            } else {
                echo 'No articles yet';
            }
        ?>
    </div>
</body>

</html>