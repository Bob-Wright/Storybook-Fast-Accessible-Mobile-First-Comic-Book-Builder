<?php
/*
 * filename: imgUploader.php
 * this code processes the image files uploaded by the Upload form
 * we got here by an AJAX call from the javascript form handler
*/
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// Include Comic class
require_once("/home/bitnami/includes/ComicImages.class.php");

// set some variables 
//$Comicname = 'Comic1';
// localpath for the image files
$uploadDir = "/home/bitnami/uploads/";
$_SESSION['uploadDir'] = $uploadDir;
$comicsDir = "/home/bitnami/Comics/htdocs/";
// filename for the clean image file 
$cleanImage = 'KleenCImuge.jpg'; 
// data for verbose report
$rindex = 0;
$report = array();
$Errindex = 0;
$ErrReport = array();
$vpb_size_total = 0;
// ***
// process the upload
// ***
////echo '<script> alert("here we are"); </script>';
// see if POST and uploaded file
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!(empty($_POST) && empty($_FILES) && ($_SERVER['CONTENT_LENGTH'] > 0)))) {
	if ((file_exists($_FILES["upload_file"]["tmp_name"])) && (is_uploaded_file($_FILES["upload_file"]["tmp_name"]))) {
	$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
	$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file list
	$vpb_final_location = $uploadDir . $vpb_file_name; //Directory to save file plus the file to be saved
		// move the uploaded file to our folder
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
		$report[$rindex] = "Uploaded Filename: " . $vpb_file_name . "<br>";
		$rindex = $rindex+1;
	$xmlFile = pathinfo($vpb_file_name);
	$fname = $xmlFile['filename'];
	$vpb_file_type = $xmlFile['extension'];
	// check the filetype/extension, filename length, invalid filenames, allowed characters, and minimum-maximum file size
	if (!(preg_match('/jpeg|jpg|gif|png/i', ($xmlFile['extension'])) && ($_SESSION['pageimage'] != ''))) {
		$ErrReport[$Errindex] = "Invalid filetype/extension. ".$vpb_file_name."<br>";$Errindex = $Errindex+1;}
	$vpb_file_nameLen = strlen($fname);
		$report[$rindex] = "Uploaded Filename length: " . $vpb_file_nameLen . "<br>";
		$rindex = $rindex+1;
	if (($vpb_file_nameLen > 255) || ($vpb_file_nameLen = 0)) {
			$ErrReport[$Errindex] = "Invalid filename length.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^(?!^(?:PRN|AUX|CLOCK\$|NUL|CON|COM\d|LPT\d)(?:\..+)?$)(?:\.*?(?!\.))[^\x00-\x1f\\?*:\";|\/<>]+(?<![\s.])$/', $xmlFile['filename']))) {
			$ErrReport[$Errindex] = "Invalid filename.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^([A-Za-z0-9]*[!_\+\.\(\)\s^]?)*$/', $fname))) {
			// removed dashes we use as delimiters from permitted list
			$ErrReport[$Errindex] = "Invalid filename characters.<br>";$Errindex = $Errindex+1;}
	if (preg_match('/\s/', $fname)) {
		$fname = preg_replace("/\s+/", "_", $fname); // convert spaces
		rename($uploadDir.$vpb_file_name, $uploadDir.$fname.'.'.$vpb_file_type);
			$vpb_file_name = $fname.'.'.$vpb_file_type;
			$report[$rindex] = "Replaced spaces: " . $uploadDir.$fname.'.'.$vpb_file_type . "<br>";
			$rindex = $rindex+1;}

	list($width, $height, $type, $attr) = getimagesize($uploadDir.$vpb_file_name);
		$report[$rindex] = "Uploaded File type code: " . $type . "<br>";
		$rindex = $rindex+1;

if (!(($width == 1 && $height == 1) && (($_SESSION['pageimage'] == 'Comic') || ($_SESSION['pageimage'] == 'altImgs')))) { //skip for our special noimage caption only image file
	// 16 Megabytes = 16,777,215 10 Megabytes = 10485760 Bytes, 8 Megabytes = 8388608 Bytes
	// 5 Megabytes = 5,242,880 Bytes, 3 Megabytes = 3,145,728, 2 Megabytes = 2,097,152,
	// 1 Megabytes = 1,048,576, 500 Kbytes = 524,288
   switch ($type)
     {case 1:   //   gif
		$vpb_file_type = 'gif';
        $minW = 120; $minH = 120; $minSize = 1024;
		$maxW = 720; $maxH= 720; $maxSize = 10485760;
        break;
      case 2:   //   jpeg
		$vpb_file_type = 'jpg';
        $minW = 300; $minH = 300; $minSize = 1024;
		$maxW = 1600; $maxH= 1600; $maxSize = 5242880;
        break;
      case 3:  //   png
		$vpb_file_type = 'png';
		if($width = 1 && $height = 1) {
        $minW = 1; $minH = 1; $minSize = 10;
		} else {
        $minW = 300; $minH = 300; $minSize = 1024; }
		$maxW = 1600; $maxH= 1600; $maxSize = 5242880;
        break;
     }
		$report[$rindex] = "Uploaded File type: " . $vpb_file_type . "<br>";
		$rindex = $rindex+1;

	$vpb_file_size = $_FILES["upload_file"]["size"];
			$report[$rindex] = "Uploaded Image file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;
	if (($vpb_file_size < $minSize) || ($vpb_file_size > $maxSize)) {
			// echo "File Size out of range."
			$ErrReport[$Errindex] = "File Size out of range.<br>";$Errindex = $Errindex+1;}

	if ((($width >= $minW) && ($height >= $minH)) || (($width <= $maxW) && ($height <= maxH))) {
		$report[$rindex] = "Image pixel dimensions: " . $width . " wide X " . $height . " high<br>";
		$rindex = $rindex+1;
	} else {
		// echo "File Size out of range."
		$ErrReport[$Errindex] = "File pixel dimensions are out of range " . $width . " wide X " . $height . " high<br>";
		$Errindex = $Errindex+1;
	}

/*
* We save png as jpg images and save jpg images as jpg images and save gif images as gif images
* we save copies of png and jpg and gif images as webp images
*
* Initially we made 3 image sizes for these width breakpoints
* we prefer to downscale from larger to smaller scale,
* but we enlarge images smaller than 1024 to 1200 width
*
* Small (smaller than 577px) we made a 480 edge image
* Medium (577px to 1079px) we made a 720 edge image
* Large (1080px and larger) we made a 1200 edge image
*
* That worked well enough to prompt the addition of two more srcset sizes
* and a readjustment of the breakpoints and sizes to get more granularity
* These values are based upon the Bootstrap breakpoint choices
* breakpoint names	X- Small Small   Medium  Large   X- Large XX- Large
* breakpoints       <576px	≥576px	≥768px	≥992px	≥1200px	≥1400px
* .container		100%	540px	720px	960px	1140px	1320px
* image sizes				576px	768px	992px	1200px	1400px
*
*/
	//$srcname = $uploadDir.$vpb_file_name;
	if($vpb_file_type == 'gif') {
		// imagecreatefromgif doesn't like animations
		//$img = imagecreatefromgif($uploadDir.$vpb_file_name);
		//imagegif($img, $uploadDir.$cleanImage);}
	//exec('gif2webp -q ' . $quality . ' ' . $jpegFileName . ' -o ' . $webpFileName);
	$srcname = $uploadDir.$vpb_file_name;
		$report[$rindex] = "srcname: " . $srcname . "<br>";
		$rindex = $rindex+1;
	$outname = $uploadDir.$fname.'.webp';
		$report[$rindex] = "outname: " . $outname . "<br>";
		$rindex = $rindex+1;
	$g2wcommand = 'gif2webp -q 75 "'.$srcname.'" -o "'.$outname.'"';
		$report[$rindex] = "g2wcommand: " . $g2wcommand . "<br>";
		$rindex = $rindex+1;
	exec($g2wcommand);
	// now have a gif and a webp of uploaded gif image
	}
	if($vpb_file_type == 'jpg'){ // regenerate jpgs
		$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		imagejpeg($img, $uploadDir.$vpb_file_name, 100);
		//imagewebp($uploadDir.$vpb_file_name, $uploadDir.$ifilename.'.webp', 100);
	// now have a recreated jpg instead of uploaded jpg image
	}
	if($vpb_file_type == 'png'){ // regenerate pngs as jpgs
		$img = imagecreatefrompng($uploadDir.$vpb_file_name);
		imageAlphaBlending($img, true);
		imageSaveAlpha($img, true);
		//imagepng($img, $uploadDir.$vpb_file_name);
		imagejpeg($img, $uploadDir.$fname.'.jpg', 100); // now our png is also a jpg
		rm($uploadDir.$fname.'.png');
		$vpb_file_name = $fname.'.jpg';
		$vpb_file_type = 'jpg';
		$report[$rindex] = "Saved ".$fname." png file as jpg<br>";
		$rindex = $rindex+1;
	// now have a jpg instead of uploaded png image
	}
	 // now have GIF and webp for uploaded gif, or jpg and webp for uploaded jpg or png

	// ---------------------------
	// check the image dimensions if not OG or LOGO image
	if(!((($_SESSION['pageimage']) == 'LOGO') || (($_SESSION['pageimage']) == 'OGIMG')) || ($vpb_file_type == 'gif')) {
		if(($width < 1024) && ($height < 1024)) {
			$ErrReport[$Errindex] = "Image Dimension out of range. One of h or w must be >= 1024: " . $width . " w X " . $height . " h<br>";
			$Errindex = $Errindex+1;
		}
	}
	if(($_SESSION['pageimage'] == 'CARD') && !($vpb_file_type == 'gif')) { // scale non GIF card image
		//$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		$nuwidth = 768; $nuheight = (768/$width)*$height;
		$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
		//$nuimg = $img;
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'.jpg', 100);
		$csrcname = $fname;
		$csrcfile = $fname .'.jpg';
		$csrc = $uploadDir . $csrcfile;
			$report[$rindex] = "csrcfile: " . $csrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "CARD Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$csrcname.'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$csrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a medium size jpg and a webp of CARDimage
	}

if(!((($_SESSION['pageimage']) == 'LOGO') || (($_SESSION['pageimage']) == 'OGIMG') || ($_SESSION['pageimage'] == 'CARD') || ($vpb_file_type == 'gif'))) { // scale other non GIF images
	//  breakpoint image widths 576px	768px	992px	1200px	1400px
	//  container widths 540px	720px	960px	1140px	1320px
	//  create jpg and webp for each breakpoint size
		if($width <> 1400) { // scale the image to 1200 width
			// can use -1 for imagescale height maintains aspect ratio
			//if($width >= $height) {$nuwidth = 1200; $nuheight = -1;}
			$nuwidth = 1400; $nuheight = (1400/$width)*$height;
			//if($height > $width) {$nuwidth = (1200/$height)*$width; $nuheight = 1200;}
			$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
			//$nuimg = $img;
		} else { // already 1200 pixels wide
			$nuwidth = 1400; $nuheight = $height;
		}
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'-X-' . $tagheight .'.jpg', 100);
		$Xsrcname = $fname.'-X-' . $tagheight;
		$Xsrcfile = $fname.'-X-' . $tagheight .'.jpg';
		$Xsrc = $uploadDir . $Xsrcfile;
			$report[$rindex] = "Xsrcfile: " . $Xsrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "XX-Large Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$Xsrcname.'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$Xsrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a jpg and a webp at 1320 width of uploaded image

		//$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		$nuwidth = 1200; $nuheight = (1200/$width)*$height;
		$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
		//$nuimg = $img;
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'-x-' . $tagheight .'.jpg', 100);
		$xsrcname = $fname.'-x-' . $tagheight;
		$xsrcfile = $fname.'-x-' . $tagheight .'.jpg';
		$xsrc = $uploadDir . $xsrcfile;
			$report[$rindex] = "xsrcfile: " . $xsrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "X-Large Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$xsrcname.'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$xsrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a jpg and a webp of extra-large size image

		//$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		$nuwidth = 992; $nuheight = (992/$width)*$height;
		$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
		//$nuimg = $img;
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'-l-' . $tagheight .'.jpg', 100);
		$lsrcname = $fname.'-l-' . $tagheight;
		$lsrcfile = $fname.'-l-' . $tagheight .'.jpg';
		$lsrc = $uploadDir . $lsrcfile;
			$report[$rindex] = "lsrcname: " . $lsrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "Large Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$lsrcname .'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$lsrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a jpg and a webp of large size image

		//$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		$nuwidth = 768; $nuheight = (768/$width)*$height;
		$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
		//$nuimg = $img;
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'-m-' . $tagheight .'.jpg', 100);
		$msrcname = $fname.'-m-' . $tagheight;
		$msrcfile = $fname.'-m-' . $tagheight .'.jpg';
		$msrc = $uploadDir . $msrcfile;
			$report[$rindex] = "msrcfile: " . $msrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "Medium Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$msrcname.'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$msrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a jpg and a webp of medium size image

		//$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
		$nuwidth = 576; $nuheight = (576/$width)*$height;
		$nuimg = imagescale($img, $nuwidth, $nuheight, IMG_BICUBIC);
		//$nuimg = $img;
			$tagheight = $nuheight;
			if(($nuheight >= 100) && ($nuheight <= 999)) {$tagheight = '0' . $nuheight;}
			if($nuheight <= 99) {$tagheight = '00' . $nuheight;}
		imagejpeg($nuimg, $uploadDir.$fname.'-s-' . $tagheight .'.jpg', 100);
		$ssrcname = $fname.'-s-' . $tagheight;
		$ssrcfile = $fname.'-s-' . $tagheight .'.jpg';
		$ssrc = $uploadDir . $ssrcfile;
			$report[$rindex] = "ssrcname: " . $ssrcfile . "<br>";
			$rindex = $rindex+1;
			$report[$rindex] = "Small Image pixel dimensions: " . $nuwidth . " wide X " . $nuheight . " high<br>";
			$rindex = $rindex+1;
		$outname = $uploadDir.$ssrcname .'.webp';
			$report[$rindex] = "outname: " . $outname . "<br>";
			$rindex = $rindex+1;
		$cwcommand = 'cwebp -q 75 "'.$ssrc.'" -o "'.$outname.'"';
			$report[$rindex] = "cwcommand: " . $cwcommand . "<br>";
			$rindex = $rindex+1;
		exec($cwcommand);
	// now have a jpg and a webp of small size image

