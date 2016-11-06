<?php
$conn = new mysqli('localhost', 'root', '', 'schools');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_POST['action'] == 'add') {


    if (empty($_POST['name'])) {
        $error = " empty name";
    } else {


        echo md5(time());
        $img = time() . '_' . rand(1111, 9999) . '_' . $_FILES['file']['name'];

        $sql = "INSERT INTO student (name,address,date_birth,date_add,last_update,school_id,note,photo,gender)
VALUES ('" . $_REQUEST['name'] . "','" . $_REQUEST['address'] . "','" . $_REQUEST['date_birth'] . "','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "','" . $_REQUEST['school_id'] . "','" . $_REQUEST['note'] . "','" . $img . "','" . $_REQUEST['gender'] . "')";

        $sucess = '';
        $error = '';
        if ($conn->query($sql) === TRUE) {

            $student_id = $conn->insert_id;
            foreach ($_POST['language_id'] as $k => $v) {
                $sql = "INSERT INTO student_language (language_id,student_id) VALUES ('" . $_POST['language_id'][$k] . "','" . $student_id . "')";
                $conn->query($sql);
            }
            foreach ($_POST['hobby_id'] as $k => $v) {
                $sql = "INSERT INTO student_hobby (hobby_id,student_id) VALUES ('" . $_POST['hobby_id'][$k] . "','" . $student_id . "')";
                $conn->query($sql);
            }


            move_uploaded_file($_FILES["file"]["tmp_name"], "img/" . $img);

            $sucess = "New record created successfully";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
if ($_POST['action'] == 'update') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $id = $_POST['id'];
    $date_birth = $_POST['date_birth'];
    $school_id = $_POST['school_id'];
    $note = $_POST['note'];

    $img = time() . '_' . rand(1111, 9999) . '_' . $_FILES['file']['name'];
    $sqll = "UPDATE student SET name='" . $name . "', address='" . $address . "',date_birth='" . $date_birth . "',school_id='" . $school_id . "', note='" . $note . "', photo='" . $img . "' WHERE id=$id";

    if ($conn->query($sqll) === TRUE) {
        move_uploaded_file($_FILES["file"]["tmp_name"], "img/" . $img);
        $sucess = "Record updated successfully";

        $sql = "DELETE FROM student_language WHERE student_id ='{$id}'";
        $conn->query($sql);

        //update language and save it  
        foreach ($_POST['language_id'] as $k => $v) {
            $sql = "INSERT INTO student_language (language_id,student_id) VALUES ('" . $_POST['language_id'][$k] . "','" . $id . "')";
            $conn->query($sql);
        }
        
        //update hobby and save it  
        $sql = "DELETE FROM student_hobby WHERE student_id ='{$id}'";
        $conn->query($sql);

        foreach ($_POST['hobby_id'] as $k => $v) {
            $sql = "INSERT INTO student_hobby (hobby_id,student_id) VALUES ('" . $_POST['hobby_id'][$k] . "','" . $id . "')";
            $conn->query($sql);
        }
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
if ($_GET['action'] == 'del') {

    $iddd = $_GET['id'];

    $sql = " DELETE FROM student WHERE id=$iddd";
    if ($conn->query($sql) === TRUE) {
        $sucess = "Record deleted successfully";
    } else {
        $error = "Error deleted record: " . $conn->error;
    }
}
?>















<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Signin Template for Bootstrap</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            <!-- Static navbar -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Project name</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
                            <li><a href="../navbar-static-top/">Static top</a></li>
                            <li><a href="../navbar-fixed-top/">Fixed top</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>

            <div class="row">
                <div class="col-lg-6" >
<?php if (!empty($sucess)): ?>
                        <p class="bg-success sc-alert"><?php echo $sucess ?></p>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <p class="bg-danger sc-alert" ><?php echo $error ?></p>
                    <?php endif; ?>
                </div>
            </div>


<?php
if ($_GET['action'] == 'edit'):
    $sql = "SELECT
              student.id,
            student.`name`,
            student.date_birth,
            student.address,
            student.date_add,
            student.last_update,
            student.note,
            student.gender,
            student.school_id,
            schools.`name` as name1

                    FROM student
                INNER JOIN schools ON student.school_id = schools.id  where student.id ='{$_GET['id']}'";
    $resultOb = $conn->query($sql);
    $student = $resultOb->fetch_assoc();
    ?>


                <div class="row">
                    <div class="col-lg-4">
                        <form action="student.php" method="post" enctype="multipart/form-data">

                            <input name="id" type="hidden" value="<?php echo $student['id'] ?>" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $student['name'] ?>"  id="name" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">address</label>
                                <input type="text"  name="address" class="form-control" value="<?php echo $student['address'] ?> " id="address" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">date_birth</label>
                                <input type="text"  name="date_birth" class="form-control"value="<?php echo $student['date_birth'] ?>" id="date_birth" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">note</label>
                                <textarea name="note" class="form-control" rows="3"><?php echo $student['note'] ?></textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">file</label>
                                <input type="file" name="file" id="fileToUpload">                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">school_id</label>


    <?php
    $sql = "SELECT
                                schools.id as school_id,
                                schools.`name` as school_name,
                                schools.date_add,
                                schools.last_update,
                                schools.address
                                FROM
                                schools
                                order by id desc";
    $resultOb = $conn->query($sql);
    ?>
                                <label>School :</label>
                                <select name="school_id" class="form-control">
    <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['school_id'] ?>"> <?php echo $row['school_name'] ?> </option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">note </label><br>
    <?php foreach (array('male', 'female') as $k => $g): ?>
                                    <input name="gender" id="gender<?php echo $k ?>" type="radio"  value="<?php echo $g ?>" <?php echo ($g == $student['gender']) ? "checked=\"checked\"" : '' ?>> <label for="gender<?php echo $k ?>"><?php echo $g ?></label> <br>

    <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Language</label>
    <?php
    $resultOb1 = $conn->query("select * from student_language where student_id='{$_GET['id']}'");
    $oldLanguages = array();
    while ($l = $resultOb1->fetch_assoc()) {
        $oldLanguages[] = $l['language_id'];
    }
    $resultOb1 = $conn->query("select * from student_hobby where student_id='{$_GET['id']}'");
    $oldHobbies = array();
    while ($l = $resultOb1->fetch_assoc()) {
        $oldHobbies[] = $l['hobby_id'];
    }

    $sql = "SELECT
                                    `language`.id,
                                    `language`.`name`,
                                    `language`.date_add,
                                    `language`.last_update
                                    FROM
                                    `language` order by name asc
                                    ";
    $resultOb = $conn->query($sql);
    ?>


                                <label>School :</label>
                                <select name="language_id[]" class="form-control" multiple="true">
    <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo (in_array($row['id'], $oldLanguages)) ? 'selected="selected"' : ''; ?>  > <?php echo $row['name'] ?> </option>
    <?php } ?>
                                </select>
                                <br/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Hobby</label>
    <?php
    $sql = "SELECT
                                    hobby.id,
                                    hobby.`name`,
                                    hobby.date_add,
                                    hobby.last_update
                                    FROM
                                    hobby

                                    ";
    $resultOb = $conn->query($sql);
    ?>
                                <label>School :</label><br/>
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                    <input type="checkbox" id="hobby<?php echo $row['id'] ?>" name="hobby_id[]" <?php echo (in_array($row['id'], $oldHobbies)) ? 'checked="checked"' : ''; ?>  value="<?php echo $row['id'] ?>"> <label for="hobby<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </label>
                                    <br/>
                                <?php } ?>
                                <br/>
                            </div>

                            <button type="submit" name="action" value="update" class="btn btn-default">Update</button>

                        </form>

                    </div>
                </div>
<?php else: ?>

                <div class="row">
                    <div class="col-lg-6" >
                        <form action=""  method="Post" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Address</label>
                                <input type="text" name="address" class="form-control" id="address" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">birth_date</label>
                                <input type="text" name="address" class="form-control" id="birth_date" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">note</label>
                                <textarea name="note" class="form-control" rows="3"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">file</label>
                                <input type="file" name="file" id="fileToUpload">                                
                            </div>


                            <div class="form-group">
                                <label for="exampleInputPassword1">school_id</label>
    <?php
    $sql = "SELECT
                                schools.id as school_id,
                                schools.`name` as school_name,
                                schools.date_add,
                                schools.last_update,
                                schools.address
                                FROM
                                schools
                                order by id desc";
    $resultOb = $conn->query($sql);
    ?>
                                <label>School :</label>
                                <select name="school_id" class="form-control">
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['school_id'] ?>"> <?php echo $row['school_name'] ?> </option>
    <?php } ?>
                                </select>
                                <br/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">note</label><br>
                                <input name="gender" type="radio" value="male" checked="checked"> <label>Male</label> <br>
                                <input name="gender" type="radio" value="female" > <label>Female</label> <br>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Language</label>
    <?php
    $sql = "SELECT
                                    `language`.id,
                                    `language`.`name`,
                                    `language`.date_add,
                                    `language`.last_update
                                    FROM
                                    `language` order by name asc
                                    ";
    $resultOb = $conn->query($sql);
    ?>
                                <label>School :</label>
                                <select name="language_id[]" class="form-control" multiple="true">
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>
    <?php } ?>
                                </select>
                                <br/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Hobby</label>
    <?php
    $sql = "SELECT
                                    hobby.id,
                                    hobby.`name`,
                                    hobby.date_add,
                                    hobby.last_update
                                    FROM
                                    hobby

                                    ";
    $resultOb = $conn->query($sql);
    ?>
                                <label>School :</label><br/>
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                    <input type="checkbox" name="hobby_id[]"  value="<?php echo $row['id'] ?>"> <label> <?php echo $row['name'] ?> </label>
                                    <br/>
                                <?php } ?>
                                <br/>
                            </div>

                            <button type="submit" name="action" value="add" class="btn btn-default">Submit</button>
                        </form>
                    </div>

                </div> 
