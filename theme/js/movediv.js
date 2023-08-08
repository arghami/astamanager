
var clickX = 0;
var clickY = 0;
var startX = 0;
var startY = 0;

var Movediv = {

	init: function() {

		//listener spostamento div sovrapposto
		var div = document.getElementById('listasquadrediv');
		Core.addEventListener(div, 'mousedown', Movediv.startMove);
	},

	startMove: function(event) {
		var div = document.getElementById('listasquadrediv');
		clickX = event.clientX;
		clickY = event.clientY;
		startX = parseInt(div.style.left);
		startY = parseInt(div.style.top);
		Core.addEventListener(document.body, 'mousemove', Movediv.doMove);
		Core.addEventListener(document.body, 'mouseup', Movediv.stopMove);
		Core.preventDefault(event);
	},

	doMove: function(event) {
		var div = document.getElementById('listasquadrediv');
		div.style.left = startX + event.clientX - clickX+"px";
		div.style.top = startY + event.clientY - clickY+"px";
		Core.preventDefault(event);
	},

	stopMove: function(event) {
		var div = document.getElementById('listasquadrediv');
		Core.removeEventListener(document.body, 'mousemove', Movediv.doMove);
	}

}

Core.start(Movediv);