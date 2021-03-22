<?php

require './medoo/src/Medoo.php';
use Medoo\Medoo;

include 'config.php';
// Connect to database
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $config["dbname"],
    'server'        => 'localhost',
    'username'      => $config["dbuser"],
    'password'      => $config["dbpass"]
]);



if(isset($_POST["rois"])){
    // Update table
    $database->update('annotatedimages', [
        'roi'   => $_POST["rois"],
        'checked' => $_POST["checked"],
        'time'  => time()
    ], ['idx' => $_POST["idxPrev"]]);
}

// $_GET["idx"] = 1;
if(isset($_GET["idx"])){
    // Do the query
    $query = $database->select("annotatedimages", [
    "image", "roi"], ["idx" => $_GET["idx"]] );

    $imageName = $query[0]["image"]; 
    $imageRois = $query[0]["roi"]; 

    // print_r($imageName);
    // echo "<br/>";
} 
else{
    // echo "First entry, no $_GET['idx']";
    $query = $database->select(
    // table name
    'annotatedimages',
    // Columns
    ['image', 'roi', 'idx' => Medoo::raw('MIN(<idx>)')],
    // Where
    ["checked" => 0]

    );

    // if{isset{}}
    $_GET["idx"] = $query[0]["idx"];
    $imageName = $query[0]["image"]; 
    $imageRois = $query[0]["roi"]; 

    echo $imageName."<br/>";
    echo $imageRois."<br/>";

    
    // print_r($query[0]["idx"]);
    // echo "<br/>";

}

if(!isset($imagesCount)){
    $imagesCount = $database->count("annotatedimages");
    // echo "<br/>". $imagesCount;
}

 
// // Select all columns
// $datas = $database->select("account", "*");
 
// // Select a column
// $datas = $database->select("account", "user_name");
 

// select image, min(idx) as idx, checked from annotatedimages group by checked

// select image, min(idx) as idx, checked
// from annotatedimages where checked = 0

?>




<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Manual Classifier</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="#">
</head>

<body>
    <h1>Manual Classifier</h1>

    <?php

    echo ($_GET["idx"] -1) == $imagesCount;

    if( ($_GET["idx"] -1) == $imagesCount){
        echo "<h2>All images classified</h2>"; 
    }else{ 
    ?>
         <p>Click on image over the detected lesion. When done click <strong>Save Data</strong> button. </p>
         <p><?php echo $_GET["idx"] . "/" . $imagesCount . ": <strong>" . $imageName . "</strong>"; ?></p>
        <div id="imageContainer">
            <img id="classfierImage" src="./images/<?php echo $imageName ?>"/>
            <canvas id="myCanvas"></canvas>





            <div id="buttons">

                <?php
                $imageNextIdx = ($_GET["idx"]) % $imagesCount + 1 ;
                $imagePrevIdx = ($imagesCount + $_GET["idx"] - 2) % $imagesCount + 1;
                ?>

                <!-- htmlspecialchars() to avoid code injection -->
                <button onclick="window.location.href='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?idx=" . ($imagePrevIdx);?>'" type="button">Previous</button>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?idx=" . ($_GET["idx"] ); ?>" method="post"  style="display:inline-block;">
                    
                    <input id="inputIdxPrev"  type = "hidden" name="idxPrev" value= <?php echo $_GET["idx"] ?> />
                    <input id="inputRois"  type = "hidden" name="rois" value= "<?php echo $imageRois ?>"/>
                    <!-- Not changing checked value yet -->
                    <input id="inputChecked"  type = "hidden" name="checked" value="0"/>

                    <input type="submit" value="Save Data" />
                </form>

                <button onclick="window.location.href= '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?idx=" . ($imageNextIdx);?>'" type="button">Next</button>

                <button id="clearAll" onclick="ClearAll()">Clear all</button>
                
            </div>
        </div>
    
    <?php } ?>



    <script src="script.js">    
    </script>

   
</body>

</html>
