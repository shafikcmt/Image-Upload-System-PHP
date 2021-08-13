<?php 
include 'header.php'; 
include 'lib/config.php';
include 'lib/Database.php';
$db = new Database();
?>
      
        <div class="panel-body">
            <div style="width:600px; margin:0 auto;">
            <?php
                 if($_SERVER['REQUEST_METHOD']== "POST") {
                     $permited = array('jpg','jpeg','png','gif');
                     $file_name = $_FILES['image']['name'];
                     $file_size = $_FILES['image']['size'];
                     $file_temp = $_FILES['image']['tmp_name'];
                     $folder = "uploads/";
                     move_uploaded_file($file_temp,$folder.$file_name);
                     $query = "INSERT INTO tbl_image(image )VALUES('$file_name')";
                     $insert_rows = $db->insert($query);
                     if($insert_rows){
                         echo "<div class='alert alert-success'>Image Inserted Successfully</div>";
                     }else{
                         echo "<div class='alert alert-danger'>Image not Inserted !</div>";
                     }
                    } 
                     ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="img">Select Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <input class="btn btn-primary" type="submit" name="submit" value="Upload">
                </form>
                
                
            </div>
              
        </div>
        
<?php 
include 'footer.php'; 
?>