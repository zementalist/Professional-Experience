var logo = document.getElementsByClassName('opt-image');
function setSrc(classElements, src) {
    for(var i = 0; i < classElements.length; i++) {
        classElements[i].setAttribute('src', src);
    }
}
setSrc(logo, '../images/cloudfiles.png');