if (isset($img)) { imagedestroy ($img);}
}
} // end image not 1 x 1

	// ---------------------------------
	// if not a LOGO or OG image now have
	// set of GIF and webp of uploaded gifs, or set of jpg and webp of uploaded png or jpg
	// some info not presently used
	$tmp = file_get_contents($uploadDir.$vpb_file_name);
	$imageHash = hash('sha256', $tmp);
			$report[$rindex] = "Clean Image file hash: " . $imageHash . "<br>";
			$rindex = $rindex+1;
	$imageKey = hash('sha256', $tmp . strval(time()));
			$report[$rindex] = "Image file key: " . $imageKey . "<br>";
			$rindex = $rindex+1;
	$vpb_file_size = strlen($tmp);
			$report[$rindex] = "Clean Image file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;
	// have six categories of images
	// BKGND LOGO OGIMG CARD Comic altImg
	$Comicname = $_SESSION['Comicname'];
	$pageimage = $_SESSION['pageimage']; // this image category
	// destination setup
	$comicsDir = '/home/bitnami/Comics/htdocs/';
	if(!(is_dir($comicsDir.$Comicname))) {
		mkdir($comicsDir.$Comicname, 0775, true);}
	$targetDir = $comicsDir.$Comicname.'/';

	//logo images
if(($_SESSION['pageimage']) == 'LOGO'){ //LOGO images not processed much
		$logoCount = $_SESSION['logoCount'];
		$logoCount = $logoCount + 1;
		$_SESSION['logoCount'] = $logoCount;
		$logoimgfile = $Comicname.$pageimage.$logoCount;
		rename($uploadDir.$vpb_file_name, $targetDir.$logoimgfile.'.'.$vpb_file_type); //leave filetype, might be GIF
			$report[$rindex] = "Target file: " . $targetDir.$logoimgfile.".".$vpb_file_type. "<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$fname.'.webp', $targetDir.$logoimgfile.'.webp');
			$report[$rindex] = "Target file: " . $targetDir.$logoimgfile.".webp<br>";
			$rindex = $rindex+1;
			// write the Comic logo file list for use if we get multiple logo files
		$response = file_put_contents($targetDir.$Comicname.'.LL', $logoimgfile, FILE_APPEND);
		if ($response == FALSE) {
			$ErrReport[$Errindex] = "Failed to write logolist file.<br>";$Errindex = $Errindex+1;}
	$Comicname = $Comicname.$pageimage;
}
	// an OG Meta Tag image for social media shares
