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
         session_start();
         include("./common/header.php")?>
        <h1>Success</h1>
        <p>you have been logged in, click on the log in tab to log out</p>
         <?php include("./common/footer.php")?>
    </body>
</html>
