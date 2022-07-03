<head>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/other.css">
</head>
<div>
<form action="" method="post">
    <label for="username">Username: </label><br>
    <input type="text" name="username" id="username" placeholder="Your name">
    <br><br>
    <label for="email">Email: </label><br>
    <input type="email" name="email" id="email" placeholder="Your email">
    <br><br>
    <label for="password">Password: </label><br>
    <input type="password" name="password" id="password" placeholder="Your password">
    <br><br>
    <label for="repeat_pass">Repeat password: </label><br>
    <input type="password" name="repeat_pass" id="repeat_pass" placeholder="Repeat your password">
    <br><br>
    <input type="submit" name='register_btn' value="Register"><br>or you can
    <a href="../index.php">Login</a>
</form>
<br>
<?PHP
    include('../db/conn.php');
    session_start();
    if (isset($_POST['register_btn'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $repeat_pass = mysqli_real_escape_string($conn, $_POST['repeat_pass']);

        if ($username == '' || $email == '' || $password == '') {
            echo '<div class="error">All of the fields should be filled! ✘</div>';
            exit;
        }
        if ($password != $repeat_pass) {
            echo '<div class="error">Password and repeated password must be identical! ✘</div>';
            exit;
        }
        $rows = mysqli_query($conn, "SELECT email_us FROM users WHERE '$email' = email_us")->num_rows;
        
        if ($rows > 0) {
            echo '<div class="error">Email already exists! ✘</div>';
            exit;
        }
        
        $sql = "INSERT INTO users VALUES (null, '$email', '$password', '$username', 0);";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header('Location:../index.php');
        } else {
            echo '<div class="error">Something went wrong  ✘';
        }
    }

?>