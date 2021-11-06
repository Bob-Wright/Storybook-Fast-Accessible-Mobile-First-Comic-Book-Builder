<?php
/*
 * filename: getConfigValues.php
 * this code displays the Comic config values from the SESSION
*/

//if storybook then we make a gallery card for the comic
$storybook = false;
	if((file_exists("/home/bitnami/includes/storybook.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$storybook = true;}

$configContent = '';
if ($storybook) {
	$configContent .= '<h4 style="color:purple;">Current Gallery Card config values:</h4><p class="configContent">';
	if(isset($_SESSION["siteurl"])){
		$siteurl = $_SESSION["siteurl"];
		$configContent .= '[siteurl] is ['.$siteurl.']';
		} else {
		$configContent .= '[siteurl] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardTitle"])){
		$cardTitle = $_SESSION["cardTitle"];
		$configContent .= '[cardTitle] is ['.$cardTitle.']';
		} else {
		$configContent .= '[cardTitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["Comicname"])){
		$Comicname = $_SESSION["Comicname"];
		$configContent .= '[Comicname] is ['.$Comicname.']';
		$configContent .= '<br>';
		$pageURL = $siteurl.$Comicname.'.html';
		$_SESSION['pageURL'] = $pageURL;
		$configContent .= '[pageURL] is ['.$pageURL.']';
		$configContent .= '<br>';
		} else {
		$configContent .= '[Comicname] is not set';
		$configContent .= '<br>';
		$configContent .= '[pageURL] is not set';
		$configContent .= '<br>';
		}
	if(isset($_SESSION["bkgndImage"])){
		$bkgndImage = $_SESSION["bkgndImage"];
		$configContent .= '[bkgndImage] is ['.$bkgndImage.']';
		} else {
		$configContent .= '[bkgndImage] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardImage"])){
		$cardImage = $_SESSION["cardImage"];
		$configContent .= '[cardImage] is ['.$cardImage.']';
		} else {
		$configContent .= '[cardImage] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardAlt"])){
		$cardAlt = $_SESSION["cardAlt"];
		$configContent .= '[cardAlt] is ['.$cardAlt.']';
		} else {
		$configContent .= '[cardAlt] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardSubtitle"])){
		$cardSubtitle = $_SESSION["cardSubtitle"];
		$configContent .= '[cardSubtitle] is ['.$cardSubtitle.']';
		} else {
		$configContent .= '[cardSubtitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardText"])){
		$cardText = $_SESSION["cardText"];
		$configContent .= '[cardText] is ['.$cardText.']';
		} else {
		$configContent .= '[cardText] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["category"])){
		$category = $_SESSION["category"];
		$configContent .= '[category] is ['.$category.']';
		} else {
		$configContent .= '[category] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["authorname"])){
		$authorname = $_SESSION["authorname"];
		$configContent .= '[authorname] is ['.$authorname.']';
		} else {
		$configContent .= '[authorname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["scriptname"])){
		$scriptname = $_SESSION["scriptname"];
		$configContent .= '[scriptname] is ['.$scriptname.']';
		} else {
		$configContent .= '[scriptname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["pencilsname"])){
		$pencilsname = $_SESSION["pencilsname"];
		$configContent .= '[pencilsname] is ['.$pencilsname.']';
		} else {
		$configContent .= '[pencilsname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["inksname"])){
		$inksname = $_SESSION["inksname"];
		$configContent .= '[inksname] is ['.$inksname.']';
		} else {
		$configContent .= '[inksname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["colorsname"])){
		$colorsname = $_SESSION["colorsname"];
		$configContent .= '[colorsname] is ['.$colorsname.']';
		} else {
		$configContent .= '[colorsname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["lettersname"])){
		$lettersname = $_SESSION["lettersname"];
		$configContent .= '[lettersname] is ['.$lettersname.']';
		} else {
		$configContent .= '[lettersname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["publisher"])){
		$publisher = $_SESSION["publisher"];
		$configContent .= '[publisher] is ['.$publisher.']';
		} else {
		$configContent .= '[publisher] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["audience"])){
		$audience = $_SESSION["audience"];
		$configContent .= '[audience] is ['.$audience.']';
		} else {
		$configContent .= '[audience] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["artistname"])){
		$artistname = $_SESSION["artistname"];
		$configContent .= '[artistname] is ['.$artistname.']';
		} else {
		$configContent .= '[artistname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["cardemail"])){
		$cardemail = $_SESSION["cardemail"];
		$configContent .= '[cardemail] is ['.$cardemail.']';
		} else {
		$configContent .= '[cardemail] is not set';
		}
	$configContent .= '</p>';
} //end storybook conditionals

	if(isset($_SESSION["oauth_id"])){
		$configContent .= '<h4 style="color:purple;">OAuth user ID from Facebook</h4><p class="configContent">';
		$oauth_id = $_SESSION["oauth_id"];
		$configContent .= 'The [oauth_id] user ID from a Facebook login is ['.$oauth_id.']';
		$configContent .= '</p>';
	} else {
		$configContent .= 'The [oauth_id] user ID from a Facebook login is not set';
		$configContent .= '</p>';
	}

	if(isset($_SESSION["email_id"])){
		$configContent .= '<h4 style="color:purple;">User name from password login</h4><p class="configContent">';
		$email_id = $_SESSION["email_id"];
		$configContent .= 'The [email_id] from a login is ['.$email_id.']';
		$configContent .= '</p>';
	} else {
		$configContent .= 'The [email_id] from a login is not set';
		$configContent .= '</p>';
	}

echo $configContent;
?>
