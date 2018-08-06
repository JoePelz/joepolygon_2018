var fragdata;
var fragsum;

function retrieveData(target) {
  var xmlhttp = new XMLHttpRequest();
  var url = "/assets/articles/generatingLanguage/fragments.json";

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      fragdata = JSON.parse(xmlhttp.responseText);
      fragkeys = Object.keys(fragdata);
      fragsum = 0
      for(var i = 0; i < fragkeys.length; ++i) {
        fragsum += fragdata[fragkeys[i]];
      }
      getRandomWordFromFragments(target);
    }
  }

  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}

function getWordEnding(word, frags) {
  var limit = word.length;
  for(i = 0; i < frags; ++i) {
    subject = word.substring(0, limit);
    a = subject.search(/[^aeiou]+$/);
    b = subject.search(/[aeiou]+$/);
    limit = Math.max(a, b);
  }
  return word.substring(limit, word.length);
}

function getRandomWordFromFragments(target) {
  if (fragdata == null) {
    document.getElementById(target).innerHTML = "<li>Downloading dictionary...</li>";
    retrieveData(target);
    return;
  }

  result = "";
  for(var i = 0; i < 5; ++i) {
    result += "<li>" + buildRandomWordFromFragments() + "</li>"
  }
  document.getElementById(target).innerHTML = result;
}

function buildRandomWordFromFragments() {
  var word = "";

  fragkeys = Object.keys(fragdata);
  choice = Math.floor(Math.random() * fragsum);
  for(var i = 0; i < fragkeys.length; ++i) {
    choice -= fragdata[fragkeys[i]];
    if (choice <= 0) {
      word = fragkeys[i];
      break;
    }
  }

  length = Math.floor(Math.random() * 5 + 5);

  while (word.length < length) {
    ending = getWordEnding(word, 2);
    addition = getNextFragment(fragdata, ending);
    if (addition == "_") {
      //abort and start again.
      return buildRandomWordFromFragments();
    }
    word += addition.substring(ending.length, addition.length);
  }

  return word;
}

function getNextFragment(dict, pattern) {
  options = {};
  result = '_';
  dictkeys = Object.keys(dict);
  for (var i = 0; i < dictkeys.length; ++i) {
    //test if the key dictkeys[i] starts with pattern:
    if (dictkeys[i].lastIndexOf(pattern, 0) === 0) {
      options[dictkeys[i]] = dict[dictkeys[i]];
    }
  }

  optkeys = Object.keys(options);
  var optlen = 0;
  for(var i = 0; i < optkeys.length; ++i) {
    optlen += options[optkeys[i]];
  }
  if (optlen == 0) {
    return result;
  }
  choice = Math.floor(Math.random() * optlen);

  optkeys = Object.keys(options);
  for (var i = 0; i < optkeys.length; ++i) {
    choice -= options[optkeys[i]];
    if (choice <= 0) {
      result = optkeys[i];
      break;
    }
  }
  return result;
}
