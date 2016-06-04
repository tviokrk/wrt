<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
	<title>Prosty skrypt galerii zdjęć z efektem Highslide</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
	<script type="text/javascript" src="javascript/highslide-with-gallery.js"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<script type="text/javascript">
	hs.graphicsDir = 'javascript/images/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	//hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>

</head>
<body>

<div id="galeria">
<ul>
<?php
$file_name = "./upload/lista.txt";
$link = file($file_name);
for ($i=0; $i<count($link); $i++)
{
 //echo $link;
 echo '<li><a href="'.$link[$i].'" class="highslide" onclick="return hs.expand(this)"><img width="200" height="133" src="'.$link[$i].'" /></a></li>';
}


?>
</ul>
</div>

</body>
</html>
