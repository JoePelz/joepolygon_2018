var canvas;
var ctx;
var canvas2;
var ctx2;
var canvasOffscreen
var ctxOffscreen;
var resultData;
var imageData;
var bg; //Image object

var srcWidth = 512;
var srcHeight = 320;
var destWidth = 512;
var destHeight = 512;

var x1, y1;
var x2, y2;
var x3, y3;
var xm, ym;
var mdown;  //button is down for dragging
var selected;
var offsetX, offsetY;
var radius = 10; //radius of vertices for drawing
var threshold = 400; //radius^2 of vertices for selection

function init() {
  canvas = document.getElementById("canvasOverlay");
  canvas.addEventListener('mousedown', mousedown);
  canvas.addEventListener('mousemove', mousemove);
  canvas.addEventListener('mouseup', mouseup);
  canvas.addEventListener('touchstart', touchdown);
  canvas.addEventListener('touchmove', touchmove);
  canvas.addEventListener('touchend', mouseup);
  ctx = canvas.getContext("2d");
  canvas2 = document.getElementById("canvasResult");
  ctx2 = canvas2.getContext("2d");

  canvasOffscreen = document.createElement("canvas");
  canvasOffscreen.width = srcWidth;
  canvasOffscreen.height = srcHeight;
  ctxOffscreen = canvasOffscreen.getContext("2d");
  resultData = ctx2.getImageData(0,0,canvas2.width, canvas2.height);

  var imageLoader = document.getElementById('imageLoader');
  imageLoader.addEventListener('change', handleUpload, false);

  x1 = 120;
  y1 = 120;
  x2 = 240;
  y2 = 120;
  x3 = 180;
  y3 = 200;
  mdown = false;
  selected = 0;

  bg = new Image();
  bg.onload = imageLoaded;
  bg.src = '/assets/articles/kaleidoscope/barbie.jpg';
}


//=============================
//Image file handling functions
//=============================
function imageLoaded() {
  bg.style.display = 'none';
  makeImageFit();
  paintCanvas();
  generateKaleidoscope();
};

function makeImageFit() {
  var w = bg.naturalWidth;
  var h = bg.naturalHeight;
  var scaleForW = srcWidth / w;
  var scaleForH = srcHeight / h;

  if (scaleForW > scaleForH) {
    ctxOffscreen.drawImage(bg, 0, 0, Math.floor(w * scaleForW), Math.floor(h * scaleForW));
  } else {
      ctxOffscreen.drawImage(bg, 0, 0, Math.floor(w * scaleForH), Math.floor(h * scaleForH));
  }


  imageData = ctxOffscreen.getImageData(0,0,canvasOffscreen.width, canvasOffscreen.height);
}

function handleUpload(e) {
  var reader = new FileReader();
  reader.onload = function(event){
    bg = new Image();
    bg.onload = imageLoaded;
    bg.src = event.target.result;
  };
  reader.readAsDataURL(e.target.files[0]);
  var URLLoader = document.getElementById('URLLoader');
  URLLoader.value = "";
}

function handleURL() {
  var URLLoader = document.getElementById('URLLoader');
  var xi=new XMLHttpRequest();
  xi.open("GET","/assets/articles/kaleidoscope/getImage.php?url="+encodeURI(URLLoader.value),true);
  xi.send();

  xi.onreadystatechange=function() {
    if(xi.readyState==4 && xi.status==200) {
      bg=new Image;
      bg.onload = imageLoaded;
      bg.src=xi.responseText;
    }
  }

  var imageLoader = document.getElementById('imageLoader');
  imageLoader.value = "";
}

function downloadImage() {
  var link = document.getElementById("downloadLink");
  var image = canvas2.toDataURL("image/jpeg", 0.9);
  link.href=image;
  return true;
}


//=====================================
//Mouse and touch interaction functions
//=====================================

function touchdown(event) {
  var rect = canvas.getBoundingClientRect();
  xm = event.touches[0].clientX - rect.left;
  ym = event.touches[0].clientY - rect.top;

  if (((x1 - xm) * (x1 - xm) + (y1 - ym) * (y1 - ym)) < threshold) {
    event.preventDefault();
    mdown = true;
    selected = 1;
    offsetX = x1 - xm;
    offsetY = y1 - ym;
  } else if (((x2 - xm) * (x2 - xm) + (y2 - ym) * (y2 - ym)) < threshold) {
    event.preventDefault();
    mdown = true;
    selected = 2;
    offsetX = x2 - xm;
    offsetY = y2 - ym;
  } else if (((x3 - xm) * (x3 - xm) + (y3 - ym) * (y3 - ym)) < threshold) {
    event.preventDefault();
    mdown = true;
    selected = 3;
    offsetX = x3 - xm;
    offsetY = y3 - ym;
  }
}

function touchmove(event) {
  if (mdown == true) {
    event.preventDefault();
    var rect = canvas.getBoundingClientRect();
    xm = event.touches[0].clientX - rect.left;
    ym = event.touches[0].clientY - rect.top;
    if (selected == 1) {
      x1 = xm + offsetX;
      y1 = ym + offsetY;
    } else if (selected == 2) {
      x2 = xm + offsetX;
      y2 = ym + offsetY;
    } else if (selected == 3) {
      x3 = xm + offsetX;
      y3 = ym + offsetY;
    }
    paintCanvas();
  }
}