<?php endif; ?>
            <div class="row">
                <div class="col-lg-6" >
            <?php
            $sql = "SELECT
                 
                         student.id,
                         student.`name`,
                         student.date_birth,
                         student.address,
                         student.date_add,
                        student.last_update,
                        student.school_id,
                        student.photo,
                        schools.`name` as name1
                       
                          FROM student
                        INNER JOIN schools ON student.school_id = schools.id order by id desc";
            $resultOb = $conn->query($sql);
            ?>

                    <table class="table table-striped" style="margin-top:30px;">
                        <tr><th></th><th>Name</th> <th>Address</th> <th>date_birth</th><th>school_name</th><th></th></tr>
                    <?php while ($row = $resultOb->fetch_assoc()) { ?>
                            <tr><td><img src="img/<?php echo $row['photo'] ?>" alt="Smiley face" height="42" width="42"></td><td><?php echo $row['id'] ?></td><td><?php echo $row['name'] ?></td><td><?php echo $row['address'] ?></td><td><?php echo $row['date_birth'] ?></td><td><?php echo $row['name1'] ?></td> <td><a href="?action=edit&id=<?php echo $row['id'] ?>" class="button" >Edit</a></td><td><a onclick="return confirm('Are you sure ?');" href="?action=del&id=<?php echo $row['id'] ?>" class="button" >Delete</a></td></tr>
<?php } ?>
                    </table>
                    <table class="table table-striped">

                    </table>


                </div>
            </div>

        </div>


        <!--/container -->

        <!--IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </body>
</html>