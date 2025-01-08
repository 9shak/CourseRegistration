<!DOCTYPE html>
<?php error_reporting(0); ?> 
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'Functions.php';
        session_start();
        
        //if session is null
        if($_SESSION['user'] != null)
        {
            header("Location: Logout.php");
            exit();
        }
        //variables
        $bool;
        $error;
        
        if(isset($_POST['butt']))
        {
            $bool = true;
            
            //finding user
            if($_POST['studId'] == null || ctype_space($_POST['studId']))
            {
                $error = "Error: ID or password is incorrect";
                $bool = false;
            }
            else
            {
                try
                {
                    $user = FindUserId($_POST['studId']);
                }
                catch(Exception $e)
                {
                    die("no");
                }
                if($user == false)
                {
                    $bool = false;
                    $error = "Error: ID or password is incorrect";
                }
            }
            
            //finding password
             if($_POST['pass'] == null || ctype_space($_POST['pass']))
            {
                $error = "Error: ID or password is incorrect";
                $bool = false;
            }
            else
            {
                
                $passHash = hash('sha256', $_POST['pass']);
                try
                {
                    $pass = FindPassword($passHash);
                }
                catch(Exception $f)
                {
                    die("no");
                }
                if($pass == false)
                {
                    $bool = false;
                    $error = "Error: ID or password is incorrect";
                }
            }
            
            //logging in the user
            if($bool == true)
            {
                $_SESSION['user'] = $_POST['studId'];
                header("Location: LoginSuccess.php");
                exit();
            }

        }
        
        
        
        
        
        
        ?>
        <?php include("./common/header.php")?>
        
        
        <h1>Login</h1>
        <p>don't have an account? <a href='NewUser.php'>sign up.</a></p>
        <form method="post">
        <p style="color:red"><?php echo $error?></p>
        <p>Student ID</p>
        <input type="text" name="studId"/>
        
        
        <p>Password</p>
        <input type="password" name="pass"/>
        
        
        <input type="submit" name="butt" value="login"/>
        <input type="reset" name="clear" value="clear"/>
        </form>
        
        
        <?php include("./common/footer.php")?>
    </body>
</html>
