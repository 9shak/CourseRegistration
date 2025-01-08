<!DOCTYPE html>
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
         include("./common/header.php");
         session_start();
        ?>
        
        <h1>Welcome to Online Registration</h1>
        <p>If you're new to this site, you will have to <a href="NewUser.php">sign up </a>first</p>
        <p>If you already have an account, you can go ahead and <a href="LogIn.php">log in</a></p>
        <?php include ("./common/footer.php")?>
    </body>
</html>
