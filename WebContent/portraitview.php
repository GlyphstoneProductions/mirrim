<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<title>Mirrim portrait viewer</title>
<meta charset="utf-8">
</head>
<body style="margin: 0;">

<div style="text-align: center;" > Mirrim 3d Portraits</div>
<div id="progress" style="text-align: center;" ></div>
<div id="3dcanvas" >3d Canvas here</div>

<?php
    $path = $_SERVER['PATH_INFO'] ;
    $query = $_SERVER['QUERY_STRING'] ;
    $pnum = $_GET["pn"] ;
    $user = $_GET["user"] ;

    echo "<h1> alias: $path</h1>\n" ; echo "<h2> query: $query </h2>\n" ;
?>

    <script >
       var path = '<?php echo $pnum?>';
       var user = '<?php echo $user?>';
       console.log("executing script with path:");
       console.log(path);
       console.log("User:");
       console.log(user ) ;
    </script>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="js/three.js"></script>
    <script type="text/javascript" src="js/OrbitControls.js"></script>
    <script type="text/javascript" src="js/TrackballControls.js"></script>
    <script type="text/javascript" src="js/portraitviewer.js"></script>
</body>
</html>