if(($_SESSION['pageimage']) == 'OGIMG'){ //OG Meta tag Image not processed much
		$ogimgfile = $Comicname.$pageimage;
		//rename($uploadDir.$vpb_file_name, '/home/bitnami/Comics/htdocs/'.$ogimgfile.'.jpg');
		rename($uploadDir.$vpb_file_name, $comicsDir.$ogimgfile.'.jpg');
			$report[$rindex] = "Target file: " .$comicsDir.$ogimgfile . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$fname.'.webp', $comicsDir.$ogimgfile.'.webp');
			$report[$rindex] = "Target file: " .$comicsDir.$ogimgfile . ".webp<br>";
			$rindex = $rindex+1;
	$Comicname = $Comicname.$pageimage;
}
	// page background image
if(($_SESSION['pageimage']) == 'BKGND'){ //BKGND or background image
		//$Comicname = $_SESSION['Comicname'];
		$bkImgFname = $Comicname.$pageimage;
		if($vpb_file_type == 'gif') {
			rename($uploadDir.$fname.'.gif', $targetDir.$bkImgFname.'.gif');
			$report[$rindex] = "Target file: " . $targetDir.$bkImgFname . ".gif<br>";
			$rindex = $rindex+1;
			rename($uploadDir.$fname.'.webp', $targetDir.$bkImgFname.'.webp');
			$report[$rindex] = "Target file: " . $targetDir.$bkImgFname . ".webp<br>";
			$rindex = $rindex+1;
		}
		if($vpb_file_type == 'jpg') {
		rename($uploadDir.$Xsrcname.'.jpg', $targetDir.$bkImgFname.'-X.jpg');
			$report[$rindex] = "Target file X: " . $targetDir.$bkImgFname . "-X.jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$xsrcname.'.jpg', $targetDir.$bkImgFname.'-x.jpg');
			$report[$rindex] = "Target file x: " . $targetDir.$bkImgFname . "-x.jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$lsrcname.'.jpg', $targetDir.$bkImgFname.'-l.jpg');
			$report[$rindex] = "Target file L: " . $targetDir.$bkImgFname . "-l.jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$msrcname.'.jpg', $targetDir.$bkImgFname.'-m.jpg');
			$report[$rindex] = "Target file M: " . $targetDir.$bkImgFname . "-m.jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$ssrcname.'.jpg', $targetDir.$bkImgFname.'-s.jpg');
			$report[$rindex] = "Target file S: " . $targetDir.$bkImgFname . "-s.jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$Xsrcname.'.webp', $targetDir.$bkImgFname.'-X.webp');
			$report[$rindex] = "Target file X: " . $targetDir.$bkImgFname . "-X.webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$xsrcname.'.webp', $targetDir.$bkImgFname.'-x.webp');
			$report[$rindex] = "Target file x: " . $targetDir.$bkImgFname . "-x.webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$lsrcname.'.webp', $targetDir.$bkImgFname.'-l.webp');
			$report[$rindex] = "Target file L: " . $targetDir.$bkImgFname . "-l.webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$msrcname.'.webp', $targetDir.$bkImgFname.'-m.webp');
			$report[$rindex] = "Target file M: " . $targetDir.$bkImgFname . "-m.webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$ssrcname.'.webp', $targetDir.$bkImgFname.'-s.webp');
			$report[$rindex] = "Target file S: " . $targetDir.$bkImgFname . "-s.webp<br>";
			$rindex = $rindex+1;
		}
	$_SESSION['bkgndImage'] = $bkImgFname.'.webp'; // default background
	$Comicname = $Comicname.$pageimage;
}
	// a Gallery Card image
