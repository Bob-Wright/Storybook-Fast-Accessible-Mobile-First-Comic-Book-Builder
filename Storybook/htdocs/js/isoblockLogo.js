/*!
 * isoblockLogo.js
 * from Bats Cursor.js
 * - 90's cursors collection
 * -- https://github.com/tholman/90s-cursor-effects
 * -- http://codepen.io/tholman/full/kkmZyq/
 * now displays spinning logo image trails
 */

(function batCursor() {
  
  //var width = window.innerWidth;
  //var height = window.innerHeight;
  var width = Math.min(document.documentElement.clientWidth, window.innerWidth || 0);
  var height = Math.min(document.documentElement.clientHeight, window.innerHeight || 0);
  var cursor = {x: width, y: height};
  var particles = [];
  var disableCursors = 0;
  
  function init() {
	setCursorDisplayTime();
    bindEvents();
    attachInitialParticleStyles();
    loop();
  }

  // Bind events that are needed
  function bindEvents() {
    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('touchmove', onTouchMove);
    document.addEventListener('touchstart', onTouchMove);
    window.addEventListener('resize', onWindowResize);
  }
  
  function onWindowResize(e) {
  width = Math.min(document.documentElement.clientWidth, window.innerWidth || 0);
  height = Math.min(document.documentElement.clientHeight, window.innerHeight || 0);
  }
  
  function onTouchMove(e) {
    if (disableCursors == 0) {
    if( e.touches.length > 0 ) {
      for( i = 0; i < e.touches.length; i = (i + 40) ) {
        addParticle(e.touches[i].clientX, e.touches[i].clientY);
      }
    }}
  }	   
  
// timeout
function setCursorDisplayTime() {
	setTimeout(cursorDisable, 7000);
}

function cursorDisable() {
	disableCursors = 1;
}

  function onMouseMove(e) {    
    // cursor.x = e.clientX;
    // cursor.y = e.clientY;
    if (disableCursors == 0) {
	if ((Math.abs(cursor.x - e.clientX) > (width * .1)) || (Math.abs(cursor.y - e.clientY) > (width * .1))) {
		cursor.y = e.clientY;
		cursor.x = e.clientX;
    addParticle( cursor.x, cursor.y);
	}}
  }
  
  function addParticle(x, y) {
    var particle = new Particle();
    particle.init(x, y);
    particles.push(particle);
  }
  
  function updateParticles() {
    
    // Update
    for( var i = 0; i < particles.length; i++ ) {
      particles[i].update();
    }
    
    // Remove dead particles
    for( var i = particles.length - 1; i >= 0; i-- ) {
      if( particles[i].lifeSpan < 0 ) {
        particles[i].die();
        particles.splice(i, 1);
      }
    }
    
  }
  
  function loop() {
    requestAnimationFrame(loop);
    updateParticles();
  }
  
  /**
   * Particles
   */
  
  function Particle() {

//    this.lifeSpan = 200; //ms
    
    // Init, and set properties
    this.init = function(x, y) {

      this.velocity = {
        x:  (Math.random() < 0.5 ? -1 : 1) * (Math.random() * 2),
        y: (-2.5 + (Math.random() * -1))
      };
    this.lifeSpan = 120 + Math.floor(Math.random() * 60); //ms
      
      this.position = {x: x - 15, y: y - 15};

      this.element = document.createElement('span');
      this.element.className = "particle-bats"
      this.update();
      
      document.body.appendChild(this.element);
    };
    
    this.update = function() {
      this.position.x += this.velocity.x;
      this.position.y += this.velocity.y;
      
      // Update velocities
      this.velocity.x += (Math.random() < 0.5 ? -1 : 1) * 2 / 75;
      this.velocity.y -= Math.random() / 600;
      this.lifeSpan--;
      
/*      this.element.style.transform = "translate3d(" + this.position.x + "px," + this.position.y + "px,0) scale(" + ( 0.2 + (250 - this.lifeSpan) / 250) + ")"; */
      this.element.style.transform = "translate3d(" + this.position.x + "px," + this.position.y + "px, 0) scale(" + (this.lifeSpan / 120) + ") rotate("+ (3 * this.lifeSpan) + "deg)";
    }
    
    this.die = function() {
      this.element.parentNode.removeChild(this.element);
    }
  }
  
  /**
   * Utils
   */
  
  // Injects initial bat styles to the head of the page.
  function attachInitialParticleStyles() {
    
    var initialStyles = 
        [
         ".particle-bats {",
           "position: fixed;",
           "display: block;",
	  "top: 0;",
           "pointer-events: none;",
           "z-index: 10000000;",
           "width: 100px;",
           "height: 80px;",
           "will-change: transform;",
           "background-size: contain;",
           "background-image: url('../isoblock.png');",
          "}"
        ].join('');
    
    var style = document.createElement('style')
    style.type = 'text/css';
    style.innerHTML = initialStyles;
    document.getElementsByTagName('head')[0].appendChild(style)
  };
  
  init();
})();