<?php
/*
 * filename: saveConfig.php
 * this code gets the Comic config file name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

$checkbox = '';
$configDir = '';
$clearedComic = '';
$clearedDB = '';
$noComicname = '';
$comicsDir = '/home/bitnami/Comics/htdocs/';
$clearedCdb = '';
$clearedIdb = '';

// check that form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['saveCheckbox'])) { $checkbox = 1; } else { $checkbox = 0;}
	if((isset($_SESSION["Comicname"])) && ($_SESSION["Comicname"] != '')){
		$Comicname = $_SESSION['Comicname'];
		// clear the Comic content?
		if($checkbox == 0) { //clean up Comic files?

			// Comics folder path
			//$comicsDir = '/home/bitnami/Comics/htdocs/';
			require("./rrmdir.php");

			if(file_exists($comicsDir.$Comicname.'.zip')) {
				$result = unlink($comicsDir.$Comicname.'.zip');}
			if(file_exists($comicsDir.$Comicname.'OGIMG.png')) {
				$result = unlink($comicsDir.$Comicname.'OGIMG.png');}
			if(file_exists($comicsDir.$Comicname.'OGIMG.jpg')) {
				$result = unlink($comicsDir.$Comicname.'OGIMG.jpg');}
			if(file_exists($comicsDir.$Comicname.'.html')) {
				$result = unlink($comicsDir.$Comicname.'.html');}
			if(file_exists($comicsDir.$Comicname.'.card')) {
				$result = unlink($comicsDir.$Comicname.'.card');}
			if(file_exists($comicsDir.'coversImg/'.$Comicname.'CARD.jpg')) {
				$result = unlink($comicsDir.'coversImg/'.$Comicname.'CARD.jpg');}
			if(file_exists($comicsDir.'coversImg/'.$Comicname.'CARD.gif')) {
				$result = unlink($comicsDir.'coversImg/'.$Comicname.'CARD.gif');}
			if(file_exists($comicsDir.'coversImg/'.$Comicname.'CARD.png')) {
				$result = unlink($comicsDir.'coversImg/'.$Comicname.'CARD.png');}
			$folder = $comicsDir.$Comicname;
			rrmdir($folder);
			$clearedComic = "Cleared the ' . $Comicname . ' content.<br>";

			// clean the Storybook databases
		require("/home/bitnami/includes/Comic.class.php");
			$comicbook = new Comic();
			$comicList = $comicbook->returnComicRecord($Comicname);
			$comicList = $comicbook->deleteComicRecord($Comicname);
			$clearedCdb = 'Cleared the Comic database<br>';
		require("/home/bitnami/includes/ComicImages.class.php");
				$ComicImages = new ComicImages();
			$imageList = $ComicImages->listComicImages($Comicname, true);
			$imageList = $ComicImages->deleteComicImages($Comicname);
			$clearedIdb = 'Cleared the Comic Images database<br>';
		}

	if(!(is_dir($comicsDir.$Comicname))) {
		mkdir($comicsDir.$Comicname, 0775, true);
	}

	// build the configuration data file content
	$configContent = '';
	$configContent .= '<?php ';
	$configContent .= 'require_once("/home/bitnami/session2DB/Zebra.php");';

	if(isset($_SESSION["siteurl"])){
		$siteurl = $_SESSION["siteurl"];
		$configContent .= '$_SESSION["siteurl"] = "'.$siteurl.'";';
		} else {
		$configContent .= '$_SESSION["siteurl"] = "";';
		}
	if(isset($_SESSION["cardTitle"])){
		$cardTitle = $_SESSION["cardTitle"];
		$configContent .= '$_SESSION["cardTitle"] = "'.$cardTitle.'";';
		} else {
		$configContent .= '$_SESSION["cardTitle"] = "";';
		}
	if(isset($_SESSION["Comicname"])){
		$Comicname =  $_SESSION["Comicname"];
		$configContent .= '$_SESSION["Comicname"] = "'.$Comicname.'";';
		} else {
		$configContent .= '$_SESSION["Comicname"] = "";';
		}
	if(isset($_SESSION["pageURL"])){
		$pageURL = $_SESSION["pageURL"];
		$configContent .= '$_SESSION["pageURL"] = "'.$pageURL.'";';
		} else {
		$configContent .= '$_SESSION["pageURL"] = "";';
		}
		if(isset($_SESSION["bkgndImage"])){
		$bkgndImage = $_SESSION["bkgndImage"];
		$configContent .= '$_SESSION["bkgndImage"] = "'.$bkgndImage.'";';
		} else {
		$configContent .= '$_SESSION["bkgndImage"] = "";';
		}
		if(isset($_SESSION["cardImage"])){
		$cardImage = $_SESSION["cardImage"];
		$configContent .= '$_SESSION["cardImage"] = "'.$cardImage.'";';
		} else {
		$configContent .= '$_SESSION["cardImage"] = "";';
		}
	if(isset($_SESSION["cardAlt"])){
		$cardAlt = $_SESSION["cardAlt"];
		$configContent .= '$_SESSION["cardAlt"] = "'.$cardAlt.'";';
		} else {
		$configContent .= '$_SESSION["cardAlt"] = "";';
		}
	if(isset($_SESSION["cardSubtitle"])){
		$cardSubtitle = $_SESSION["cardSubtitle"];
		$configContent .= '$_SESSION["cardSubtitle"] = "'.$cardSubtitle.'";';
		} else {
		$configContent .= '$_SESSION["cardSubtitle"] = "";';
		}
	if(isset($_SESSION["cardText"])){
		$cardText = $_SESSION["cardText"];
		$configContent .= '$_SESSION["cardText"] = "'.$cardText.'";';
		} else {
		$configContent .= '$_SESSION["cardText"] = "";';
		}
	if(isset($_SESSION["category"])){
		$category = $_SESSION["category"];
		$configContent .= '$_SESSION["category"] = "'.$category.'";';
		} else {
		$configContent .= '$_SESSION["category"] = "";';
		}
	if(isset($_SESSION["authorname"])){
		$authorname = $_SESSION["authorname"];
		$configContent .= '$_SESSION["authorname"] = "'.$authorname.'";';
		} else {
		$configContent .= '$_SESSION["authorname"] = "";';
		}
	if(isset($_SESSION["scriptname"])){
		$scriptname = $_SESSION["scriptname"];
		$configContent .= '$_SESSION["scriptname"] = "'.$scriptname.'";';
		} else {
		$configContent .= '$_SESSION["scriptname"] = "";';
		}
	if(isset($_SESSION["pencilsname"])){
		$pencilsname = $_SESSION["pencilsname"];
		$configContent .= '$_SESSION["pencilsname"] = "'.$pencilsname.'";';
		} else {
		$configContent .= '$_SESSION["pencilsname"] = "";';
		}
	if(isset($_SESSION["inksname"])){
		$inksname = $_SESSION["inksname"];
		$configContent .= '$_SESSION["inksname"] = "'.$inksname.'";';
		} else {
		$configContent .= '$_SESSION["inksname"] = "";';
		}
	if(isset($_SESSION["colorsname"])){
		$colorsname = $_SESSION["colorsname"];
		$configContent .= '$_SESSION["colorsname"] = "'.$colorsname.'";';
		} else {
		$configContent .= '$_SESSION["colorsname"] = "";';
		}
	if(isset($_SESSION["lettersname"])){
		$lettersname = $_SESSION["lettersname"];
		$configContent .= '$_SESSION["lettersname"] = "'.$lettersname.'";';
		} else {
		$configContent .= '$_SESSION["lettersname"] = "";';
		}
	if(isset($_SESSION["publisher"])){
		$publisher = $_SESSION["publisher"];
		$configContent .= '$_SESSION["publisher"] = "'.$publisher.'";';
		} else {
		$configContent .= '$_SESSION["publisher"] = "";';
		}
	if(isset($_SESSION["audience"])){
		$audience = $_SESSION["audience"];
		$configContent .= '$_SESSION["audience"] = "'.$audience.'";';
		} else {
		$configContent .= '$_SESSION["audience"] = "";';
		}
	if(isset($_SESSION["artistname"])){
		$artistname = $_SESSION["artistname"];
		$configContent .= '$_SESSION["artistname"] = "'.$artistname.'";';
		} else {
		$configContent .= '$_SESSION["artistname"] = "";';
		}
	if(isset($_SESSION["cardemail"])){
		$cardemail = $_SESSION["cardemail"];
		$configContent .= '$_SESSION["cardemail"] = "'.$cardemail.'";';
		} else {
		$configContent .= '$_SESSION["cardemail"] = "";';
		}

	if(isset($_SESSION["oauth_id"])){
		$oauth_id = $_SESSION["oauth_id"];
		$configContent .= '$_SESSION["oauth_id"] = "'.$oauth_id.'";';
		} else {
		$configContent .= '$_SESSION["oauth_id"] = "";';
		}
	$configContent .= '?>';
// now have the config data as a string

// build the gallery card file content for this comic
$cardContent = '';
$cardContent .= '  <!--Grid column-->';
$cardContent .= '  <!-- <div class="col-lg-4 col-md-12 mb-4"> -->';
$cardContent .= '    <!--Card-->';
$cardContent .= '        <div class="col-md-4 d-flex flex-direction:column justify-content-between align-items-center">';
$cardContent .= '          <div class="card mb-4 shadow-md #cfd8dc blue-grey lighten-4">';
$cardContent .= '			<!--Card image-->';
$cardContent .= '		    <div class="view overlay">';
if (!(isset($_SESSION['cardImage']))) {
	$cardContent .= '<a class="bd-placeholder-img card-img-top" href="./index.php#anchor1"><img width="100%" height="auto" src="../Comics/Img/WebComicConcept.jpg" alt="a placeholder image for the card image">';
} else {
	$cardContent .= '<a class="bd-placeholder-img card-img-top" href="'.$siteurl.$Comicname.'.html"><img width="100%" height="auto" src="../Comics/coversImg/'.$cardImage.'" alt="'.$cardAlt.'">';
}
$cardContent .= '	  <div class="mask rgba-white-light"></div>';
$cardContent .= '	</a>';
$cardContent .= '	</div>';
$cardContent .= '	<!--Card content-->';
$cardContent .= '	<div class="card-body">';
$cardContent .= '	 <!--Title-->';
$cardContent .= '<h2 class="card-title">'.$cardTitle.'</h2>';
$cardContent .= '<h3 class="card-title">'.$cardSubtitle.'</h3>';
$cardContent .= '<!--Text-->';
$cardContent .= '<p class="card-text text-dark">'.$cardText.'</p>';
if($category != '') {
	$cardContent .= '<button title="Category" type="button" class="btn btn-indigo galleryButton">'.$category.'</button>';}
if($authorname != '') {
	$cardContent .= '<button title="Author" type="button" class="btn btn-deep-purple galleryButton">'.$authorname.'</button>';}
if($scriptname != '') {
	$cardContent .= '<button title="Script Writer" type="button" class="btn btn-unique galleryButton">'.$scriptname.'</button>';}
if($pencilsname != '') {
	$cardContent .= '<button title="Pencils" type="button" class="btn btn-unique galleryButton">'.$pencilsname.'</button>';}
if($inksname != '') {
	$cardContent .= '<button title="Inks" type="button" class="btn btn-unique galleryButton">'.$inksname.'</button>';}
if($colorsname != '') {
	$cardContent .= '<button title="Coloring" type="button" class="btn btn-unique galleryButton">'.$colorsname.'</button>';}
if($lettersname != '') {
	$cardContent .= '<button title="Lettering" type="button" class="btn btn-unique galleryButton">'.$lettersname.'</button>';}
if($publisher != '') {
	$cardContent .= '<button title="Brand/Publisher" type="button" class="btn btn-purple galleryButton">'.$publisher.'</button>';}
if($audience != '') {
	$cardContent .= '<button title="Audience Category" type="button" class="btn btn-deep-orange text-dark galleryButton">'.$audience.'</button>';}
	$cardContent .= '<br><br><button title="Comic Generator" type="button" class="text-dark btn btn-light-blue galleryButton">A Storybook Comic</button>';
$cardContent .= '		</div>';
$cardContent .= '	  </div>';
$cardContent .= '	  <!--/.Card-->';
$cardContent .= '   </div>';
$cardContent .= '   <!--Grid column-->';

	/*	TABLE `comicdata`
	 `comic_id`
	 `oauth_id`
	 `comic_name`
	 `comic_title`
	 `comic_subtitle`
	 `comic_category`
	 `comic_author`
	 `comic_script`
	 `comic_pencils`
	 `comic_inks`
	 `comic_coloring`
	 `comic_lettering`
	 `comic_publisher`
	 `comic_audience`
	 `artistname`
	 `cardemail`
	 `created`
	 `lastview`
	 `views`
	*/
	//$Comicbook = array();
	$Comicbook = array();
    $Comicbook['oauth_id'] = $oauth_id;
    $Comicbook['comic_name']   = $Comicname;
    $Comicbook['comic_title'] = $cardTitle;
    $Comicbook['comic_subtitle'] = $cardSubtitle;
    $Comicbook['comic_category']	 = $category;
    $Comicbook['comic_author']   = $authorname;
    $Comicbook['comic_script']   = $scriptname;
    $Comicbook['comic_pencils']   	= $pencilsname;
    $Comicbook['comic_inks']   = $inksname;
    $Comicbook['comic_coloring'] = $colorsname;
    $Comicbook['comic_lettering']	 = $lettersname;
    $Comicbook['comic_publisher']   = $publisher;
    $Comicbook['comic_audience']   = $audience;
    $Comicbook['artistname']   	= $artistname;
    $Comicbook['cardemail']   = $cardemail;
    
    // Store comic data in the session
    $_SESSION['Comicbook'] = $Comicbook;
	// Insert comic data to the database
		if($checkbox == 1) { //db not already open?
		require("/home/bitnami/includes/Comic.class.php");
		$comicbook = new Comic(); }
	$Data = $comicbook->insertComic($Comicbook);

