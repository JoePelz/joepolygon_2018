  <div id="SectionContainer">
    <h1>Nuke Expressions</h1>
    <p>Searching for how to build nuke nodes has probably landed me on a watch list somewhere</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/nukeExpressions/mergeExpression.png"></div>
    <p>Nuke expressions are so cool.  It took me a while to understand how to use them but they are really powerful in what they can do.  What they let you do is provide an equation for each pixel of the image. You have access to several built in variables, and the ability to define a few of your own.  There's a library of built in functions you have access too as well.  And it runs fast too!</p>
    <p>A (non-comprehensive) rundown of the tools in the expression node are:</p>
    <div class="widthLimit">
      <ul>
        <li>Access to built-in variables <span class="italic">r, g, b, a, x, y, frame, width, height</span></li>
        <li>A built-in library of functions (<a href="http://www.nukepedia.com/reference/Tcl/group__tcl__expressions.html">listed here</a>)
        <li>Access to other channels by their full <span class="italic">layer.channel</span> name, such as <span class="italic">depth.Z</span></li>
        <li>Access to other nodes and their attributes via <span class="italic">[value Transform2.translate.x]</span></li>
        <li>Conditional values via the tertiary format: <span class="italic">condition ? trueValue : falseValue</span></li>
        <li>And my favorite: <span class="italic">channel(x, y)</span> to sample the color of other pixels, including interpolated subpixel values</li>
      </ul>
    </div>
    <p>Finally! All the simple image manipulations imagined in my mind, I could easily create! So many things are easier and simpler to me, when I just use an expression.</p>
    <p>Need to invert the alpha and change its gradient direction? Put this in the alpha channel of an expression node</p>
    <div class="widthLimit"><ol class="code">
      <li>1 / (1 - a)</li>
    </ol></div>
    <p>Need a linear-falloff circle shape?</p>
    <div class="widthLimit"><ol class="code">
      <li>posX    = 200</li>
      <li>posY    = 350</li>
      <li>radius  = 100</li>
      <li>dist    = sqrt((x - posX)**2 + (y - posY)**2)</li>
      <li></li>
      <li>rgba = clamp(1 - dist/radius, 0, 1)</li>
    </ol></div>
    <div class="widthLimit center"><img src="/assets/articles/nukeExpressions/circle.jpg"></div>
    <p>One expression I used recently was to ease into scaling an image to the left of a particular x coordinate. It went like this:</p>
    <div class="widthLimit"><ol class="code">
      <li>offset = 400</li>
      <li>factor = 0.9</li>
      <li>valid  = x < offset</li>
      <li>newX   = -(abs(x - offset) ** factor) + offset</li>
      <li></li>
      <li>r = valid ? r(newX, y) : r</li>
      <li>g = valid ? g(newX, y) : g</li>
      <li>b = valid ? b(newX, y) : b</li>
      <li>a = valid ? a(newX, y) : a</li>
    </ol></div>
    <div class="widthLimit center"><img src="/assets/articles/nukeExpressions/transform.jpg"></div>
    <p>You can take it pretty far with expressions. I built a mandelbrot fractal and kaleidoscope nodes out of expressions.  The kaleidoscope was particularly fun to play with.</p>
    <div class="widthLimit center"><img src="/assets/articles/nukeExpressions/kaleidobrot.jpg"></div>
    <p>In summary, nuke nodes are fun. They're worth learning to use and being played around with. They can do some really powerful things if you have the math mind to express what you're trying to do.</p>
    <p>Download my collection of saved nuke gizmos <a type="application/x-7z-compressed" href="/assets/articles/nukeExpressions/gizmos.7z" download>here</a> for your fun and learning.  Nuke is available for <a href="http://www.thefoundry.co.uk/products/nuke/non-commercial/">free for non-commercial purposes</a> as of mid-2015. Yay!</p>
  <div class="endFloat">&nbsp;</div></div>
