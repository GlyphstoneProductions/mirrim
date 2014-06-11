function MirrimViz( divid, progressid, modelpath, texturepath, floorpath, canvasWidth, canvasHeight, scale) {

  this.scene ;
  this.camera;
  this.renderer;
  this.model ;
  this.controls ;
  this.progressDiv ;
  this.canvas ;

    if( !scale ) {
        scale = 1.0 ;
    }
	this.initialize(divid, progressid, modelpath, texturepath, floorpath, canvasWidth, canvasHeight, scale );

}

MirrimViz.prototype.initialize = function( divid, progressid, modelpath, texturepath, floorpath, canvasWidth, canvasHeight, scale ) {

    console.log( "Initialize mirrimviz object at: " +  divid ) ;

    var viz = this ;

    this.scene = new THREE.Scene();

    this.canvas = document.getElementById(divid) ;
    console.log( "canvas: " +  divid ) ;
    this.progressDiv = document.getElementById(progressid);

    var WIDTH  = canvasWidth ;
    var HEIGHT = canvasHeight;
   //var WIDTH = 260 ;
   //var HEIGHT = 260 ;
    console.log( "Width: " + WIDTH + "  Height: " + HEIGHT) ;
    this.renderer = new THREE.WebGLRenderer({antialias:true});
    this.renderer.setSize(WIDTH, HEIGHT);

    this.canvas.appendChild(this.renderer.domElement);

    // create and place camera
    this.camera = new THREE.PerspectiveCamera(75, WIDTH / HEIGHT, 0.1, 20000);
    this.camera.position.set(0, 4.75 ,4);
    this.camera.rotation.x = Math.PI / 2.0;
    this.scene.add(this.camera);

    // define resize listener

    window.addEventListener('resize', function() {
        viz.renderer.setSize(WIDTH, HEIGHT);
        viz.camera.aspect = WIDTH / HEIGHT;
        viz.camera.updateProjectionMatrix();
    });


    // set the background color of the scene
    this.renderer.setClearColor(0xa0a0a0, 1);

    // Create a light, set its position, and add it to the scene.
    var light = new THREE.DirectionalLight(0xffffff);
    light.position.set(-100,100,100);
    this.scene.add(light);

    // right side fill light
    var light1b = new THREE.PointLight(0xffff80, 1.0, 250);
    light1b.position.set(50,100,100);
    this.scene.add(light1b);

    // backlight
    var light2 = new THREE.PointLight(0xffffff);
    light2.position.set(100,100,-300);
    this.scene.add(light2);

    var floorGeometry = new THREE.PlaneGeometry( 10, 10 );
		floorGeometry.applyMatrix( new THREE.Matrix4().makeRotationX( - Math.PI / 2 ) );

    var floorTexture = new THREE.ImageUtils.loadTexture( floorpath ) ;
    floorTexture.wrapS = floorTexture.wrapT = THREE.MirroredRepeatWrapping ;
    floorTexture.repeat.x = 1 ;
    floorTexture.repeat.y = 1 ;
    var floorMaterial = new THREE.MeshPhongMaterial( { map: floorTexture, shininess: 60 } );

		plane = new THREE.Mesh( floorGeometry, floorMaterial );
		this. scene.add( plane );

    //var mapUrl = "models/mahaboweb_uvmap.png";
    var mapUrl = texturepath ;

    var map = THREE.ImageUtils.loadTexture(mapUrl, THREE.UVMapping);

    var material = new THREE.MeshPhongMaterial({ map: map, shininess: 10 });

  	var callbackProgress = function( progress, result ) {

        var message = "Loading..." ;
        if ( progress.total ) {
          message += ( 100 * progress.loaded / progress.total ).toFixed(0) + "%";
        } else {
          message += ( progress.loaded / 1000 ).toFixed(2) + " KB";
        }

        viz.progressDiv.innerHTML = message;

	}

    var loader = new THREE.JSONLoader();

    // loader.loadAjaxJSON( loader, "models/mahabo_final_flip.js", function(geometry){
    loader.loadAjaxJSON( loader, modelpath, function(geometry){

       viz.progressDiv.style.visibility = "hidden" ;
       viz.model = new THREE.Mesh(geometry, material);
       viz.model.scale.set( scale, scale, scale);

       geometry.computeBoundingBox();
       var bbox = geometry.boundingBox ;
       console.log( "bbox: " + JSON.stringify(bbox) ) ;
       viz.model.position.y = -(bbox.min.y  * scale);

       viz.scene.add(viz.model);

    }, './', callbackProgress);

    // add control
    this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
    this.controls.target.y = 3.5 ;
    this.controls.autoRotate = true ;
  // console.log( "initialization complete.");
}

MirrimViz.prototype.animate = function() {

    console.log("Animate");
    // Read more about requestAnimationFrame at http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
    requestAnimationFrame( this.animate);

    // Render the scene.
    this.renderer.render(this.scene, this.camera);
    if( this.controls != null ) {
        this.controls.update();
    }

}

MirrimViz.prototype.render = function() {

    // console.log( "render ..." + this.scene ) ;
    this.renderer.render(this.scene, this.camera);
    if( this.controls != null ) {
        this.controls.update();
    } else {
    	console.log( "this controls null " ) ;
    }
}