if(($_SESSION['pageimage']) == 'CARD'){ //gallery card Image
	$Comicname = $_SESSION['Comicname'];
		$cardImgFname = $Comicname.$pageimage;
		if($vpb_file_type == 'gif') {
			rename($uploadDir.$fname.'.gif', $targetDir.$cardImgFname.'.gif');
			$report[$rindex] = "Target file: " .$targetDir.$cardImgFname . ".gif<br>";
			$rindex = $rindex+1;
			rename($uploadDir.$fname.'.webp', $targetDir.$cardImgFname.'.webp');
			$report[$rindex] = "Target file: " .$targetDir.$cardImgFname . ".webp<br>";
			$rindex = $rindex+1;
		}
		if($vpb_file_type == 'jpg') {
		rename($uploadDir.$csrcname.'.jpg', $targetDir.$cardImgFname.'.jpg');
			$report[$rindex] = "Target file: " . $targetDir.$cardImgFname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$csrcname.'.webp', $targetDir.$cardImgFname.'.webp');
			$report[$rindex] = "Target file: " . $targetDir.$cardImgFname . ".webp<br>";
			$rindex = $rindex+1;
		}
	$_SESSION['cardImage'] = $cardImgFname.'.webp'; // default
	$Comicname = $Comicname.$pageimage;
}
	// Comic image collection
