  <div id="SectionContainer">
    <h1>Kaleidoscope</h1>
    <p>Mirrors, mirrors, on the walls. Where am I in these mirrored halls?</p>
  </div>
  <div class="content">
    <p>Move the corners of the triangle to make your own kaleidoscope! </p>
    <div class="interactive widthlimit centered">
      <p><input type="text" width="300" id="URLLoader" name="URLLoader" placeholder="Paste an image url here"></input><input type="button" value="Load Image" onclick="handleURL();"></input></p>
      <p>Or upload one: <input type="file" accept="image/*" id="imageLoader" name="imageLoader" placeholder="Or Upload one"/></p>
      <canvas id="canvasOverlay" width="512" height="320"></canvas>
      <canvas id="canvasResult"  width="512" height="512"></canvas>
      <p><a href="#" id="downloadLink" onclick="downloadImage();" download="kaleidoscope.jpg">Download the image</a></p>
    </div>
    <p>You can get some especially interesting shapes if you make a really thin triangle.</p3>
    <p>The code works by taking the canvas and folding the outside-the-triangle part along each of the triangle edges (in order, repeatedly) until the entire canvas is inside the triangle. Then it prints the triangle image and displays the unfolded image. </p>
    <!--<p>If you find the kaleidoscope becomes sluggish or non-responsive, just reload the page.  If you know why that is happening, drop me a line!</p>-->
    <p>See the live source code <a href="/assets/articles/kaleidoscope/kscope.js">here</a>, especially the generateKaleidoscope() function.</p>
  </div>
  <div class="endFloat">&nbsp;</div></div>
  <script>
  var body = document.getElementsByTagName("body")[0];
  body.addEventListener("load", init(), false);
  </script>
