function getBack() {
    let position = localStorage.getItem("position");
    if(position.length > 1) {
        position.pop();
        window.location = position[position.length-1];
    }
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
function addUrl(url) {
    let old = getCookie("urls");
    let newUrl = old + " " + url;
    window.cookie = "urls=" + newUrl;
}
function getUrl() {
    alert(getCookie("urls"));
}