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
        
        <h1>you have been logged out</h1>
        <?php session_destroy();?>
       <?php include("./common/footer.php")?>
    </body>
</html>
