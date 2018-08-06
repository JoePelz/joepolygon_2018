  <div id="SectionContainer">
    <h1>Maze Generator</h1>
    <p>Minotaurs wanted: apply within</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/mazeGenerator/maze2gamma.jpg"></div>
    <p>So despite the console output above, I had just started working with 3D graphics in OpenGL.  I did several of the tutorials at <a href="http://www.opengl-tutorial.org">opengl-tutorial.org</a>. Most of it was pretty straight forward, most likely due to my understanding of 3D from working in the Visual Effects industry.  The most difficult part of it all was trying to get the damned thing to compile, link, and run within Visual Studio.  I had only used Visual Studio once before to write a Windows 8 calculator app, and had never adjusted environment variables and compiler directives before.  It was a frustrating mess.  But! Eventually I got my dependencies compiled and linked, and could move forward.</p>
    <p>At one point in the year a friend of mine had nostalgically mentioned that old windows screensaver that involved the computer walking through a maze. You remember it, right?</p>
    <div class="center"><img src="/assets/articles/mazeGenerator/3dMaze.jpg"></div>
    <p>I realized that I could build an entire maze game with the cube I had been playing with.  For rapid prototyping, I went back to my usual text editor and command line compiler, and thought about generating mazes.  I had read Mike Bostock’s blog article on <a href="http://bost.ocks.org/mike/algorithms/#maze-generation">maze generation</a> a while ago and put together a maze algorithm of my own.</p>
    <div class="center"><img src="/assets/articles/mazeGenerator/consoleMaze.jpg"></div>
    <p>My algorithm ended up being a simple depth-first random-walk.  Exploring a maze in 3d is already confusing and difficult enough to navigate, without the trouble of any loops or complex structure.</p>
    <p>With that done, I took the code into visual studio and used it to direct the placement of walls, flooring, and Pacman-esque trail markers.</p>
    <div class="center"><figure><img src="/assets/articles/mazeGenerator/maze1.jpg"><figcaption>Mission accomplished!</figcaption></figure></div>
    <p>Download the 3D windows program <a type="application/x-7z-compressed" href="/assets/articles/mazeGenerator/maze.7z" download>here</a></p>
    <p>Download the console maze code <a type="application/x-7z-compressed" href="/assets/articles/mazeGenerator/mazeGen.7z" download>here</a></p>
  <div class="endFloat">&nbsp;</div></div>
