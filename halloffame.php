<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in(); ?>
<?php //check_supperuser();   ?>

<?php
include_once("includes/form_functions.php");
if (array_key_exists('chprofile', $_POST)) {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $companyname = $_POST['companyname'];
    $certification = $_POST['certification'];
    /* if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
      echo "<h1>" . "File ". $_FILES['pic']['name'] ." uploaded successfully." . "</h1>";
      echo "<h2>Displaying contents:</h2>";
      readfile($_FILES['filename']['tmp_name']);
      } */
    $newFileName = '';
    if (isset($_FILES['pic']['tmp_name']) && $_FILES['pic']['tmp_name'] != '') {
        $newFileName = mt_rand(1000, 9999) . $_FILES['pic']['name'];
        move_uploaded_file($_FILES['pic']['tmp_name'], "images/halloffame/" . $newFileName);
    }

    $sql = "INSERT INTO halloffame (name,title,companyname,certification,image) VALUES ('" . $name . "','" . $title . "','" . $companyname . "','" . $certification . "','" . $newFileName . "')";
    $result1 = mysqli_query($connection,$sql);
    if(!$result1){
        print_r(mysqli_error($connection));
        exit;
    }
    $user_id = mysqli_insert_id($connection);
}
if (array_key_exists('uploadcsvfile', $_POST)) {
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        //This is our limit file type condition
        if (!(end(explode('.', $_FILES['file']['name'])) == 'csv')) {
            echo "Please upload CSV file.";
            exit;
        }
        $target = "upload/";
        $target = $target . basename( $_FILES['file']['name']) ;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            //$message = "The file " . basename($_FILES['file']['name']) . " has been uploaded <br/>";
            $row = 1;
            if (($handle = fopen($target, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    //echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;
                    $sql = "INSERT INTO halloffame (name,title,companyname,certification,image) VALUES ('" . $data[0] . "','" . $data[1] . "','" . $data[2] . "','" .$data[3] . "','')";
                    $result = mysqli_query($connection,$sql);
                    if(!$result){
                        echo "Error occurred while uploading".mysqli_error($connection);
                        exit;
                    }
                }
            }
        }
    }
}
?> 

<?php include('includes/header.php'); ?>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Add Hall of Fame</a></li>
        <li><a href="#tabs-2">Upload CSV</a></li>
    </ul>
    <div id="tabs-1">
        <h3>Add a Hall of Fame</h3>
        <div>
            <form name="hofform" method="post" action="" enctype="multipart/form-data">
                <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                        <th width="124">Name</th>  <td width="168"><input name="name" type="text" class="textfield" id="name" value=""/></td>
                    </tr>

                    <tr>
                        <th>Title</th>      <td><input name="title" type="text" class="textfield" id="title" value=""/></td>
                    </tr>
                    <tr>
                        <th>Company Name</th>        <td><input name="companyname" type="text" class="textfield" id="companyname" value=""/></td>
                    </tr>
                    <tr>
                        <th width="124">Certification</th>  <td width="168"><input name="certification" type="text" class="textfield" id="certification" value=""/></td>
                    </tr>
                    <tr>
                        <th width="200">Upload Picture</th>  <td width="168"><input name="pic" type="file" class="textfield" id="pic" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td>
                    </tr>
                </table>
                <input type="hidden" name="chprofile" value="1"/>
            </form>

        </div>
    </div>
    <div id="tabs-2">
        <h3>Upload List of Hall of Fames</h3>
        <div>
            <form name="hofformfile" method="post" action="" enctype="multipart/form-data">
                <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                        <th width="124">Upload CSV</th>  <td width="168"><input name="file" type="file" class="textfield" id="file" value=""/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><a href="images/sample.csv" style="margin-right: 35px;">Sample file</a><input type="submit" name="submit" value="Upload CSV Data" /></td>
                    </tr>
                </table>
                <input type="hidden" name="uploadcsvfile" value="1"/>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>