// comicReader.js
// scale the images to fill the viewport and keep aspect
// this is for demo and has extra tagging/labeling features
// comment out the console.info messages once you figure it out
 var showDetails = 0;
 var showVPDetails = 0;
 var clicked = 2;
 var currentImgID = 0;
 var viewportWidth = $(window).width();
 var viewportHeight = $(window).height();
 var elWidth = 0;
 var elHeight = 0;
 scale = 1;
 var mp3Count = 0;
 var AltDataMsg = "";
 var audio;
 var currentImgFolder = "";
 var currentBase = "";
 var currentMP3 = "";
	
 // browser needs to decide which source image to load for each image element
 // before it can tell us which it is, use window onload instead of jquery ready
window.onload = function() {

$(window).resize(function() {
	if(showVPDetails == 1) {
		$("body").append('<div id="viewport-size" style="display:block;color:#fff;background:#08F;position:fixed;top:0;left:0;font-size:2vw;z-index:5;"></div>');}
  var viewportWidth = $(window).width();
  var viewportHeight = $(window).height();
  var VPaspectRatio = viewportWidth / viewportHeight;
	var VPaspectRounded = (Math.round(VPaspectRatio * 100)) / 100;
	  // console.info("rounded VP aspect " + VPaspectRounded);
  var id = 0;
   // delete old info cards on resize
   $(".info").each(function() {
	  this.remove();
   });
	if(showVPDetails == 1) {
	$("#viewport-size").html('<div class="dimensions">' + viewportWidth + ' &times; ' + viewportHeight + ' px &amp; w/h = ' + VPaspectRounded + ' </div>');}

	var matched = $("body .imgblock img");
	var imgCount = matched.length;
	console.info("Total Number of images/panels = " + imgCount);
	// get total image count not including alt images
	var pnlmatched = $("body .imgblock img.src");
	var pnlimgCount = pnlmatched.length;
	console.info("Number of src panels = " + pnlimgCount);
	// get total alt image count
	var altmatched = $("body .imgblock img.alt");
	var altimgCount = altmatched.length;
	console.info("Number of alt panels = " + altimgCount);
	// get total alt audio count
	var mp3matched = $("body .imgblock .playMP3");
	var mp3Count = mp3matched.length / 2;
	console.info("Number of alt panels with audio = " + mp3Count);

	// loop through each image and tag it with an "id"
	matched.each(function() {
		console.info("================");
		console.info("currentSrc "+ this.currentSrc);
		currentImgID = (this.getAttribute("id"));
			console.info("current img ID = "+ currentImgID);
		//});
		//console.info("next index "+ imgcounter);

	if (this.currentSrc.endsWith(".gif")) {
	  // get the image dimensions, faster to have sizes already specified
		if ((this.currentSrc.includes("-w")) && (this.currentSrc.includes("-h"))) {
	    var fnameLen = this.currentSrc.indexOf(".GIF");
	    var elWidth = this.currentSrc.substr((this.currentSrc.indexOf("-w") + 2 ), 4 );
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-h") + 2 ), 4 );
		}
	}
	if ((this.currentSrc.endsWith(".webp")) || (this.currentSrc.endsWith(".jpg"))) {
		if (this.currentSrc.includes("-s-")) {
	  // get the image dimensions, faster to have sizes already specified
	    var elWidth = 576;
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-s-") + 3 ), 4 );
		}
		if (this.currentSrc.includes("-m-")) {
	  // get the image dimensions, faster to have sizes already specified
	    var elWidth = 768;
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-m-") + 3 ), 4 );
		}
		if (this.currentSrc.includes("-l-")) {
	  // get the image dimensions, faster to have sizes already specified
	    var elWidth = 992;
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-l-") + 3 ), 4 );
		}
		if (this.currentSrc.includes("-x-")) {
	  // get the image dimensions, faster to have sizes already specified
	    var elWidth = 1200;
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-x-") + 3 ), 4 );
		}
		if (this.currentSrc.includes("-X-")) {
	  // get the image dimensions, faster to have sizes already specified
	    var elWidth = 1400;
	    var elHeight = this.currentSrc.substr((this.currentSrc.indexOf("-X-") + 3 ), 4 );
		}
	}
		console.info("nW "+elWidth);
		console.info("nH "+ elHeight);
	  // var imgSize = "Img Size: " + elWidth + " X " + elHeight;
	  // console.log(imgSize);
	  // checkpoint for zero height image
		if (elHeight == 0) {return};
		 elWidth = parseInt(elWidth);
		 elHeight = parseInt(elHeight);
		 viewportWidth = parseInt(viewportWidth);
		 viewportHeight = parseInt(viewportHeight);
		  //console.info("eW "+elWidth);
		  //console.info("eH "+elHeight);
		 // console.info("vW "+viewportWidth);
		 // console.info("vH "+viewportHeight);
		var aspect = elWidth/elHeight;
		var aspectRounded = (Math.round(aspect * 100)) / 100;
		 // console.info("rounded img aspect " + aspectRounded);
		var widthRatio = viewportWidth / elWidth;
		var heightRatio = viewportHeight / elHeight;
		 // console.info("wR "+widthRatio);
		 // console.info("hR "+heightRatio);
		 // default to the width ratio until proven wrong
		var scale = widthRatio;
		if (widthRatio * elHeight > viewportHeight) {
			scale = heightRatio;};
		//  console.info("\nwR "+widthRatio);
		//  console.info("hR "+heightRatio);
		//  console.info("scale "+scale);
		//  scale = scale * .98;
		//  console.info("finalscale " + scale);
		var scaleRounded = (Math.round(scale * 100)) / 100;
		//  console.info("rounded scale " + scaleRounded);
		//  fit the content into the window
		var hsize  = Math.round(elWidth * scale);
		var vsize = Math.round(elHeight * scale);
		 console.info ("hsize "+hsize);
		 console.info ("vsize "+vsize);
	  // finally set the scaled image width and height attributes
		this.setAttribute("width", hsize);
		this.setAttribute("height", vsize);
		this.setAttribute("src", this.currentSrc);
	  // for the demo show a bunch of info about the image as displayed
		// var currentImgID = this.getAttribute("id");
		//var currentImgNumber =	parseInt(currentImgID);
		//var	imgblockContent = document.getElementById(parseInt(currentImgID));
		//console.info ("this img block " + imgblockContent);

		//$(this).next( ".playGIF .alt" ).setAttribute("id", index); //also tag next alt image with same id
		// parse out the source name and folder for messages and to see if we have audio
		var currentImg = this.currentSrc;
		var currentImgSource = [];
		currentImgSource = this.currentSrc.split('/');
		var currentImgFilename = currentImgSource[currentImgSource.length - 1];
		console.info("currentImgFilename "+ currentImgFilename);
		var currentImgFolder = currentImgSource[currentImgSource.length - 2];
		console.info("currentImgFolder "+ currentImgFolder);
		//currentImgPath = currentImgSource.pop();
		//console.info("currentImgPath array "+ currentImgSource);
		var currentImgName = [];
		currentImgName = currentImgFilename.split('.');
		var currentImgNoExt = currentImgName[0];
		//console.info("current Img name no extension"+ currentImgNoExt);
		var currentBasePlus = [];
		currentBasePlus = currentImgNoExt.split('-');
		var currentBase = currentBasePlus[0];
		console.info("current Img basename "+ currentBase);
		var currentMP3 = "";
		if((this.className.includes("playMP3")) && (this.className.includes("playGIF"))) {
			currentMP3 = currentBase + '.mp3';
	        console.info('audio file exists = ' + currentMP3);
			AltDataMsg = "<br>There is an audio file named&emsp;<span class=\"warning-color-text\"><em>" + currentMP3 + "</em></span>&emsp;that will play if you click the panel or the play button with audio unmuted. By default the audio is muted. Click the audio icon to toggle audio muting.";
            //alert('file exists');
        } else {
			console.info('there is no audio file');
		}

		var imageInfo = "";
		if((this.className.includes("src")) && !(this.className.includes("playGIF")) && (showDetails == 1)) {
			//this.setAttribute("id", imgcounter);
		// create info msg about the image
			imageInfo = "This image above is named&emsp;<span style=\"color: darkBlue;\"><em>" + currentImgFilename + "</em></span>&emsp;and it is panel number " + currentImgID + " of " + pnlimgCount + " total panels.<br>The source image size is " + elWidth + " X " + elHeight + " pixels for an aspect ratio of " + aspectRounded + ". A scale multiplier of " + scaleRounded + " was then applied to fit the image to the viewport, resulting in the Image Display Size of " + hsize + " X " + vsize + " pixels seen here. There is no alternate image or audio for this panel.";
			//console.info("imageInfo "+ imageInfo);
			console.info("imageInfo "+ imageInfo);
			//console.info("AltDataMsg "+ AltDataMsg);
			$("#" + currentImgID).after('<div class="card info col-12 d-flex flex-row shadow-md px-sm-0" style="background-color: #b0bee0;"><p class="card-text font-weight-bolder text-dark">' + imageInfo + '</p></div>');
	} else { imageInfo = "";}
		//if((this.className.includes("src")) && (this.className.includes("playGIF")) && ($(this).css("display") == "block")) {
		if((this.className.includes("src")) && (this.className.includes("playGIF"))) {
			//this.setAttribute("id", imgcounter);
		// create info msg about the image
			srcimageInfo = "This image above is named&emsp;<span style=\"color: darkBlue;\"><em>" + currentImgFilename + "</em></span>&emsp;and it is panel number " + currentImgID + " of " + pnlimgCount + " total panels.<br>The source image size is " + elWidth + " X " + elHeight + " pixels for an aspect ratio of " + aspectRounded + ". A scale multiplier of " + scaleRounded + " was then applied to fit the image to the viewport, resulting in the Image Display Size of " + hsize + " X " + vsize + " pixels seen here. This panel has an alternate image that will display if you click the panel or the play button.";
			//console.info("imageInfo "+ imageInfo);
		}
		if((this.className.includes("alt")) && (this.className.includes("playGIF"))) {
			//this.setAttribute("id", imgcounter);
			altimageInfo = "This image above is named&emsp;<span style=\"color: darkBlue;\"><em>" + currentImgFolder + '/' + currentImgFilename + "</em></span>&emsp;and it is panel number " + currentImgID + " of " + pnlimgCount + " total panels.<br>The source image size is " + elWidth + " X " + elHeight + " pixels for an aspect ratio of " + aspectRounded + ". A scale multiplier of " + scaleRounded + " was then applied to fit the image to the viewport, resulting in the Image Display Size of " + hsize + " X " + vsize + " pixels seen here. This panel is an alternate image that displays from a click on the panel or the play button.";
			//console.info("imageInfo "+ imageInfo);
		// display the info for this image src on first pass
			if(clicked == 2) { // label playGIF src images first time thru
				console.info('------ never clicked -------');
				console.info("srcimageInfo "+ srcimageInfo);
				console.info("AltDataMsg "+ AltDataMsg);
			if (showDetails == 1) {
				playLabel =
				'<div id="img' + currentImgID + '" class="card srcinfo col-12 shadow-md px-sm-0" style="display: block;background-color: #b0d0ec;"><p class="card-text font-weight-bolder text-dark">' + srcimageInfo + AltDataMsg + '</p></div><div id="img' + currentImgID + '" class="card altinfo col-12 shadow-md px-sm-0" style="display: none;background-color: #b0bee0;"><p class="card-text font-weight-bolder text-dark">' + altimageInfo + AltDataMsg + '</p></div>';
				$(this).after(playLabel); }
				clicked = 0;
			}
		}
});
}).trigger('resize');

	  $(".bi-badge-cc").hide(0);
	  $(".bi-x-box").show(0);

// audio mute unmute toggle
$("audio").prop('muted', true);
$(".bi-volume-up").hide(0);
$(".bi-volume-mute").show(0);
// toggle on click
  $("#mute-audio").click( function (){
    if( $("audio").prop('muted') ) {
          $("audio").prop('muted', false);
		  $(".bi-volume-mute").hide(0);
		  $(".bi-volume-up").show(0);
    } else {
      $("audio").prop('muted', true);
	  $(".bi-volume-up").hide(0);
	  $(".bi-volume-mute").show(0);
    }
  });
// toggle on enter key
$("#mute-audio").keyup(function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   $("#mute-audio").click();
  }
});

