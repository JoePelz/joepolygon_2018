  <div id="SectionContainer">
    <h1>Edge Trigger</h1>
    <p>No, I don't mean a sex move</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/edgeTrigger/edgeTrigger.png"></div>
    <p>In my computer architecture class we spent a fair bit of time on circuits used in the computer, including how memory circuits work.  It's really cool and kind of mind-bending that it works at all.  The goal of a bit of digital memory is three fold:</p>
    <div class="widthLimit">
      <ol><li>To be able to set a memory bit high or low.
      </li><li>For the memory to continue to stay high or low without having to be held there.
      </li><li>To be able to retrieve the value of the memory without disrupting it.
      </li></ol>
    </div>
    <p>First try: the <span class="bold">SR latch</span>.</p>
    <div class="center"><img src="/assets/articles/edgeTrigger/sr.png"></div>
    <p>The SR latch is nice and simple (and cheap) but R and S could be asynchronous, and if both are on the output is inconsistent.</p>
    <p>Second try: the <span class="bold">Unclocked D latch</span>.</p>
    <div class="center"><img src="/assets/articles/edgeTrigger/unclockedD.png"></div>
    <p>Now there's a single input, which fixes the problem of asynchronous input, but Q is always equal to D. Our second requirement is broken.</p>
    <p>Third try: the <span class="bold">Clocked D latch</span>.</p>
    <div class="center"><img src="/assets/articles/edgeTrigger/clockedD.png"></div>
    <p>Now the value is only set (based on D) when the clock signal is pulsed. Much improved. However, the clock signal tends to be high for about half the time, so it would be better if we could limit updating the circuit to the instant the clock signal turns high.</p>
    <p>Fourth try: the <span class="bold">D Flip-Flop</span>.</p>
    <div class="center"><img src="/assets/articles/edgeTrigger/flipFlop.png"></div>
    <p>This uses an edge trigger, which isolates the instant that the clock signal turns high.</p>
    <div class="center"><img src="/assets/articles/edgeTrigger/edgeTrigger.gif"></div>
    <p>In the diagram above, yellow represents the electrical signal being "high" and no yellow represents "low."</p>
    <p>Looking at the circuit, I wouldn't have expected it to work.  But it does.  The edge trigger will activate at all because it takes the electric signal slightly longer to go through the gate than it takes to go through the wire.</p>
    <p>Modern memory circuits probably don't use this particular flip-flop anymore; nevertheless, it is an interesting topic to explore and programming/animating the circuitry helped me to understand it thoroughly.</p>
    <p>Download the jar file <a type="application/java-archive" href="/assets/articles/edgeTrigger/edgeTrigger.jar" download>here</a></p>
  <div class="endFloat">&nbsp;</div></div>
