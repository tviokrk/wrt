<?php

$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];



include('s3_config.php');
//Rename image name.
echo $bucket;
echo "1";
if($s3->putObjectFile($tmp, $bucket , $name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful.";
echo "2";
}
else
$msg = "S3 Upload Fail.";
echo "9";

}
?>

//HTML Code
<form action="upload_test.php" method='post' enctype="multipart/form-data">
Upload image file here
<input type='file' name='file'/> <input type='submit' value='Upload Image'/>
<?php echo $msg; ?>
</form>
