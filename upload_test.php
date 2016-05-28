<?php

$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);

if(strlen($name) > 0)
{
// File format validation
if(in_array($ext,$valid_formats))
{
// File size validation
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name.
$actual_image_name = time().".".$ext;
echo "1";
if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful.";
$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
echo "<img src='$s3file'/>";
echo 'S3 File URL:'.$s3file;
echo "2";
}
else
$msg = "S3 Upload Fail.";
echo "9";
}
else
$msg = "Image size Max 1 MB";
echo "9";
}
else
$msg = "Invalid file, please upload image file.";
echo "9";
}
else
$msg = "Please select image file.";
echo "9";
}
?>

//HTML Code
<form action="" method='post' enctype="multipart/form-data">
Upload image file here
<input type='file' name='file'/> <input type='submit' value='Upload Image'/>
<?php echo $msg; ?>
</form>
