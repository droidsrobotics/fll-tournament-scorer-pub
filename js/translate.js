pgStart = 0;

function textNodesUnder(el) {
  var n, a = [],
    walk = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null, false);
  while (n = walk.nextNode()) a.push(n);
  return a;
}

function switchLanguage() {
  languageInit()
  // checkDarkTheme()

  dictionary = getDict(language);

  if (pgStart == 0) {
    nodes = textNodesUnder(document.body);
    for (i = 0; i < nodes.length; i++) {
      node = nodes[i];
      nodes[i].en = nodes[i].data;
    }
    pgStart = 1;
  }

  for (i = 0; i < nodes.length; i++) {
    node = nodes[i];
    if (nodes[i].en.trim() != "") nodes[i].data = nodes[i].data.replace(nodes[i].data.trim(),getTranslation(dictionary, nodes[i].en.trim()));
  }
}
window.onload = setTimeout(function(){ switchLanguage(); }, 0);