if(($_SESSION['pageimage']) == 'Comic'){ //images for the Comic pages
	$Comicname = $_SESSION['Comicname'];
		if($width == 1 && $height == 1) { // special 1x1 for caption only panel
			rename($uploadDir.$vpb_file_name, $comicsDir.$Comicname.'/'.$vpb_file_name);
			$report[$rindex] = "Target file: " . $comicsDir.$Comicname.'/'.$vpb_file_name;
			$rindex = $rindex+1;
		} else {
		if($vpb_file_type == 'gif') {
			if(($height >= 100) && ($height <= 999)) {$height = '0' . $height;}
			if($height <= 99) {$height = '00' . $height;}
			if(($width >= 100) && ($width <= 999)) {$width = '0' . $width;}
			if($width <= 99) {$width = '00' . $width;}

			rename($uploadDir.$fname.'.gif', $comicsDir.$Comicname.'/'.$fname.'-w'.$width.'-h'.$height.'.gif');
			$report[$rindex] = "Target file: " . $comicsDir.$Comicname.'/'.$fname.'-w'.$width.'-h'.$height.".gif<br>";
			$rindex = $rindex+1;
			rename($uploadDir.$fname.'.webp', $comicsDir.$Comicname.'/'.$fname.'-w'.$width.'-h'.$height.'.webp');
			$report[$rindex] = "Target file: " . $comicsDir.$Comicname.'/'.$fname.'-w'.$width.'-h'.$height.".webp<br>";
			$rindex = $rindex+1;
		}
		if($vpb_file_type == 'jpg') {
		rename($uploadDir.$Xsrcname.'.jpg', $comicsDir.$Comicname.'/'.$Xsrcname.'.jpg');
			$report[$rindex] = "Target file X: " . $comicsDir.$Comicname.'/'.$Xsrcname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$xsrcname.'.jpg', $comicsDir.$Comicname.'/'.$xsrcname.'.jpg');
			$report[$rindex] = "Target file x: " . $comicsDir.$Comicname.'/'.$xsrcname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$lsrcname.'.jpg', $comicsDir.$Comicname.'/'.$lsrcname.'.jpg');
			$report[$rindex] = "Target file L: " . $comicsDir.$Comicname.'/'.$lsrcname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$msrcname.'.jpg', $comicsDir.$Comicname.'/'.$msrcname.'.jpg');
			$report[$rindex] = "Target file M: " . $comicsDir.$Comicname.'/'.$msrcname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$ssrcname.'.jpg', $comicsDir.$Comicname.'/'.$ssrcname.'.jpg');
			$report[$rindex] = "Target file S: " . $comicsDir.$Comicname.'/'.$ssrcname . ".jpg<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$Xsrcname.'.webp', $comicsDir.$Comicname.'/'.$Xsrcname.'.webp');
			$report[$rindex] = "Target file X: " . $comicsDir.$Comicname.'/'.$Xsrcname . ".webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$xsrcname.'.webp', $comicsDir.$Comicname.'/'.$xsrcname.'.webp');
			$report[$rindex] = "Target file x: " . $comicsDir.$Comicname.'/'.$xsrcname . ".webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$lsrcname.'.webp', $comicsDir.$Comicname.'/'.$lsrcname.'.webp');
			$report[$rindex] = "Target file L: " . $comicsDir.$Comicname.'/'.$lsrcname . ".webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$msrcname.'.webp', $comicsDir.$Comicname.'/'.$msrcname.'.webp');
			$report[$rindex] = "Target file M: " . $comicsDir.$Comicname.'/'.$msrcname . ".webp<br>";
			$rindex = $rindex+1;
		rename($uploadDir.$ssrcname.'.webp', $comicsDir.$Comicname.'/'.$ssrcname.'.webp');
			$report[$rindex] = "Target file S: " . $comicsDir.$Comicname.'/'.$ssrcname . ".webp<br>";
			$rindex = $rindex+1;
		}
		}
	$_SESSION['comicImage'] = $fname.'.webp'; // default
	$Comicname = $Comicname;
}
	// ALTIMG image collection
