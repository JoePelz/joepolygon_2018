  <div id="SectionContainer">
    <h1>Hamming Code</h1>
    <p>Becau7se aXdding pu}rely *random chaQracters doesn'2t increasPe reBliabili!ty</p>
  </div>
  <div class="content">
    <p>In my Computer Architecture class and my Data Communications classes we discussed the fact that sometimes people mishear each other and don't realize it. Or more technically, when you're receiving information, how do you know if you're receiving correctly what the sender sent you?  That's the motivation for error detecting/correcting codes. There's a variety of codes, with checksums possibly being the most well known, but we had studied Hamming Code in the most detail when I built this.</p>
    <p>Hamming code works at the bit level and adds approximately log<sub>2</sub><span class="italic">n</span> additional bits to an <span class="italic">n</span>-bit data word. It will detect an error if at most 2 bits are corrupted, and can be used to correct an error if a single bit is corrupted.</p>
    <p>See if you can figure out how it works by typing some bits below. Yellow bits are the ones you typed, blue bits are parity bits that are added in, and red bits are bits where an error has been detected.  The numbers below the bits are the powers of two that comprise that bit's place.  Answer below.</p>
    <div class="interactive widthlimit centered"><div id='puzzlebox' class="centered"></div></div>
    <h2 onclick="toggleCollapse('answer');" class="collapser">How it works</h2>
    <div class="collapsing collapsed widthLimit" onclick="toggleCollapse('answer')" id="answer">
      <p>For every bit, if it's place is a power of two a parity bit is inserted. Each parity bit the sums the other bits that include that power of two in their power breakdown and is assigned a 1 or 0 based on if that sum is odd or even.  For example bit 1 sums all the bits that have a 1 underneath them, bit 8 sums all the bits that have an 8 underneath them.</p>
      <p>Decoding does the same process but tests each parity bit's value against its sum's evenness and expects them to match. If there is a mismatch, the bad bits and their parity bits are marked as error bits.  If a single non-parity bit is in error, it is flipped. Otherwise, if flipping a single bit will resolve the mismatches, that bit is flipped and then the parity bits are removed to complete the decoding.</p>
    </div>
  <div class="endFloat">&nbsp;</div></div>
  <script>
  var div = document.getElementById('puzzlebox');
  Elm.embed(Elm.HammingCode, div);
  </script>
