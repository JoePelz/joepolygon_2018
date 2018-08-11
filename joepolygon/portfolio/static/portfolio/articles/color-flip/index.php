  <div id="SectionContainer">
    <h1>Color Flip Puzzle</h1>
    <p>Because the next time I invent the wheel it will be better!</p>
  </div>
  <div class="content">
    <p>I've remade this game from scratch in almost every language I've spent any significant amount of time using.  I've remade it now in Python, JavaScript, Elm, Java, and even in C with Win32. Each time I build it though, it's a little bit different.</p>
    <p>Normal rules toggle a "+" shape around a clicked point between red and yellow in a 5x5 square grid. This version adds a third color just to make it little more fun.</p>
    <p>You can get from all yellow to all blue in 5 clicks.  There is a x/y symmetric pattern for getting from all yellow to all red in 10 clicks.</p>
    <div class="interactive widthlimit centered"><div id='puzzlebox' class="centered"></div></div>
    <div class="widthLimit">
      <figure class="center widthlimit floatLeft">
        <img src="/assets/articles/colorFlip/challenge1.png" width="100" height="100">
        <figcaption>Challenge 1 - 18 clicks</figcaption>
      </figure>
      <figure class="center widthlimit floatLeft">
        <img src="/assets/articles/colorFlip/challenge2.png" width="100" height="100">
        <figcaption>Challenge 2 - 14 clicks</figcaption>
      </figure>
    </div>
  <div class="endFloat">&nbsp;</div></div>
  <script>
  var div = document.getElementById('puzzlebox');
  Elm.embed(Elm.PuzzleGame, div);
  </script>
