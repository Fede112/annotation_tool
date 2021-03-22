var myCanvas, ctx, classifierImage, inputFilename, inputRois;
// var areasClickeadas;



function ImageClicked(e){
    console.log("clicked");
    var x = e.pageX - myCanvas.offsetLeft;
    var y = e.pageY - myCanvas.offsetTop;
    x /= myCanvas.width;
    y /= myCanvas.height;


    var tempPos = [x, y];
    areasClickeadas.push(tempPos);
    console.log(areasClickeadas[0]);
    places = 4,
    areasClickeadas_json = JSON.stringify(areasClickeadas, function(key, value) {
            // limit precision of floats
            if (typeof value === 'number') {
                return parseFloat(value.toFixed(places));
            }
            return value;
        });

    // console.log(x, y);
    inputRois.value = areasClickeadas_json;
    DrawCanvas();
}

function ClearAll(){
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    areasClickeadas = [];
    inputRois.value = "";
}



(function(){
    myCanvas = document.getElementById("myCanvas");
    ctx = myCanvas.getContext("2d");
    classifierImage = document.getElementById("classfierImage")
    myCanvas.addEventListener("click", ImageClicked);

    WaitImageLoad();
    console.log(myCanvas.width)
    console.log(classifierImage.height)
    
    // if (typeof inputRois.value == 'string') {console.log("is string");}

    
})();

function WaitImageLoad(){
    if(classifierImage.complete){
        classifierImage.addEventListener("load", function() {
        console.log("image has loaded");
        });
        ImageLoaded();
    }else{
        setTimeout(WaitImageLoad, 100)
    }
}

function ImageLoaded(){
    // console.log("Image Loaded");
    myCanvas.width = classifierImage.width;
    myCanvas.height = classifierImage.height;
    inputFilename = document.getElementById("inputFilename");
    inputRois = document.getElementById("inputRois");
    
    if(inputRois.value){
        areasClickeadas = JSON.parse(inputRois.value);
    }
    else{
        areasClickeadas = [];
    }
    console.log(areasClickeadas)
    DrawCanvas();

    // console.log("InputRois")
    // console.log(inputRois.value)
    

}

function DrawCanvas(){
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    ctx.strokeStyle = "red";
    ctx.lineWidth = 3;
    ctx.globalAlpha = .7;
    radius = 12;

    for(let i = 0; i < areasClickeadas.length; i++){
        ctx.beginPath();
        ctx.arc(areasClickeadas[i][0] * classifierImage.width,
                areasClickeadas[i][1] * classifierImage.height,
                radius, 0, 2*Math.PI)
        ctx.stroke();
    }
}



