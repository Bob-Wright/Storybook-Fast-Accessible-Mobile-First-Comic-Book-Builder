// select either landingpage OR Storybook card, NOT both
//if landingpage then we make a landing page for the comic
$landingpage = false;
	if((file_exists("/home/bitnami/includes/landingpage.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$landingpage = true;}

$configContent .= '';
if ($landingpage) {
	$configContent .= '<h4>Current Landing Page config values:</h4><p class="configContent">';
	if(isset($_SESSION["siteurl"])){
		$siteurl = $_SESSION["siteurl"];
		$configContent .= '[siteurl] is ['.$siteurl.']';
		} else {
		$configContent .= '[siteurl] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Comicname"])){
		$Comicname =  $_SESSION["Comicname"];
		$configContent .= '[Comicname] is ['.$Comicname.']';
		} else {
		$configContent .= '[Comicname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["pagetitle"])){
		$pagetitle = $_SESSION["pagetitle"];
		$configContent .= '[pagetitle] is ['.$pagetitle.']';
		} else {
		$configContent .= '[pagetitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["sitename"])){
		$sitename = $_SESSION["sitename"];
		$configContent .= '[sitename] is ['.$sitename.']';
		} else {
		$configContent .= '[sitename] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["sitesubtitle"])){
		$sitesubtitle = $_SESSION["sitesubtitle"];
		$configContent .= '[sitesubtitle] is ['.$sitesubtitle.']';
		} else {
		$configContent .= '[sitesubtitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["noZoomSitename"])){
		$noZoomSitename = $_SESSION["noZoomSitename"];
		$configContent .= '[noZoomSitename] is ['.$noZoomSitename.']';
		} else {
		$configContent .= '[noZoomSitename] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["navmenu"])){
		$navmenu = $_SESSION["navmenu"];
		$configContent .= '[navmenu] is ['.$navmenu.']';
		} else {
		$configContent .= '[navmenu] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Comicdisplayname"])){
		$Comicdisplayname = $_SESSION["Comicdisplayname"];
		$configContent .= '[Comicdisplayname] is ['.$Comicdisplayname.']';
		} else {
		$configContent .= '[Comicdisplayname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Subtitle"])){
		$Subtitle = $_SESSION["Subtitle"];
		$configContent .= '[Subtitle] is ['.$Subtitle.']';
		} else {
		$configContent .= '[Subtitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Comiccomment"])){
		$Comiccomment = $_SESSION["Comiccomment"];
		$configContent .= '[Comiccomment] is ['.$Comiccomment.']';
		} else {
		$configContent .= '[Comiccomment] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Comicemail"])){
		$Comicemail = $_SESSION["Comicemail"];
		$configContent .= '[Comicemail] is ['.$Comicemail.']';
		} else {
		$configContent .= '[Comicemail] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["artistname"])){
		$artistname = $_SESSION["artistname"];
		$configContent .= '[artistname] is ['.$artistname.']';
		} else {
		$configContent .= '[artistname] is not set';
		}
	$configContent .= '</p>';
} //end landingpage conditionals
