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
        //database
        include_once 'Functions.php';
        
        //varaibles
        $errorName = "";
        $errorID = "";
        $errorPhone = "";
        $errorPassword = "";
        $errorPasswordCheck = "";
        $complete = "";
        
        $bool;
        //Sign Up Button
        if(isset($_POST['submit'])){
            $bool = true;
            
            //student ID
            if($_POST['studId'] == null || ctype_space($_POST['studId']))
            {
                 $errorID = "Error: Enter a student ID";
                 $bool = false;
            }
            else
            {
                if(FindUserId($_POST['studId']) == $_POST['studId'])
                {
                    $errorID = "Error: user Id already exists";
                    $bool = false;
                }
                
            }
            
            //Student Name 
            if($_POST['studName'] == null || ctype_space($_POST['studName']))
            {
                $errorName = "Error: Enter a student name";
                $bool = false;
            }
            else 
            {
                
            }
            
            //Phone Number
            if($_POST['phone'] == null || ctype_space($_POST['phone']))
            {
                $errorPhone = "Error: Enter a phone number";
                $bool = false;
                
            }
            else 
{
    $phoneNumberRegex = "/^[2-9][0-9]{2}-[2-9][0-9]{2}-[0-9]{4}$/";
    
    if (preg_match($phoneNumberRegex, $_POST['phone']))
    {
        // Valid phone number
    }
    else
    {
        $errorPhone = "Error: Phone is not inputted correctly";
        $bool = false;
    }
}
            
            //Password
            if($_POST['pass'] == null || ctype_space($_POST['pass']))
            {
                $errorPassword = "Error: Enter a Password";
                $bool = false;
            }
            else 
            {
                
                $passwordCap = "([A-Z]{1,})";
                 $passwordlower = "([A-Z]{1,})";
                  $passwordNum = "([A-Z]{1,})";
                  
                  if(strlen($_POST['pass']) >= 6)
                  {
                      
                  
                if(preg_match($passwordCap,$_POST['pass']))
                {
                    if(preg_match($passwordlower,$_POST['pass']))
                    {
                        if(preg_match($passwordNum,$_POST['pass']))
                        {
                            
                        }
                         else
                         {
                           $errorPassword = "Error: Password not entered correctly";
                            $bool = false;
                         }
                    }
                     else
                     {
                       $errorPassword = "Error: Password not entered correctly";
                       $bool = false;
                     }
                }
                else
                {
                  $errorPassword = "Error: Password not entered correctly";
                  $bool = false;
                }
                }
                else
                {
                  $errorPassword = "Error: Password not entered correctly";
                  $bool = false;
                }
          
            }
            
            //Password Check
            if($_POST['passCheck'] == null || ctype_space($_POST['passCheck']))
            {
                $errorPasswordCheck = "Error: Enter the password again";
                $bool = false;
            }
            else 
            {
               $passwordRegex = "(\D[A-Z][a-z][0-9])";
               
               
                if ($_POST['passCheck'] == $_POST['pass'])
                {
                    
                }
                else
                {
                    $errorPasswordCheck = "Error: not the same as the password above";
                    $bool = false;
                }
            }
            
        
            //if no errors
            if($bool == true)
            {
                try
                {
                    RegisterUser($_POST['studId'], $_POST['studName'], $_POST['phone'], $_POST['pass']);
                   
                }
                catch(Exception $g)
                {
                    die("it didn't work");
                }
                $complete = "Student has been created";
                
            }
            
            
        }
                    
        
        ?>
        <?php include("./common/header.php")?>
    <h1>Sign up</h1>
    <p>All Fields are Required</p>
    <form method='post'>
    <div>
        <!<!-- Student Id -->
    <p>Student ID</p>
    <input type='text' name='studId'/>
    <p style='red'><?php echo $errorID?></p>
   
    <!<!-- Student Name -->
    <p>Student Name</p>
    <input type='text' name='studName'/>
    <p style='red'><?php echo $errorName?></p>
    
    <!<!-- Phone Number -->
    <p>Phone Number</p>
    <p>(nnn-nnn-nnnn)</p>
    <input type='text' name='phone'/>
    <p style='red'><?php echo $errorPhone?></p>
    
    <!<!-- Password -->
    <p>Password</p>
    <input type='password' name='pass'/>
    <p style='red'><?php echo $errorPassword?></p>
    
    <!<!-- Password again -->
    <p>Password Again</p>
    <input type='password' name='passCheck'/>
    <p style='red'><?php echo $errorPasswordCheck?></p>
    </div>
        
    <!<!-- Buttons -->
    <input type='submit' name='submit' value='Submit'/>
    <input type='reset' value='clear'/>
    <p style="green"><?php echo $complete?></p>
    </form>
<?php include("./common/footer.php")?>
    
    
    </body>
</html> 