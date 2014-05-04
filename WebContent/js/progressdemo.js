 /* Demo from treehouse.com
  * http://blog.teamtreehouse.com/the-beginners-guide-to-three-js
  */
// Set up the scene, camera, and renderer as global variables.
  var scene ;
  var camera;
  var renderer;
  var model ;
  var controls ;

  init();
  animate();


function init() {

	// Create the scene and set the scene size.
    scene = new THREE.Scene();
    var WIDTH = window.innerWidth ;
    var HEIGHT = window.innerHeight;
    console.log( "Width: " + WIDTH + "  Height: " + HEIGHT) ;
    renderer = new THREE.WebGLRenderer({antialias:true});
    renderer.setSize(WIDTH, HEIGHT);
    document.body.appendChild(renderer.domElement);
    // create and place camera
    camera = new THREE.PerspectiveCamera(70, WIDTH / HEIGHT, 0.1, 20000);
    camera.position.set(0,5,8);
    camera.rotation.x = Math.PI / 2.0;
    scene.add(camera);

    // define resize listener
    window.addEventListener('resize', function() {
        var WIDTH = window.innerWidth,
            HEIGHT = window.innerHeight;
        renderer.setSize(WIDTH, HEIGHT);
        camera.aspect = WIDTH / HEIGHT;
        camera.updateProjectionMatrix();
     });

    // set the background color of the scene
    // renderer.setClearColorHex(0x333F47, 1);
    renderer.setClearColor(0x404040, 1);
    //renderer.shadowMapEnabled = true ;
    //renderer.shadowMapSoft = true ;

    // Create a light, set its position, and add it to the scene.
    //var light = new THREE.PointLight(0xffffff);
    var light = new THREE.DirectionalLight(0xffffff);
    light.position.set(-100,100,100);
    //light.castShadow = true ;
    scene.add(light);
    // addShadowedLight( -100, 100, 100, 0xffffff, 1.0);

    // Create a light, set its position, and add it to the scene.
    var light1b = new THREE.PointLight(0xffff80, 1.0, 250);
    light1b.position.set(50,100,100);
    scene.add(light1b);

    var light2 = new THREE.PointLight(0xffffff);
    light2.position.set(100,100,-300);
    scene.add(light2);

    var floorGeometry = new THREE.PlaneGeometry( 10, 10 );
		floorGeometry.applyMatrix( new THREE.Matrix4().makeRotationX( - Math.PI / 2 ) );

    var oakTexture = new THREE.ImageUtils.loadTexture("models/parquet_rustic_oak.jpg");
    oakTexture.wrapS = oakTexture.wrapT = THREE.MirroredRepeatWrapping ;
    oakTexture.repeat.x = 4 ;
    oakTexture.repeat.y = 4 ;
    var floorMaterial = new THREE.MeshPhongMaterial( { map: oakTexture, shininess: 50 } );

		plane = new THREE.Mesh( floorGeometry, floorMaterial );
    //plane.receiveShadow = true ;
		scene.add( plane );
    // load in the mesh and add it to the scene

    var mapUrl = "models/mahaboweb_uvmap.png";
    var map = THREE.ImageUtils.loadTexture(mapUrl, THREE.UVMapping);
    //map.flipY = false ;
     console.log( "map flipY: " + map.flipY) ;

     var material = new THREE.MeshPhongMaterial({ map: map, shininess: 10 });

  	var callbackProgress = function( progress, result ) {

      console.log( "Loading progres...");
        console.log( JSON.stringify( progress));
      console.log( JSON.stringify( result));
        /*
					var bar = 250,
						total = progress.totalModels + progress.totalTextures,
						loaded = progress.loadedModels + progress.loadedTextures;

					if ( total )
						bar = Math.floor( bar * loaded / total );

					$( "bar" ).style.width = bar + "px";

					count = 0;
					for ( var m in result.materials ) count++;

					handle_update( result, Math.floor( count/total ) );
          */

		}

     var loader = new THREE.JSONLoader();

     //loader.callbackProgress = callbackProgress ;
     // loader.load( "models/mahabo_final_flip.js", function(geometry){
     loader.loadAjaxJSON( loader, "models/mahabo_final_flip.js", function(geometry){

      model = new THREE.Mesh(geometry, material);
      geometry.computeBoundingBox();
      var bbox = geometry.boundingBox ;
      console.log( "bbox: " + JSON.stringify(bbox) ) ;
      model.position.y = -(bbox.min.y);

      scene.add(model);
      console.log("Added mesh to scene");
    }, './', callbackProgress);

    // add control
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    //controls = new THREE.TrackballControls( camera, renderer.domElement) ;

}


function animate() {
	console.log("Animate");
    // Read more about requestAnimationFrame at http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
    requestAnimationFrame(animate);

    // Render the scene.
    renderer.render(scene, camera);
   if( controls != null ) {
      controls.update();
   }
}
