function toggleCollapse(id) {
  var e = document.getElementById(id);
  if (e.classList.contains("collapsed")) {
    e.classList.remove("collapsed");
    e.onclick = null;
  } else {
    e.classList.add("collapsed");
    e.onclick = function () { toggleCollapse(id); };
  }
}
