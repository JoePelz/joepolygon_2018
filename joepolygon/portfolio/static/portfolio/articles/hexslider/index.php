  <div id="SectionContainer">
    <h1>Generating Words and Language</h1>
    <p>Lorem ipsum dolor sit amet.</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/generatingLanguage/link.png"></div>
    <p>Generating random words and sentences has been an interest of mine for a while now.  I’ve taken a few different approaches would like to share what I’ve come up with.</p>
    <p>One of the first, and simplest methods is just to generate a list of what letters are allowed to be followed by what other letters.   You could do it all manually, but it’s much faster to pre-parse a dictionary such as <a href="/assets/articles/generatingLanguage/dictionary.txt">this one</a> (1.7MB, 170,000 words).  Interestingly, once the dictionary was processed, it became a mere 10KB <a href="/assets/articles/generatingLanguage/letterFollows.json">rulebook</a>.</p>
    <div class="centered widthLimit interactive">
      <div class="button" onclick="getRandomWordFromLetters('randomWordFromLetters')">Generate random words from letters</div>
      <div><ul id="randomWordFromLetters"><li>...</li></ul></div>
    </div>
    <p>An alternative approach is to break word down into chunks, larger than single letters.  For this experiment, I took the words in the dictionary and split them around vowels and consonants, so flagellum would become fl*a*g*e*ll*u*m, and then grouped them into clusters of 4, as: flage, agell, gellu, ellum.  From there, the algorithm builds words by matching the start of a new fragment to the end of the existing word.  This seems to produce more readable and pronounceable words but the rulebook ends up being significantly larger at 1.2MB.</p>
    <div class="centered widthLimit interactive">
      <div class="button" onclick="getRandomWordFromFragments('randomWordFromFragments')">Generate random words from fragments</div>
      <div><ul id="randomWordFromFragments"><li>...</li></ul></div>
    </div>
    <p>One particularly fun and successful approach was to take a list of latin <a href="https://msu.edu/~defores1/gre/roots/gre_rts_afx1.htm">prefixes</a>, <a href="https://msu.edu/~defores1/gre/roots/gre_rts_afx2.htm">roots</a>, and <a href="https://msu.edu/~defores1/gre/roots/gre_rts_afx3.htm">suffixes</a>, and then mix and match. In the case of consonants at the fragment boundaries, I added an extra i, o, or u.  As a bonus, each word comes with a definition!</p>
    <div class="centered widthLimit interactive">
      <div class="button" onclick="getRandomLatin('randomLatin')">Build random latin words</div>
      <div><ul id="randomLatin"><li>...</li></ul></div>
    </div>
    <p>One more here, just for giggles.  It uses a custom dictionary to generate its results. The main issue with its results is that they are based on grammar rules and word types (noun, adverb, etc) but the results don’t always make sense.  Not all nouns are capable of performing all actions, but the program doesn’t distinguish between types of nouns in that way.  Mirrors can reflect, but cannot swim; airplanes can fly, but cannot skydive.</p>
    <div class="centered widthLimit interactive">
      <div class="button" onclick="getRandomIntrigue('randomIntrigue')">Random intrigue...</div>
      <div><ul><li id="randomIntrigue">...?</li></ul></div>
    </div>
    <p>As far as <span class="italic">entirely</span> random sentences go, how do you classify words in such a way as to be able to make sense?  Maybe a program needs to pre-parse a few books to determine what words come after what other words, or what groups of words commonly show up together, but even that is imitation, not invention.  It’s definitely a question I plan to revisit at some point.</p>
  <div class="endFloat">&nbsp;</div></div>