// Change the image to alternate img when clicked.
// if it is a GIF it plays GIF each time clicked
$('.clickMeOverlay').click( function() {
	clickaltimg = $('.clickMeOverlay').children('.alt');
	clicksrcimg = $('.clickMeOverlay').children('.src');
 	clickaltinfo = $('.clickMeOverlay').children('.altinfo');
 	clicksrcinfo = $('.clickMeOverlay').children('.srcinfo');
	currentID = clickaltimg.attr("id");
	transtext = document.getElementById("transcript" + currentID);
	console.info('----- has been clicked -----');
	console.info("currentID "+ currentID);
	//console.info("mp3ID "+ mp3ID);
		if(clickaltimg.css("display") == "none") {
			clicksrcimg.css("display", "none");
			clickaltimg.css("display", "block");
			if(transtext.className.includes("active")) {
				$(transtext).css("display", "block");
			} else {
				$(transtext).css("display", "none");
			}
		if (showDetails == 1) {
			clicksrcinfo.css("display", "none");
			clickaltinfo.css("display", "block");
		}
		cap = document.getElementById("caption" + currentID);
		$(cap).css("display", "none");
		acap = document.getElementById("altcap" + currentID);
		$(acap).css("display", "block");
		clicked = 1;
			//mp3Id = $('#aud9');
			//mp3File = './testcomic/altImgs/07_hyena_laughing.mp3';
		console.info('----- image and caption changed -----');
		console.info("altimgID "+ currentID);
		if ( $("audio").prop('muted') == false ) {
			console.info("audio not muted. play the audio.");
			var audio_element = document.getElementById('audio' + currentID);
    		audio_element.load();
    		audio_element.playclip = function(){
        		audio_element.pause();
        		audio_element.currentTime=0;
        		audio_element.play();}
			audio_element.playclip();
			}

		} else {
			console.info('----- back to original image and caption -----');
			clickaltimg.css("display", "none");
			$(transtext).css("display", "none");
			clicksrcimg.css("display", "block");
			if (showDetails == 1) {
			clickaltinfo.css("display", "none");
			clicksrcinfo.css("display", "block");
			}
			acap = document.getElementById("altcap" + currentID);
			$(acap).css("display", "none");
			cap = document.getElementById("caption" + currentID);
			$(cap).css("display", "block");
			clicked = 0;
		}
console.info("Clicked " + clicked);
});

