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
        session_start();
        
        include_once 'Functions.php';
        
        if($_SESSION['user'] == null)
        {
            header('Location:LogIn.php');
        }
        $user = FindUserName($_SESSION['user']);
        $id = GetUserId($_SESSION['user']);
        $tableYear = RegisteredSemesterYear($_SESSION['user']);
        $tableSemester = RegisteredSemeterTerm($_SESSION['user']);
        $tableCode = RegisteredCourseCode($_SESSION['user']);
        $tableTitle = RegisteredCourseTitle($_SESSION['user']);
        $tableHour = RegisteredCourseHour($_SESSION['user']);
        
        
        if(isset($_POST["deletebutton"]))
        {
            if($_POST['delete'] != null)
            {
             foreach($_POST['delete'] as $row)
             {
                DeleteRegistration($id, $row);
             }
             header("Location: CourseRegistration.php");
            }
        }
                
                
        ?>
        <?php include("./common/header.php")?>
        <h1>Registered Courses</h1>
        
        <p>Hello <?php echo $user?></p>
        <p>Here are your current Registrations</p>
        <form method="post">
        <table class="table">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Term</th>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Hours</th>
                    <th>Select</th>
                </tr>
            </thead>
            
            <tbody>
                       
                <?php
                $FullHours = 0;
                $years = null;
                for($i = 0; $i < count($tableCode); $i++)
                {
                    if($years == null)
                    {
                        $years = $tableYear[$i];
                    }
                    else if($years != null && $years != $tableYear[$i])
                    {
                    print<<<Hours
                    <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Weekly Hours: $FullHours</td>
                    <td></td>
                    </tr>
                    Hours;
                    $FullHours = 0;
                    }
                    print<<<Table
                    <tr>
                    <td>$tableYear[$i]</td>
                    <td>$tableSemester[$i]</td>
                    <td>$tableCode[$i]</td>
                    <td>$tableTitle[$i]</td>
                    <td>$tableHour[$i]</td>
                    <td><input type="checkbox" name="delete[]" value="$tableCode[$i]"/></td>
                    </tr>
                    Table;
                    $FullHours = $FullHours + $tableHour[$i];
            
                }
                print<<<Hours
                    <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Weekly Hours: $FullHours</td>
                    <td></td>
                    </tr>
                    Hours;
                    $FullHours = 0;
                
                
                ?>
            
            </tbody>
        </table>
            <input type="submit" name="deletebutton" value="delete Course(s)" onclick="return confirm('the following courses will be deleted, are you sure?');"/>
        </form>
         <?php include("./common/footer.php")?>
    </body>
</html>
