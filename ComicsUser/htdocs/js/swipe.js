// swipe.js
// swipe for mobile devices
//detectSwipe('an_element_id', myfunction);
function detectSwipe(id, f) {
    var detect = {
        startX: 0,
        startY: 0,
        endX: 0,
        endY: 0,
        minX: 30,   // min X swipe for horizontal swipe
        maxX: 30,   // max X difference for vertical swipe
        minY: 50,   // min Y swipe for vertial swipe
        maxY: 60    // max Y difference for horizontal swipe
    },
        direction = null,
        element = document.getElementById(id);

    element.addEventListener('touchstart', function (event) {
        var touch = event.touches[0];
        detect.startX = touch.screenX;
        detect.startY = touch.screenY;
    });

    element.addEventListener('touchmove', function (event) {
        event.preventDefault();
        var touch = event.touches[0];
        detect.endX = touch.screenX;
        detect.endY = touch.screenY;
    });

    element.addEventListener('touchend', function (event) {
        if (
            // Horizontal move.
            (Math.abs(detect.endX - detect.startX) > detect.minX)
                && (Math.abs(detect.endY - detect.startY) < detect.maxY)
        ) {
            direction = (detect.endX > detect.startX) ? 'right' : 'left';
        } else if (
            // Vertical move.
            (Math.abs(detect.endY - detect.startY) > detect.minY)
                && (Math.abs(detect.endX - detect.startX) < detect.maxX)
        ) {
            direction = (detect.endY > detect.startY) ? 'down' : 'up';
        }

        if ((direction !== null) && (typeof f === 'function')) {
            f(element, direction);
        }
    });
}
//detectSwipe('an_element_id', myfunction);
/*function detectswipe(el,func) {
	if (isModalOpen = true) {
      swipe_det = new Object();
      swipe_det.sX = 0;
      swipe_det.sY = 0;
      swipe_det.eX = 0;
      swipe_det.eY = 0;
      var min_x = 20;  //min x swipe for horizontal swipe
      var max_x = 40;  //max x difference for vertical swipe
      var min_y = 40;  //min y swipe for vertical swipe
      var max_y = 50;  //max y difference for horizontal swipe
      var direc = "";
      ele = document.getElementById(el);
      ele.addEventListener('touchstart',function(e){
        var t = e.touches[0];
        swipe_det.sX = t.screenX; 
        swipe_det.sY = t.screenY;
      },false);
      ele.addEventListener('touchmove',function(e){
        e.preventDefault();
        var t = e.touches[0];
        swipe_det.eX = t.screenX; 
        swipe_det.eY = t.screenY;    
      },false);
      ele.addEventListener('touchend',function(e){
        //horizontal detection
        if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y)))) {
          if(swipe_det.eX > swipe_det.sX) direc = "r";
          else direc = "l";
        }
        //vertical detection
        if ((((swipe_det.eY - min_y > swipe_det.sY) || (swipe_det.eY + min_y < swipe_det.sY)) && ((swipe_det.eX < swipe_det.sX + max_x) && (swipe_det.sX > swipe_det.eX - max_x)))) {
          if(swipe_det.eY > swipe_det.sY) direc = "d";
          else direc = "u";
        }
    
        if (direc != "") {
          if(typeof func == 'function') func(el,direc);
        }
        direc = "";
      },false);  
    }
}
    function myfunction(el,d) {
//      alert("you swiped on element '"+el+"' in "+d+" direction");
	 if (d == "r") {
	   plusSlides(-1);
	 }
	 if (d == "l") {
	   plusSlides(1);
	 }
	 if (d == "u") {
	   closeModal();
	 }
    }
    detectswipe('myModal',myfunction); */
