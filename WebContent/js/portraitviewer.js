
var mirrimviz ;

function PortraitViewer() {

    this.initialize(true);
    animate() ;

}

PortraitViewer.prototype.initialize = function(first) {

    var app = this ;
    console.log( "starting up Mirrim Portrait Viewer" );

    $('#shutter').on( "click", function(){
        capture_image() ;
    }) ;

    $('#close-snapdiv').on("click", function() {
        // alert("Close it!");
        $('#snapdiv').hide() ;
    }) ;

    mirrimviz = new MirrimViz( "vizcanvas", "vizprogress", "../models/kathy_constantine_web.js", "../models/kathy_web_uvmap.png", "../images/squareimage.png", 800, 800, 3.2);

} ;

function capture_image() {
   var snap = mirrimviz.captureFrame() ;
   var imgNode = document.createElement("img");
   imgNode.src = snap;
   var snapDiv = $('#snapdiv');
   snapDiv.show() ;
   var snapDivImg = $('#snapdiv-img');
   var snapElem = snapDivImg.get(0);
   snapElem.removeChild( snapElem.firstChild) ;
   snapElem.appendChild(imgNode);
}


function animate() {
    mirrimviz.render() ;
    window.requestAnimationFrame( animate ) ;
}

$(document).ready(function () {
    var pviewer = new PortraitViewer('#page');
});