if(($_SESSION['pageimage']) == 'altImgs'){ //alt images for the Comic
	$Comicname = $_SESSION['Comicname'];
	// destination setup
	if(!(is_dir($comicsDir.$Comicname.'/'.$pageimage))) {
		mkdir($comicsDir.$Comicname.'/'.$pageimage, 0775, true);}
	$targetDir = $comicsDir.$Comicname.'/'.$pageimage.'/';

	if($width == 1 && $height == 1) { // special 1x1 for caption only panel
		rename($uploadDir.$vpb_file_name, $targetDir.$vpb_file_name);
		$report[$rindex] = "Target file: " . $targetDir.$vpb_file_name;
		$rindex = $rindex+1;
	} else {
	if($vpb_file_type == 'gif') {
		rename($uploadDir.$fname.'.gif', $targetDir.$fname.'-'.$width.'-'.$height.'.gif');
		$report[$rindex] = "Target file: " . $targetDir.$fname.'-'.$width.'-'.$height.".gif<br>";
		$rindex = $rindex+1;
		rename($uploadDir.$fname.'.webp', $targetDir.$fname.'-'.$width.'-'.$height.'.webp');
		$report[$rindex] = "Target file: " . $targetDir.$fname.'-'.$width.'-'.$height.".webp<br>";
		$rindex = $rindex+1;
	}
	if($vpb_file_type == 'jpg') {
	rename($uploadDir.$Xsrcname.'.jpg', $targetDir.$Xsrcname.'.jpg');
		$report[$rindex] = "Target file X: " . $targetDir.$Xsrcname . ".jpg<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$xsrcname.'.jpg', $targetDir.$xsrcname.'.jpg');
		$report[$rindex] = "Target file : " . $targetDir.$xsrcname . ".jpg<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$lsrcname.'.jpg', $targetDir.$lsrcname.'.jpg');
		$report[$rindex] = "Target file L: " . $targetDir.$lsrcname . ".jpg<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$msrcname.'.jpg', $targetDir.$msrcname.'.jpg');
		$report[$rindex] = "Target file M: " . $targetDir.$msrcname . ".jpg<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$ssrcname.'.jpg', $targetDir.$ssrcname.'.jpg');
		$report[$rindex] = "Target file S: " . $targetDir.$ssrcname . ".jpg<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$Xsrcname.'.webp', $targetDir.$Xsrcname.'.webp');
		$report[$rindex] = "Target file X: " . $targetDir.$Xsrcname . ".webp<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$xsrcname.'.webp', $targetDir.$xsrcname.'.webp');
		$report[$rindex] = "Target file x: " . $targetDir.$xsrcname . ".webp<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$lsrcname.'.webp', $targetDir.$lsrcname.'.webp');
		$report[$rindex] = "Target file L: " . $targetDir.$lsrcname . ".webp<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$msrcname.'.webp', $targetDir.$msrcname.'.webp');
		$report[$rindex] = "Target file M: " . $targetDir.$msrcname . ".webp<br>";
		$rindex = $rindex+1;
	rename($uploadDir.$ssrcname.'.webp', $targetDir.$ssrcname.'.webp');
		$report[$rindex] = "Target file S: " . $targetDir.$ssrcname . ".webp<br>";
		$rindex = $rindex+1;
	}
	}
	$Comicname = $Comicname.$pageimage;
}

	  $objects = scandir($uploadDir);
	  foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
		  unlink($uploadDir."/".$object);}
	  }
	  //reset($objects);
	$_SESSION['report'] = $report;
	$_SESSION['ErrReport'] = $ErrReport;
	//$_SESSION['Comicname'] = $Comicname;

	if(empty($ErrReport)) { 
    // set up the Comic image data array
	$ComicData = array();
    $ComicData['comic_name']   = $Comicname;
    $ComicData['oauth_id'] = $_SESSION['oauth_id'];
    $ComicData['image_hash'] = $imageHash;
    $ComicData['image_key']	 = $imageKey;
    $ComicData['filename']   = $vpb_file_name;
    $ComicData['filetype']   = $vpb_file_type;
    $ComicData['width']   	= $width;
    $ComicData['height']   = $height;
    // Store image data in the session
    $_SESSION['ComicData'] = $ComicData;
	//if(!(($_SESSION['pageimage']) == 'altimgs')) { //alt images don't go in database
    // Initialize Image Comic class
    $comic = new ComicImages();
	// Insert image data to the database
	$Data = $comic->insertComicImages($ComicData);
	//if(file_exists($uploadDir.$vpb_file_name)) {
	//unlink($uploadDir.$vpb_file_name);}
	//rmdircontent($uploadDir);
	}
	if(empty($ErrReport)) { 
		//Display the file id
		echo $vpb_file_id;
	} else {
		//Display general system error
		echo 'general_system_error';
	}

}; // got an upload
};
}; // end POST
return;
?>