$('.clickMeOverlay').keyup(function(event) {
  if (event.keyCode === 13) {
	event.preventDefault();
//$('.clickMeOverlay').click();
	clickaltimg = $('.clickMeOverlay').children('.alt');
	clicksrcimg = $('.clickMeOverlay').children('.src');
 	clickaltinfo = $('.clickMeOverlay').children('.altinfo');
 	clicksrcinfo = $('.clickMeOverlay').children('.srcinfo');
	currentID = clickaltimg.attr("id");
	transtext = document.getElementById("transcript" + currentID);
	console.info('----- has been clicked -----');
	console.info("currentID "+ currentID);
	//console.info("mp3ID "+ mp3ID);
		if(clickaltimg.css("display") == "none") {
			clicksrcimg.css("display", "none");
			clickaltimg.css("display", "block");
			if(transtext.className.includes("active")) {
				$(transtext).css("display", "block");
			} else {
				$(transtext).css("display", "none");
			}
		if (showDetails == 1) {
			clicksrcinfo.css("display", "none");
			clickaltinfo.css("display", "block");
		}
		cap = document.getElementById("caption" + currentID);
		$(cap).css("display", "none");
		acap = document.getElementById("altcap" + currentID);
		$(acap).css("display", "block");
		clicked = 1;
			//mp3Id = $('#aud9');
			//mp3File = './testcomic/altImgs/07_hyena_laughing.mp3';
		console.info('----- image and caption changed -----');
		console.info("altimgID "+ currentID);
		if ( $("audio").prop('muted') == false ) {
			console.info("audio not muted. play the audio.");
			var audio_element = document.getElementById('audio' + currentID);
    		audio_element.load();
    		audio_element.playclip = function(){
        		audio_element.pause();
        		audio_element.currentTime=0;
        		audio_element.play();}
			audio_element.playclip();
			}

		} else {
			console.info('----- back to original image and caption -----');
			clickaltimg.css("display", "none");
			$(transtext).css("display", "none");
			clicksrcimg.css("display", "block");
			if (showDetails == 1) {
			clickaltinfo.css("display", "none");
			clicksrcinfo.css("display", "block");
			}
			acap = document.getElementById("altcap" + currentID);
			$(acap).css("display", "none");
			cap = document.getElementById("caption" + currentID);
			$(cap).css("display", "block");
			clicked = 0;
		}
console.info("Clicked " + clicked);
}
});

