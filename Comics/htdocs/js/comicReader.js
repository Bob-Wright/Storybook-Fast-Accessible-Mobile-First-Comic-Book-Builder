// comicReader.js
// scale the images to fill the viewport and keep aspect
// this is for demo and has extra tagging/labeling features
// comment out the console.log messages once you figure it out
 var showDetails = 0;
 var showVPDetails = 0;
 var viewportWidth = $(window).width();
 var viewportHeight = $(window).height();
 var elWidth = 0;
 var elHeight = 0;
 scale = 1;
 var imgCount = 0;
 var AltDataMsg = "";
 var audio;
 var altMP3;
	
$(document).ready( function() {
	if(showVPDetails == 1) {
		$("body").append('<div id="viewport-size" style="display:block;color:#fff;background:#08F;position:fixed;top:0;left:0;font-size:2vw;z-index:5;"></div>');}

$(window).resize(function() {
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
	$("#viewport-size").html('<div class="dimensions">' + viewportWidth + ' &times; ' + viewportHeight + ' px &amp; w/h = ' + 		VPaspectRounded + ' </div>');}

	// get total image count
	var matched = $("body img");
	var imgCount = matched.length;
	console.log("Number of images = " + imgCount);

	// loop through each image and tag it with an "id"
   $("img").each(function(index,value) {
	  this.setAttribute("id", index);
	  // get the image dimensions, faster to have sizes already specified
	  var elWidth = this.getAttribute("width");
	  // console.info("eW "+ this.getAttribute("width"));
	  if (elWidth == null) {
	    var elWidth = this.naturalWidth;
	  // console.info("nW "+elWidth);
	  }
	  var elHeight = this.getAttribute("height");
	    // console.info("eH "+ this.getAttribute("height"));
	  if (elHeight == null) {
	    var elHeight = this.naturalHeight;
		// console.info("nW "+ elHeight);
	  }
	  var imgSize = "Img Size: " + elWidth + " X " + elHeight;
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
		 //console.info ("hsize "+hsize);
		 //console.info ("vsize "+vsize);
	  // finally set the scaled image width and height attributes
		this.setAttribute("width", hsize);
		this.setAttribute("height", vsize);
	  // for the demo show a bunch of info about the image as displayed
		var currentImgID = this.getAttribute("id");
		var currentImgNumber =	parseInt(currentImgID) + 1;
		var currentImgSrc = this.getAttribute("src");
		var currentImgFilename = currentImgSrc.split('/').pop();

		// see if a hidden Image (GIF usually) or MP3 is present "alt-data"
		// console.info ("this img " + currentImgID);
		var	imgblockContent = document.getElementById(parseInt(currentImgID));
		//console.info ("this img block " + imgblockContent);
		var AltDataMsg = "";
		var altImg = imgblockContent.getAttribute("altImg");
		var altMP3 = imgblockContent.getAttribute("altMP3");
		// see if this panel/image has alt image data content
		if(altImg) {
			// console.info ("this altImg data " + altImg);
			var currentAltFilename = altImg.split('/').pop();
			// console.info ("altImg filename " + currentAltFilename);
			var currentAltFiletype = currentAltFilename.split('.').pop();
			// console.info ("altImg filetype " + currentAltFiletype);
			if(currentAltFiletype == "gif") {
				AltDataMsg = AltDataMsg + "<br>The displayed image is static, it acts as a cover for an animated GIF named&emsp;<span class=\"warning-color-text\"><em>" + currentAltFilename + "</em></span>&emsp;which will run if you click the panel or the play button.";
			} else {
				AltDataMsg = AltDataMsg + "<br>The displayed image is static, it acts as a cover for another image named&emsp;<span class=\"warning-color-text\"><em>" + currentAltFilename + "</em></span>&emsp;which will display if you click the panel or the play button."; }
		}
		// see if this panel/image has alt audio content
		if(altMP3) {
			// console.info ("this altMP3 data " + altMP3);
			var currentAltFilename = altMP3.split('/').pop();
			// console.info ("altMP3 filename " + currentAltFilename);
			var currentAltFiletype = currentAltFilename.split('.').pop();
			// console.info ("altMP3 filetype " + currentAltFiletype);
			if(currentAltFiletype == "mp3") {
				AltDataMsg = AltDataMsg + "<br>The image is static, it acts as a cover for an audio file named&emsp;<span class=\"warning-color-text\"><em>" + currentAltFilename + "</em></span>&emsp;which will play if you click the panel or the play button with audio enabled. By default the audio is muted.";}
		}
		// create info msg about the image
		var imageInfo = "This image above is named&emsp;<span class=\"warning-color-text\"><em>" + currentImgFilename + "</em></span>&emsp;and it is image number " + currentImgNumber + " of " + imgCount + " total Images.<br>The Actual Image Size is " + elWidth + " X " + elHeight + " pixels for an aspect ratio of " + aspectRounded + ", and a Scale multiplier of " + scaleRounded + " was then applied, resulting in the Image Display Size of " + hsize + " X " + vsize + " pixels seen here.";
	// display the info for this image
	if(showDetails == 1) {
		$("#" + currentImgID).after('<div class="card info col-sm-11 d-flex flex-row shadow-md #9fa8da indigo lighten-3 px-sm-0"  ><p class="card-text font-weight-bolder text-dark">' + imageInfo + AltDataMsg + '</p></div>');
	} else {
		$("#" + currentImgID).after('<br>');
	}
	});
}).trigger('resize');

$("audio").prop('muted', true);
$(".bi-volume-up").hide(0);
$(".bi-volume-mute").show(0);

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

// Change the image to alternate img when clicked.
// if it is a GIF it plays GIF each time clicked
$('.playGIF').on('click', function() {
	var $this   = $(this),
		$img    = $this.children('img'),
		$imgID = $img.attr('id'),
		$imgSrc = $img.attr('src'),
		$imgAlt = $img.attr('altImg'),
		$imgExt = $imgAlt.split('.').pop();
		if(altMP3) {
		$MP3Alt = $img.attr('altMP3'),
		$MP3Ext = $MP3Alt.split('.').pop(); };
		//console.info ("click index " + $index);
		// console.info ("click imgID " + $imgID);
		// console.info ("click imgSrc " + $imgSrc);
		// console.info ("click imgAlt " + $imgAlt);
		// console.info ("click imgExt " + $imgExt);
		// console.info ("click MP3Alt " + $MP3Alt);
		// console.info ("click MP3Ext " + $MP3Ext);
			$img.attr('src', $imgAlt);
			$altImgText = $img.attr('altImgText');
			$img.attr('alt', $altImgText);

// play the sound byte when clicked.
		//console.info ("click index " + $index);
		// console.info ("click imgID " + $imgID);
		// console.info ("click imgSrc " + $imgSrc);

    if ( $("audio").prop('muted') == false ) {
		//const rollSound = new Audio($imgAlt);
			//rollSound.play();
           audio = $(".comicAudio");
            addEventHandlers();
			//loadAudio();
			$(".comicAudio").trigger('load');
			//startAudio();
			$(".comicAudio").trigger('play');
	}
});

        function addEventHandlers(){
            $("a.load").click(loadAudio);
            $("a.start").click(startAudio);
            $("a.forward").click(forwardAudio);
            $("a.back").click(backAudio);
            $("a.pause").click(pauseAudio);
            $("a.stop").click(stopAudio);
            $("a.volume-up").click(volumeUp);
            $("a.volume-down").click(volumeDown);
            $("a.mute").click(toggleMuteAudio);
        }
 
        function loadAudio(){
            audio.bind("load",function(){
                $(".alert-success").html("Audio Loaded succesfully");
            });
            audio.trigger('load');
        }
 
        function startAudio(){
            audio.trigger('play');
        }
 
        function pauseAudio(){
            audio.trigger('pause');
        }
 
        function stopAudio(){
            pauseAudio();
            audio.prop("currentTime",0);
        }
 
        function forwardAudio(){
            pauseAudio();
            audio.prop("currentTime",audio.prop("currentTime")+5);
            startAudio();
        }
 
        function backAudio(){
            pauseAudio();
            audio.prop("currentTime",audio.prop("currentTime")-5);
            startAudio();
        }
 
        function volumeUp(){
            var volume = audio.prop("volume")+0.2;
            if(volume >1){
                volume = 1;
            }
            audio.prop("volume",volume);
        }
 
        function volumeDown(){
            var volume = audio.prop("volume")-0.2;
            if(volume <0){
                volume = 0;
            }
            audio.prop("volume",volume);
        }
 
        function toggleMuteAudio(){
            audio.prop("muted",!audio.prop("muted"));
        }

});
