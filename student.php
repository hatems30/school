<?php
$name = $_REQUEST['name'];
$address = $_REQUEST['address'];
$birth_of_data = $_REQUEST['birth_of_data'];
$school_id = $_REQUEST['school'];
//echo $school_id ;

$conn = new mysqli('localhost', 'root', '', 'schools');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['action'] == 'add') {

    if (empty($_POST['name'])) {
        $error = " empty name";
    } else {

        $sql = "INSERT INTO students (name,address,birth_of_data,school_id,date_add,last_update)
VALUES ('" . $_REQUEST['name'] . "','" . $_REQUEST['address'] . "','" . $_REQUEST['birth_of_data'] . "','" . $_REQUEST['school'] . "','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "')";

        $sucess = '';
        $error = '';
        if ($conn->query($sql) === TRUE) {
            $sucess = "New record created successfully";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
if ($_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $birth_of_data = $_POST['birth_of_data'];
    $school_id = $_POST['school'];

    $sqll = "UPDATE students SET name='" . $name . "', address='" . $address . "',birth_of_data='".$birth_of_data."',school_id='".$school_id."' WHERE id=$id";
    //echo $sqll . "<br>";
    if ($conn->query($sqll) === TRUE) {
        $sucess = "Record updated successfully";
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
if ($_GET['action'] == 'del') {

    $iddd = $_GET['id'];

    $sql = " DELETE FROM students WHERE id=$iddd";
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
        <meta http-equiv="X-UA-Compatible" content="IE=e dge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Navbar Template for Bootstrap</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="navbar.css" rel="stylesheet">
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
            <?php ?>
            
            
            
            
            
            
            
            
            
            
            
            
            <?php
            if ($_GET['action'] == 'edit'):

                $sql = "SELECT
                            students.id,
                            students.`name`,
                            students.address,
                            students.birth_of_data,
                            students.school_id,
                            students.date_add,
                            students.last_update
                            FROM
                            students where id ='{$_GET['id']}'
                            order by id desc";
                $resultOb = $conn->query($sql);

                $row = $resultOb->fetch_assoc();
                ?>

                <div class="row">
                    <div class="col-lg-6" >
                        <form action="student.php"  method="Post" >
                            <input type="text" name="id" class="form-control" id="name" value="<?php echo $row['id'] ?>" placeholder="">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?php echo $row['name'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Address</label>
                                <input type="text" name="address" class="form-control" id="address" value="<?php echo $row['address'] ?>" placeholder="">
                            </div>
                               <div class="form-group">
                                <label for="exampleInputPassword1">Birth Date :</label>
                                <input type="text" name="birth_of_data" class="form-control" id="address" value="<?php echo $row['birth_of_data'] ?>" placeholder="">
                            </div>
<!--                            <div class="form-group">
                                <label for="exampleInputPassword1">School_id:</label>
                                <input type="text" name="school_id" class="form-control" id="address" value="<?php echo $row['school_id'] ?>" placeholder="">
                            </div>-->
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
                            <select name="school" class="form-control">
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['school_id'] ?>"> <?php echo $row['school_name'] ?> </option>
                                <?php } ?>
                            </select>
                            

                            <button type="submit" name="action" value="update" class="btn btn-default">Update</button>
                        </form>
                    </div>

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-6" >
                        <form action=""  method="Post" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Your Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Address</label>
                                <input type="text" name="address" class="form-control" id="address" placeholder="Enter Your Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Birth Data :</label>
                                <input type="date" name="birth_of_data" class="form-control" id="birth_of_data" placeholder="">
                            </div>
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
                            <select name="school" class="form-control">
                                <?php while ($row = $resultOb->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['school_id'] ?>"> <?php echo $row['school_name'] ?> </option>
                                <?php } ?>
                            </select>

                            <button type="submit" name="action" value="add" class="btn btn-default">Submit</button>
                        </form>
                    </div>

                </div>  
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-6" >
                    <?php
                    $sql = "SELECT
                            students.id,
                            students.`name`,
                            students.address,
                            students.birth_of_data,
                            students.school_id,
                            students.date_add,
                            students.last_update
                            FROM
                            students
                            order by id desc";
                    $resultOb = $conn->query($sql);
                    ?>

                    <table class="table table-striped" style="margin-top:30px;">
                        <tr><th>Id</th><th>Name</th> <th>Address</th> <th>Birth Date</th><th>School Id</th><th>Edit</th><th>Delete</th></tr>
                        <?php while ($row = $resultOb->fetch_assoc()) { ?>
                            <tr><td><?php echo $row['id'] ?></td><td><?php echo $row['name'] ?></td><td><?php echo $row['address'] ?></td> <td><?php echo $row['birth_of_data'] ?></td><td><?php echo $row['school_id'] ?></td><td><a href="?action=edit&id=<?php echo $row['id'] ?>" class="button" >Edit</a></td><td><a onclick="return confirm('Are you sure ?');" href="?action=del&id=<?php echo $row['id'] ?>" class="button" >Delete</a></td></tr>
                        <?php } ?>
                    </table>

                    <table class="table table-striped">

                    </table>
                </div>

            </div>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    </body>
</html>
