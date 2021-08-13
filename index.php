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
                 <br>
                  <br>
                      <div class="row">
                       <div height="100px" class="col-md-4">
                         
                       </div>
                   </div>
                <table class="table">
                    <tr>
                        <th>Serial</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if(isset($_GET['del'])){
                        $id = $_GET['del'];
                        
                        
                         $getquery = "SELECT * FROM tbl_image WHERE id='$id'";
                         $getimg = $db->select($getquery);
                        if($getimg){
                           while($imgdata = $getimg->fetch_assoc()){
                            $delimg = $imgdata['image'];
                             unlink($delimg);  
                        }
                        
                    }
                    $query = "DELETE FROM tbl_image WHERE id ='$id'";
                    $imgDelete = $db->delete($query);
                    if($imgDelete){
                         echo "<div class='alert alert-success'>Image Deleted Successfully</div>";
                     }else{
                         echo "<div class='alert alert-danger'>Image not Deleted !</div>";
                     }
                    }
                    ?>
                <?php
                   $query = "SELECT * FROM tbl_image";
                   $getImage = $db->select($query);
                   if($getImage){
                       $i=0;
                       while($result = $getImage->fetch_assoc()){
                           $i++;
                   ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><img height="40px" width="50px;"  class="img-responsive" src="<?php echo $result['image']; ?>" ></td>
                        <td>
                            <a class="btn btn-primary" href="?del=<?php echo $result['id']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php }} ?>
                </table>
            </div>
              
        </div>
        
<?php 
include 'footer.php'; 
?>