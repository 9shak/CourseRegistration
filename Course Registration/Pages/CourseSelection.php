<!DOCTYPE html>
<?php
session_start();
include_once 'Functions.php';

if ($_SESSION['user'] == null) {
    header('Location:LogIn.php');
    exit;
}

// Initialize hours if not already set in the session
if (!isset($_SESSION['hoursLeft'])) {
    $_SESSION['hoursLeft'] = 16;
}
if (!isset($_SESSION['hoursHave'])) {
    $_SESSION['hoursHave'] = 0;
}

$user = FindUserName($_SESSION['user']);
$id = GetUserId($_SESSION['user']);
$semesterCode = GetSemesterCode();
$semesterTitle = GetSemesterTitle();
$errorCourse = "";

if (isset($_POST['buttonselect'])) {
    if ($_POST['select'] != "-1") {
        $_SESSION['select'] = $_POST['select'];
        $courseTitles = CourseSelectionNames($_POST['select'], $id);
        $courseCodes = CourseSelectionCode($_POST['select'], $id);
        $courseHours = CourseSelectionHours($_POST['select'], $id);
        $totalHours = TotalSemesterHours($id, $_POST['select']);

        // Calculate hours
        $_SESSION['hoursHave'] = array_sum($totalHours);
        $_SESSION['hoursLeft'] = 16 - $_SESSION['hoursHave'];
    }
}

if (isset($_POST['courseButton'])) {
    if (!empty($_POST['courses'])) {
        $hourcheck = $_SESSION['hoursHave'];
        foreach ($_POST['courses'] as $course) {
            $hourget = HourCount($course);
            $hourcheck += $hourget;
        }

        if ($hourcheck <= 16) {
            foreach ($_POST['courses'] as $course) {
                try {
                    RegisterCourse($id, $course, $_SESSION['select']);
                } catch (Exception $e) {
                    die("Error registering course: " . $e->getMessage());
                }
            }

            $_SESSION['hoursHave'] = $hourcheck;
            $_SESSION['hoursLeft'] = 16 - $_SESSION['hoursHave'];
        } else {
            $errorCourse = "Error: Hours exceed the 16-hour limit.";
        }
    } else {
        $errorCourse = "Error: No courses selected.";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Course Selection</title>
        <style>
            .tableBox {
                visibility: none;
            }
        </style>
    </head>
    <body>
        <?php include("./common/header.php") ?>
        <h1>Course Selection</h1>
        <p>Hello, <?php echo htmlspecialchars($user); ?> (ID: <?php echo htmlspecialchars($id); ?>)</p>
        <p>You have registered <?php echo $_SESSION['hoursHave']; ?> hours for the selected courses.</p>
        <p>You have <?php echo $_SESSION['hoursLeft']; ?> hours left of courses to be chosen.</p>
        <p style="color:red"><?php echo htmlspecialchars($errorCourse); ?></p>

        <p>Term</p>
        <form method="post">
            <select id='select' name="select">
                <option value="-1">Select</option>
                <?php
                for ($i = 0; $i < count($semesterTitle); $i++) {
                    echo "<option value='" . htmlspecialchars($semesterCode[$i]) . "'>" . htmlspecialchars($semesterTitle[$i]) . "</option>";
                }
                ?>
            </select>
            <input name="buttonselect" id="selectbutton" type="submit" style="display:none"/>
        </form>
        <script>
            const $check = document.getElementById('select');
            $check.addEventListener('change', function (e) {
                document.getElementById('selectbutton').click();
                e.preventDefault();
            });
        </script>

        <form method="post">
            <div class="tableBox">
                <h2>Courses</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Weekly Hours</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($courseTitles)) {
                            for ($i = 0; $i < count($courseTitles); $i++) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($courseCodes[$i]) . "</td>
                                    <td>" . htmlspecialchars($courseTitles[$i]) . "</td>
                                    <td>" . htmlspecialchars($courseHours[$i]) . "</td>
                                    <td><input type='checkbox' name='courses[]' value='" . htmlspecialchars($courseCodes[$i]) . "'/></td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <input type="submit" name="courseButton" value="Submit"/>
        </form>

        <?php include("./common/footer.php") ?>
    </body>
</html>
