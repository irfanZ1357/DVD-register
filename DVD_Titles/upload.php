<?php 
// Include the database configuration file  
require_once '../db_connect.php'; 
 
// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 

            $asin = $_POST['asin'];
            $title = $_POST['title'];
            $price = $_POST['price'];

            $sql = "INSERT INTO dvdtitles (asin, title, price, image) " . 
                    "VALUES ('$asin', '$title', $price, '$imgContent')";

            $query = $connection->query($sql) or die ("Problem in storing the new title"); 
         
            // Insert image content into database 
            ?>
            <script language="JavaScript">document.location="dvdTitles.php"</script>
             
             <?php
            if($insert){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>