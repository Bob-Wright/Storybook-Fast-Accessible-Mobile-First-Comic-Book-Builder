//logoSwap.js
// change the logo on mouseclick
var $toggleLogo = $('.toggleLogo');
// use state variable to keep track
var  isLogoOpen = true;
$toggleLogo.on( 'click', function() {
  isLogoOpen = !isLogoOpen;
// alert(isNavbarOpen);
// Set the logo img src content:
  if ( !isLogoOpen ) {
    document.getElementById("Logo").src = "./Images/IsoBlockSphere.gif";
  } else {
    document.getElementById("Logo").src = "./Images/Spin3.gif";
  }
});
// or
// change the logo on mouseover
/*function showOverlay() {
    document.getElementById("Logo").src = "./Images/IsoBlockSphere.gif";
}
function showLogo() {
    document.getElementById("Logo").src = "./Images/Spin3.gif";
}*/

// change the cover on timeout
function coverOverlayDelay() {
	setTimeout(showCoverOverlay, 3000);
}
// or
// change the cover on mouseover
function showCoverOverlay() {
    if ( document.getElementById("myCover")) {
    document.getElementById("myCover").style.opacity = "1";
}}
function showCover() {
  if ( document.getElementById("myCover")) {
    document.getElementById("myCover").style.opacity = "0";
}}

