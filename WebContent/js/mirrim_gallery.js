function MirrimGallery() {

	this.initialize(true);

} 

MirrimGallery.prototype.initialize = function(first) {
	
	var app = this ;
	console.log( "starting up Mirrim Gallery" );
    
    this.initGallery();
    
} ;

MirrimGallery.prototype.initGallery = function() {
	 $( function(){
		    $( "#gallery" ).jGallery( {
		    	"width":"700px",
		    	"height": "700px",
		        "transition":"fade_moveFromLeft",
		        "transitionCols":"1",
		        "transitionRows":"1",
		        "thumbnailsPosition":"bottom",
		        "thumbType":"square",
		        "backgroundColor":"#000",
		        "textColor":"#fff",
		        "mode":"slider"
		    } );
		} );   
}

MirrimGallery.alert = function(text) {
	// We're wrapping `alert` so if we want to use a modal
	// or something later it will be easier to do so.
	window.alert(text);
} ;

$(document).ready(function () {
	var gallery = new MirrimGallery('#page');
});
