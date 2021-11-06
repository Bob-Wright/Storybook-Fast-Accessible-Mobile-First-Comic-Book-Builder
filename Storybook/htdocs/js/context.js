//context.js
//conditionally enable/disable right mouse click //
$(document).ready( function() {
if (document.getElementById("showContext")) {
		window.addEventListener("contextmenu", e => {
		e.preventDefault();
	});
	const context = document.querySelector(".context");
		let contextVisible = false;
	const togglecontext = command => {
		context.style.display = command === "show" ? "block" : "none";
		contextVisible = !contextVisible;
	};
	const setPosition = ({ top, left }) => {
		context.style.left = `${left}px`;
		context.style.top = `${top}px`;
		togglecontext("show");
	};
	window.addEventListener("click", e => {
		if(contextVisible)togglecontext("hide");
	});
	window.addEventListener("contextmenu", e => {
		e.preventDefault();
		const origin = {
			left: e.pageX,
			top: e.pageY
	};
	setPosition(origin);
	return false;
	});
} else {
		//Disable cut copy paste
		$('body').bind('cut copy paste', function (e) {
        e.preventDefault();
		});
		//Disable mouse right click
		$("body").on("contextmenu",function(e){
			return false;
		});
		console.info("no context");
}})

