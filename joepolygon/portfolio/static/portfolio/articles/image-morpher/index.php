  <div id="SectionContainer">
    <h1>Image Morpher</h1>
    <p>It's the Mighty Morphin Pixel arRangers</p>
  </div>
  <div class="content">
    <p>This project was a lot of fun!  It is an Android app that lets you morph one picture into another picture by drawing a set of control lines on the image.  During development I made so many fun morphs of friends into other friends or animals, or even inanimate objects that look like they have a face.</p>
    <p>Basically there are three screens:</p>
    <div class="center"><img src="/assets/articles/imageMorpher/morpherLines.jpg"></div>
    <p>Here you load and switch between two images at the top, and in the center you can draw lines to mark the features you want to morph.  The interface is fully my own design and I’m quite proud of how effective it is.  The need was to display the two images, load new images, be able to draw lines easily, and save/open projects.</p>
    <div class="widthLimit"><ul>
    <li>Add lines by drawing in empty space, adjust lines by pulling the points, and delete lines by dragging them off the image.
    </li><li>See which line is which because the selected one turns blue in all places.
    </li><li>Switch between images by touching the picture at the top, and if you touch an image twice, it gives you a menu to open a new image, or pull from the camera.
    </li></ul></div>
    <div class="center"><img src="/assets/articles/imageMorpher/morpherSetup.png"></div>
    <p>The morphing itself uses a combination of parametric equations and the position of a pixel relative to each line segment, with a weighting based on line distance and falloff.  I wanted to empower the user to adjust the values and control how the morphing is done, so I included this rendering screen before viewing the result.</p>
    <p>Pixel-by-pixel computation can take up to ten minutes with one thread and full resolution; however, the code is optimized to use all available cores at 512x512 resolution and interpolate some of the morphing values to bring the morph-time down to something negligible.</p>
    <div class="center"><img src="/assets/articles/imageMorpher/morpherAnim.gif"></div>
    <p>Done! Now you have a sequence of images animating the morph from one image to the other.  There are a couple buttons at the bottom of the screen to frame left and right, but the main way you view the animation is just sliding your finger across the image left and right.  It’s so slick to use! It’s really smooth and satisfying, although you might not even notice it while you’re laughing at the morph you just made.</p>
    <p>The app is not published in the app store, but the Android Studio project is available freely <a href="https://github.com/JoePelz/ImageMorpher">on GitHub</a>.</p>
  <div class="endFloat">&nbsp;</div></div>
