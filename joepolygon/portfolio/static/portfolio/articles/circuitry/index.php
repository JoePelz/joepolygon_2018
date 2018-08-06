  <div id="SectionContainer">
    <h1>Circuitry</h1>
    <p>Was I supposed to cut the red wire or the blue wire?</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/circuitry/circuitsBig.jpg"></div>
    <p>At BCIT, two of the courses I took were Discrete Mathematics and Computer Architecture.  Both of those courses got into the Boolean logic and gates.  We talked about a few different circuits: adders, multiplexers and decoders, memory circuits, an ALU.  Inevitably, one of the tasks I had to do was trace the path a signal took through a circuit and identify which outputs would be asserted.  It felt very tedious, it had very strict set of rules, and it was error-prone.  Perfect job for a computer to do.</p>
    <p>So I started building a program to calculate the output of circuits for me, with some interactive possibilities.  This required some way to represent the different circuits to the computer, so I decided to take it farther and make a reusable node API for circuits. After some though about what I wanted it to be able to do, I came up with this set of goals for what the user would be able to do:</p>
    <div class="widthLimit"><ul>
      <li>See a graphical representation of each gate and the links</li>
      <li>Indicate which gates/wires were activated</li>
      <li>Pan across the circuit</li>
      <li>Zoom in and out</li>
      <li>Click an input to activate/deactivate it</li>
      <li>Switch between prebuilt circuits via a drop-down menu</li>
      <li>Auto-focus (zoom/pan) on the circuit based on the area of interest it covers</li>
    </ul></div>
    <p>Programmatically, I wanted to be able to write a circuit by typing something like:</p>
    <div class="widthLimit"><ol class="code">
      <li>andgate = <span class="keyword">new</span> GateAnd(x, y)</li>
      <li>input1 = <span class="keyword">new</span> Input(x, y)</li>
      <li>input2 = <span class="keyword">new</span> Input(x, y)</li>
      <li>output1 = <span class="keyword">new</span> Output(x, y)</li>
      <li>Link(input1, andgate)</li>
      <li>Link(input2, andgate)</li>
      <li>Link(andgate, output1)</li>
    </ol></div>
    <p>So I set that as my mission and started programming.  The resulting function signatures were a little longer, to be able to specify specific gate ports, scale factors, and link path shapes. The actual code equivalent to the above, looks like this:</p>
    <div class="widthLimit"><ol class="code">
      <li>input1 = <span class="keyword">new</span> GateInput(0,   0, 3, GateState.OFF);</li>
      <li>input2 = <span class="keyword">new</span> GateInput(0, 100, 3, GateState.ON);</li>
      <li>andgate = <span class="keyword">new</span> GateAnd(150, 50, 3);</li>
      <li>output1 = <span class="keyword">new</span> GatePin(300, 50, 3);</li>
      <li></li>
      <li>Gate.connect(input1, -1, andgate, 0, Link.HVH);</li>
      <li>Gate.connect(input2, -1, andgate, 1, Link.HVH);</li>
      <li>Gate.connect(andgate, -1, output1, -1);</li>
      <li></li>
      <li>output1.setLabel(<span class="string">"Output"</span>);</li>
      <li>output1.setLabelSide(GatePin.NW);</li>
    </ol></div>
    <div class="center"><img src="/assets/articles/circuitry/andGate.png"></div>
    <p>Specifying my goal at the outset really helped me achieve what I wanted, and design something usable.  I feel proud of the API I ended up with, and I reused it once already creating a binary tree visualizer.</p>
    <p>Download the jar file <a type="application/java-archive" href="/assets/articles/circuitry/circuitry.jar" download>here</a></p>
  <div class="endFloat">&nbsp;</div></div>
