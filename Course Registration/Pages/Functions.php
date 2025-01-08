<?php
function getPDO()
{
    $connectDb = parse_ini_file("DBConnection.ini");
    extract($connectDb);
    return new PDO($dsn, $scriptUser, $scriptPassword);
}

function FindUserId($userId)
{
   
    $pdo = getPDO();
    $scriptName = "SELECT StudentId FROM student WHERE StudentId = :UserId";
    $result = $pdo->prepare($scriptName);
    $result->execute(['UserId' => $userId]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    if($row)
    {
    return true;
    }
    else
    {
        return false;
    }
}

function GetUserId($userId)
{
   
    $pdo = getPDO();
    $scriptName = "SELECT StudentId FROM student WHERE StudentId = :UserId";
    $result = $pdo->prepare($scriptName);
    $result->execute(['UserId' => $userId]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    return $row['StudentId'];
  
}

function FindUserName($userId)
{
   
    $pdo = getPDO();
    $scriptName = "SELECT Name FROM student WHERE StudentId = :UserId";
    $result = $pdo->prepare($scriptName);
    $result->execute(['UserId' => $userId]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    return $row['Name'];
    
}

function FindPassword($pass)
{
    
    $pdo = getPDO();
    $scriptName = "SELECT Password FROM student WHERE Password = :password";
    $result = $pdo->prepare($scriptName);
    $result->execute(['password' => $pass]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    if($row)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function RegisterUser($userId, $userName, $userPhone, $password)
{
    $pdo = getPDO();
    $passwordHash = hash('sha256', $password);

    $sql = "INSERT INTO student VALUES( :studentId, :name, :phone, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['studentId' => $userId, 'name' => $userName, 'phone' => $userPhone, 'password' => $passwordHash]);
    
}

function GetSemesterCode()
{
    $pdo = getPDO();

    $sql = "select SemesterCode from semester";
    $query = $pdo->query($sql);
    $code = array();
    foreach($query as $row)
    {
        $code[] = $row['SemesterCode'];
    }
    return $code;
}

function GetSemesterTitle()
{
    $pdo = getPDO();
    $semesters = array();
    
    $sql = "select Term, Year from semester";
    $query = $pdo->query($sql);
    foreach($query as $row)
    {
        $semesters[] = $row['Term'].'-'.$row['Year'];
    }
    return $semesters;
}

function CourseSelectionNames($semester, $student)
{
    $pdo = getPDO();
    $courses = array();
    
   $sql = "SELECT course.Title 
 FROM course INNER JOIN courseoffer ON course.CourseCode = courseoffer.CourseCode 
 WHERE courseoffer.SemesterCode = :Semester 
 AND course.CourseCode NOT IN (SELECT CourseCode FROM registration WHERE StudentId = :Student)";
    
   $query = $pdo->prepare($sql);
   $query->execute(['Semester' => $semester, 'Student' => $student]);
   
   foreach($query as $rows)
   {
       $courses[] = $rows['Title'];
   }
   return $courses;
           
    
}

function CourseSelectionCode($semester, $student)
{
    $pdo = getPDO();
    $courses = array();
    
   $sql = "SELECT course.CourseCode, course.Title, course.WeeklyHours 
 FROM course INNER JOIN courseoffer ON course.CourseCode = courseoffer.CourseCode 
 WHERE courseoffer.SemesterCode = :Semester 
 AND course.CourseCode NOT IN (SELECT CourseCode FROM registration WHERE StudentId = :Student)";
    
   $query = $pdo->prepare($sql);
   $query->execute(['Semester' => $semester, 'Student' => $student]);
   
   foreach($query as $rows)
   {
       $courses[] = $rows['CourseCode'];
   }
   return $courses;
}

function CourseSelectionHours($semester, $student)
{
    $pdo = getPDO();
    $courses = array();
   $sql = "SELECT course.WeeklyHours 
 FROM course INNER JOIN courseoffer ON course.CourseCode = courseoffer.CourseCode 
 WHERE courseoffer.SemesterCode = :Semester 
 AND course.CourseCode NOT IN (SELECT CourseCode FROM registration WHERE StudentId = :Student)";
    
   $query = $pdo->prepare($sql);
   $query->execute(['Semester' => $semester, 'Student' => $student]);
   
   foreach($query as $rows)
   {
       $courses[] = $rows['WeeklyHours'];
   }
   return $courses;
}

function RegisterCourse($studentId, $courseCode, $semester)
{
    $pdo = getPDO();
    
    $sql = "INSERT INTO registration VALUES (:StudentId, :CourseCode, :SemeterTerm)";
    $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId, 'CourseCode' => $courseCode, 'SemeterTerm' => $semester]);
}


function RegisteredCourseCode($studentId)
{
    $pdo = getPDo();
    $codes = array();
    $sql ="SELECT course.CourseCode
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :StudentId";
    $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId]);
    
    foreach($query as $row)
    {
        $codes[] = $row['CourseCode'];
    }
    return $codes;
}
function RegisteredCourseTitle($studentId)
{
    $pdo = getPDo();
    $titles = array();
    $sql ="SELECT course.Title
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :StudentId";
    $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId]);
    
    foreach($query as $row)
    {
        $titles[] = $row['Title'];
    }
    return $titles;
}
function RegisteredCourseHour($studentId)
{
    $pdo = getPDo();
    $hours = array();
    $sql ="SELECT course.WeeklyHours 
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :StudentId";
        $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId]);
    
    foreach($query as $row)
    {
        $hours[] = $row['WeeklyHours'];
    }
    return $hours;
}
function RegisteredSemesterYear($studentId)
{
    $pdo = getPDo();
    $years = array();
    $sql ="SELECT semester.Year
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :StudentId";
        $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId]);
    
    foreach($query as $row)
    {
        $years[] = $row['Year'];
    }
    
    return $years;
    
}
function RegisteredSemeterTerm($studentId)
{
    $pdo = getPDO();
    $terms = array();
    $sql ="SELECT semester.Term 
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :StudentId";
        $query = $pdo->prepare($sql);
    $query->execute(['StudentId' => $studentId]);
    
    foreach($query as $row)
    {
        $terms[] = $row['Term'];
    }
    
    return $terms;
}

function TotalSemesterHours($studentId, $term)
{
    $pdo = getPDO();
    $hours = array();
    $sql = "SELECT course.WeeklyHours
FROM course INNER JOIN registration ON course.CourseCode = registration.CourseCode 
INNER JOIN semester ON registration.SemesterCode = semester.SemesterCode 
WHERE registration.StudentId = :studentId AND semester.SemesterCode = :term";
    $query = $pdo->prepare($sql);
    $query->execute(['studentId' => $studentId, 'term' => $term]);
    
    foreach($query as $row)
    {
        $hours[] = $row['WeeklyHours'];
    }
    return $hours;
    
}

function HourCount($courseCode)
{
    $pdo = getPDO();
    $sql = "SELECT WeeklyHours FROM course WHERE CourseCode = :courseCode";
    $query = $pdo->prepare($sql);
    $query->execute(['courseCode' => $courseCode]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    return $row['WeeklyHours'];
}


function DeleteRegistration($studentId, $courseCode)
{
    $pdo = getPDO();
    $sql = "DELETE FROM registration WHERE StudentId = :studentId AND CourseCode = :courseCode";
    $query = $pdo->prepare($sql);
    $query->execute(['studentId' => $studentId, 'courseCode' => $courseCode]);
    
}
?>