// write the configuration values and comics gallery card files
if($Comicname === '') {
	$noComicname = 'No Configuration Data!!!<br>';
	$deletedOldConfig = '';
	$wroteNewConfig = '';
	$deletedOldCard = '';
	$wroteNewCard = '';
	$clearedDB = '';
	$clearedComic = '';
} else {
	// write the config values file
	$file = $comicsDir.$Comicname.'/'.$Comicname.'.php';
	$deletedOldConfig = '';
	if(file_exists($file)) {
		unlink($file);
		$deletedOldConfig = "Deleted previous Configuration File<br>";}
	$return = file_put_contents($file, $configContent);
	$wroteNewConfig = '';
	if($return !== false) {
		$wroteNewConfig = 'Wrote a new Config File ' . $Comicname . '<br>'; }
	// write the comics gallery card file
	$cfile = $comicsDir.$Comicname.'.card';
	$deletedOldCard = '';
	if(file_exists($cfile)) {
		unlink($cfile);
		$deletedOldCard = "Deleted previous gallery Card File<br>";}
	$return = file_put_contents($cfile, $cardContent);
	$wroteNewCard = '';
	if($return !== false) {
		$wroteNewCard = 'Wrote a new gallery Card File ' . $Comicname . '<br>'; }
}
}
}
header("Refresh: 0; URL=./index.php");
if($Comicname === '') {
	echo "invalid operation.<br/><br/>";}
if(!($Comicname === '')) {
	echo "$Comicname is a valid filename string.<br/><br/>";}
echo "checkbox was ' . $checkbox . '<br>";
if(!($noComicname === '')) {
	echo $noComicname; }
if(!($deletedOldConfig === '')) {
	echo $deletedOldConfig; }
if(!($clearedComic === '')) {
	echo $clearedComic; }
if($clearedCdb != '') {
	echo $clearedCdb; }
if($clearedIdb != '') {
	echo $clearedIdb; }
if(!($wroteNewConfig === '')) {
	echo $wroteNewConfig; }
if(!($deletedOldCard === '')) {
	echo $deletedOldCard; }
if(!($wroteNewCard === '')) {
	echo $wroteNewCard; }

?>