// Control transcript display
$('.transcriptControl').click( function() {
	clickaltimg = $('.clickMeOverlay').children('.alt');
	currentID = clickaltimg.attr("id");
	console.info('----- transcriptControl has been clicked -----');
	console.info("currentID "+ currentID);
	transtext = document.getElementById("transcript" + currentID);
	transtextclasses = transtext.className;
	console.info("transtextclasses "+ transtextclasses);
	if(transtext.className.includes("active")) {
		transtext.className = "card-body" 
	  $(".bi-badge-cc").hide(0);
	  $(".bi-x-box").show(0);
	} else {
		transtext.className = "card-body active";
	  $(".bi-x-box").hide(0);
	  $(".bi-badge-cc").show(0);
	}
});

$('.transcriptControl').keyup(function(event) {
  if (event.keyCode === 13) {
	event.preventDefault();
	//$('.transcriptControl').click( function() {
	clickaltimg = $('.clickMeOverlay').children('.alt');
	currentID = clickaltimg.attr("id");
	console.info('----- transcriptControl has been clicked -----');
	console.info("currentID "+ currentID);
	transtext = document.getElementById("transcript" + currentID);
	transtextclasses = transtext.className;
	console.info("transtextclasses "+ transtextclasses);
	if(transtext.className.includes("active")) {
		transtext.className = "card-body" 
	  $(".bi-badge-cc").hide(0);
	  $(".bi-x-box").show(0);
	} else {
		transtext.className = "card-body active";
	  $(".bi-x-box").hide(0);
	  $(".bi-badge-cc").show(0);
	}
}
});

}
