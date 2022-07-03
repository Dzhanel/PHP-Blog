<?PHP
if (isset($_POST['login'])) {
    include('../db/conn.php');
    session_start();
    
    $_SESSION['login_error'] = 'false';
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['login_error'] = "<div class='error'>Password or username can't be empty! ✘</div>";
        header('Location:../index.php');
        exit;
    }

    $us = mysqli_escape_string($conn, $_POST['username']);
    $pass = mysqli_escape_string($conn, $_POST['password']);
    

    $sql = "SELECT * FROM USERS
    WHERE email_us = '$us' AND pass_us = '$pass';";

    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);


    $_SESSION['us'] = $us;
    $_SESSION['pass'] = $pass;
    
    if ($rows == 1) {
        $info = mysqli_fetch_array($result);
        $_SESSION['name'] = $info['name_us'];
        $_SESSION['perm'] = $info['perm_us'];
        $_SESSION["id"] = $info["id_us"];
    } else {
        $_SESSION['login_error'] = "<div class='error'>Wrong username or password. Please try again! ✘</div>";
    }
    
    header ('Location:../index.php');
}
?>