function getRandomIntrigue(target) {
  var result = "Imagine, if you will, a ";
  var temp = getAdj();
  if (temp != "") {
    result += temp + " ";
  }
  result += getRandomNoun() + " ";
  result += getClauseConnector() + " ";
  var temp = getAdj();
  if (temp != "") {
    result += temp + " ";
  }
  result += getRandomNoun() + ".";
  document.getElementById(target).innerHTML = result;
}

function getRandomNoun() {
  var nouns = ["egg", "ball", "rod", "shaft", "box", "cube", "cylinder", "cone", "donut", "slinky", "helix", "ribbon", "cup", "bowl", "hat", "castle", "tree", "noodle", "semicircle", "umbrella", "candycane", "coyote", "rooster", "duckling", "monkey", "gorilla", "bear", "lion", "tiger", "ostrich", "emu", "canary", "dog", "cat", "fish", "shark", "whale", "dolphin", "hawk", "eagle", "falcon", "pidgeon", "lemur", "koala", "sloth", "kangaroo", "rat", "mouse", "hamster", "gerbil", "rabbit", "fox", "anteater", "leprechaun", "lamp", "computer screen", "candle", "torch", "feather duster", "table", "pot", "fishbowl", "crate", "headphone", "sewing machine", "bicycle", "truck", "minivan", "airplane", "tugboat", "cruiseship", "spaceship", "teleporter", "broomstick", "fridge", "bread box", "tongue", "mitten", "boot", "mop", "office chair", "sword", "hay bale", "typewriter", "saxophone", "anvil", "piano", "drumstick", "pineapple", "banana", "turnip", "sushi roll", "french fry", "walnut", "loaf of bread", "pomegranate", "sirloin steak", "pizza", "ice cream sandwich", "cheese wheel", "roast turkey"];
  return nouns[Math.floor(Math.random() * nouns.length)];
}

function getClauseConnector() {
  var pos = ["on top of", "next to", "balanced on", "sitting under", "leaning against", "with", "smooshed into", "packed on", "tied to", "arranged with", "hanging from", "stuck to", "bouncing off", "giving a hug to", "getting cozy with", "being poked by", "holding up", "touching", "adjacent to", "posing with", "soliciting the services of", "fermenting", "carefully measuring", "picking a fight with", "falling off a cliff with", "making a face at", "being scolded by", "tipping over", "carved in relief on", "giving a massage to", "carrying", "swimming with", "skydiving while chained to", "sharing a prison cell with", "washing off", "seducing", "rubbing up against"];
  return pos[Math.floor(Math.random() * pos.length)] + " a";
}

function getAdj() {
  color = ["red", "blue", "green", "yellow", "purple", "violet", "maroon", "chestnut", "olive green", "brown", "tan", "beige", "turquoise", "magenta", "navy", "emerald", "pink", "cyan"];
  pattern = ["speckled", "striped", "checkered", "spotted", "layered", "trimmed"];
  material = ["fuzzy", "glossy", "smooth", "painted", "feathered", "furry", "hairy", "bare", "clothed", "squishy", "slimy", "metallic", "wooden", "plastic", "rubber", "glass", "crystal", "ceramic", "flaming", "bubbly", "translucent", "foggy", "clockwork", "pneumatic", "hydraulic", "electric", "glowing"];
  size = ["giant", "baby", "tiny", "huge", "large", "small", "little", "toaster-sized", "car-sized", "pocket-size", "hand-size", "bite-size", "oblong", "stretched out", "midget"];

  output = "";
  if(Math.random() < 0.35) {
    output = size[Math.floor(Math.random() * size.length)] + " ";
  }
  if(Math.random() < 0.25) {
    output += material[Math.floor(Math.random() * material.length)] + " ";
  }
  if(Math.random() < 0.25) {
    if(Math.random() < 0.1) {
      output += pattern[Math.floor(Math.random() * pattern.length)] + " ";
    }
    output += color[Math.floor(Math.random() * color.length)] + " ";
  }
  return output.trim();
}
