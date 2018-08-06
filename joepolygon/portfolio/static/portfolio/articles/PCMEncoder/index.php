  <div id="SectionContainer">
    <h1>PCM Encoder</h1>
    <p>Get the secret PCM Decoder ring free by mailing in 10 box tops</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/PCMEncoder/PCMEncoderCrop.jpg"></div>
    <p>One of my courses at BCIT was Data Communications, which focussed mainly on the bottom 3 layers of the TCP/IP stack.  One of the things we covered was converting between digital and analog signals.  PCM stands for Pulse Code Modulation and covers the conversion from analog to digital.</p>
    <p>As we talked about simple waves, composite waves, sampling rates, bit rates, and quantization, I realized that this was the perfect case for an interactive tool that would explore the relation between them all.  The majority of the program was built over a weekend, and all in all it was one of the smoothest projects I’ve ever developed, with no significant bugs or issues.</p>
    <div class="center"><img src="/assets/articles/PCMEncoder/PCMEncoder.png"></div>
    <div class="widthLimit"><ol>
      <li>The first pane shows your <span class="bold">frequency domain plot</span>.  These control your input to the encoder.  Click in a blank space to add a new frequency, and click on an existing bar to change it’s frequency, amplitude, or phase.</li>
      <li>The second pane shows the <span class="bold">input wave form</span>.  Click it to toggle between simple waves overlaid, and a composite wave signal.</li>
      <li>The third pane shows <span class="bold">sampling frequency</span> during PCM. The slider above lets you choose the number of samples per second.  Nyquist’s law indicate’s the minimum sampling rate be 2x the highest frequency in the input. Your standard mp3 uses 44,100 samples per second.</li>
      <li>The fourth panel shows the <span class="bold">quantized wave</span>, based on the samples above. The quantization steps are calculated from the number of bits per sample.  Your standard mp3 uses 16 bits per sample, or 2^16 = 65536 quantization levels.</li>
      <li>The final panel shows the <span class="bold">reconstructed signal</span>. It takes the quantized form above and smooths the stair-stepping to approximate the original input.</li>
    </ol></div>
    <p>Download the jar file <a type="application/java-archive" href="/assets/articles/PCMEncoder/PCMEncoder.jar" download>here</a></p>
    <p>Download the source code <a type="application/x-7z-compressed" href="/assets/articles/PCMEncoder/PCMEncoder.7z" download>here</a></p>
  <div class="endFloat">&nbsp;</div></div>
