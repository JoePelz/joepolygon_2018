  <div id="SectionContainer">
    <h1>IP Address and Subnet Masks</h1>
    <p>There's no place like 127.0.0.1</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/ipAddress/link.jpg"></div>
    <p>One of my assignments in school was to translate IP addresses to different forms, determine how many IP addresses fit in a range, manually determine a router's output port given a lookup table of subnets and an address, and all that kind of stuff.</p>
    <p>It's tedious and error-prone so the natural solution is to get the computer to do the grunt work.</p>
    <div class="interactive widthlimit centered"><div id='ipaddress' class="centered"></div></div>
    <p>Sorry, no IPv6 here.  At the time IPv4 was still relevant and my assignments reflected that.  Perhaps also it was shorter to calculate and my teacher wasn't sadistic.</p>
  </div>
  <div class="endFloat">&nbsp;</div></div>
  <script>
  var div = document.getElementById('ipaddress');
  Elm.embed(Elm.IPAddress, div);
  </script>