function mousedown(event) {
  var rect = canvas.getBoundingClientRect();
  xm = event.clientX - rect.left;
  ym = event.clientY - rect.top;


  if (((x1 - xm) * (x1 - xm) + (y1 - ym) * (y1 - ym)) < threshold) {
    mdown = true;
    selected = 1;
    offsetX = x1 - xm;
    offsetY = y1 - ym;
  } else if (((x2 - xm) * (x2 - xm) + (y2 - ym) * (y2 - ym)) < threshold) {
    mdown = true;
    selected = 2;
    offsetX = x2 - xm;
    offsetY = y2 - ym;
  } else if (((x3 - xm) * (x3 - xm) + (y3 - ym) * (y3 - ym)) < threshold) {
    mdown = true;
    selected = 3;
    offsetX = x3 - xm;
    offsetY = y3 - ym;
  }
}

function mouseup(event) {
  mdown = false;
  selected = 0;
  generateKaleidoscope();
}

function mousemove(event) {
  if (mdown == true) {
    var rect = canvas.getBoundingClientRect();
    xm = event.clientX - rect.left;
    ym = event.clientY - rect.top;
    if (selected == 1) {
      x1 = xm + offsetX;
      y1 = ym + offsetY;
    } else if (selected == 2) {
      x2 = xm + offsetX;
      y2 = ym + offsetY;
    } else if (selected == 3) {
      x3 = xm + offsetX;
      y3 = ym + offsetY;
    }
    paintCanvas();
    generateKaleidoscope();
  }
}


//==================
//Painting functions
//==================

function paintCanvas() {
  //ctx.drawImage(bg, 0, 0);
  ctx.putImageData(imageData, 0, 0);
  drawLinks();
  drawNode(x1, y1);
  drawNode(x2, y2);
  drawNode(x3, y3);
}

function drawLinks() {
  ctx.beginPath();
  ctx.lineWidth = 3;
  ctx.strokeStyle = "#FFFF00";
  ctx.moveTo(x1, y1);
  ctx.lineTo(x2, y2);
  ctx.lineTo(x3, y3);
  ctx.lineTo(x1, y1);
  ctx.stroke();
}

function drawNode(x, y) {
  ctx.beginPath();
  ctx.arc(x,y,radius,0,2*Math.PI);
  ctx.fillStyle = "#AACCFF";
  ctx.fill();
  ctx.lineWidth = 2;
  ctx.strokeStyle = "#000000";
  ctx.stroke();
}


//==========================
//Main kaleidoscope function
//==========================

function generateKaleidoscope() {
  //image-wide constants
  var slopeAC = (x3-x1) != 0 ? (y3-y1) / (x3-x1) : (y3 > y1 ? 1000 : -1000);
  var slopeCB = (x2-x3) != 0 ? (y2-y3) / (x2-x3) : (y2 > y3 ? 1000 : -1000);
  var slopeBA = (x2-x1) != 0 ? (y2-y1) / (x2-x1) : (y2 > y1 ? 1000 : -1000);
  var offsetAC = y1 - slopeAC*x1;
  var offsetCB = y3 - slopeCB*x3;
  var offsetBA = y1 - slopeBA*x1;
  var condAC = y2 < slopeAC * x2 + offsetAC;
  var condCB = y1 < slopeCB * x1 + offsetCB;
  var condBA = y3 < slopeBA * x3 + offsetBA;

  //reflecting loop
  var source = 0;
  var dest = 0;
  var d, cond, any;
  var sx, sy;
  for (var y = 0; y < destHeight; y += 1) {
    for (var x = 0; x < destWidth; x += 1) {
      dest = x * 4 + y * 4 * destWidth;
      sx = x;
      sy = y;
      any = true;
      maxIter = 20;

      while (any && maxIter-- > 0) {
        any = false;
        //reflect over 1->3
        d = (sx + (sy - offsetAC) * slopeAC) / (1 + slopeAC * slopeAC);
        cond = condAC ? sy > slopeAC * sx + offsetAC : sy < slopeAC * sx + offsetAC;
        sx = cond ? 2 * d - sx : sx;
        sy = cond ? 2 * d * slopeAC - sy + 2 * offsetAC : sy;
        if (cond) { any = true; }

        //reflect over 2->3
        d = (sx + (sy - offsetCB) * slopeCB) / (1 + slopeCB * slopeCB);
        cond = condCB ? sy > slopeCB * sx + offsetCB : sy < slopeCB * sx + offsetCB;
        sx = cond ? 2 * d - sx : sx;
        sy = cond ? 2 * d * slopeCB - sy + 2 * offsetCB : sy;
        if (cond) { any = true; }

        //reflect over 2->1
        d = (sx + (sy - offsetBA) * slopeBA) / (1 + slopeBA * slopeBA);
        cond = condBA ? sy > slopeBA * sx + offsetBA : sy < slopeBA * sx + offsetBA;
        sx = cond ? 2 * d - sx : sx;
        sy = cond ? 2 * d * slopeBA - sy + 2 * offsetBA : sy;
        if (cond) { any = true; }
      }


      source = Math.floor(sx) * 4 + Math.floor(sy) * 4 * srcWidth;
      if (sx < 0 || sy < 0 || sx >= srcWidth || sy >= srcHeight) {
        resultData.data[dest] = 0;
        resultData.data[dest+1] = 0;
        resultData.data[dest+2] = 0;
        resultData.data[dest+3] = 255;
      } else {
        resultData.data[dest]   = imageData.data[source];
        resultData.data[dest+1] = imageData.data[source+1];
        resultData.data[dest+2] = imageData.data[source+2];
        resultData.data[dest+3] = imageData.data[source+3];
      }

    }
  }
  //set pixels to result
  ctx2.putImageData(resultData, 0, 0);
}
