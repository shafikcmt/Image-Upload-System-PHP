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
                     $div = explode('.',$file_name);
                     $file_ext = strtolower(end($div));
                     $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
                     $uploaded_image = "uploads/".$unique_image;
                     if(empty($file_name)){
                        echo "<div class='alert alert-success'>Please Select any Image</div>";
                    }elseif($file_size>1048567){
                        echo "<div class='alert alert-success'>Image size should be less than 1kb.</div>";
                    }elseif(in_array($file_ext,$permited) === false){
                         echo "<div class='alert alert-success'>You can upload only:-".implode(', ',$permited)."</div>";
                    }else{
                     move_uploaded_file($file_temp,$uploaded_image);
                     $query = "INSERT INTO tbl_image(image )VALUES('$uploaded_image')";
                     $insert_rows = $db->insert($query);
                     if($insert_rows){
                         echo "<div class='alert alert-success'>Image Inserted Successfully</div>";
                     }else{
                         echo "<div class='alert alert-danger'>Image not Inserted !</div>";
                     }
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