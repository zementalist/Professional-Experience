function filterUrl(url) {
    url = String(url);
    url = url.replace("#", "");
    url = url[url.length-1] == "/" ? url.substring(0, url.length - 1) : url;
    var indexBeforePage = url.lastIndexOf('/');
    var currentUrl = "";
    for(var i = indexBeforePage + 1; i < url.length; i++) {
        currentUrl += url[i];
    }
    if(currentUrl == "" || currentUrl.includes(window.location.hostname)) {
        currentUrl = 'home';
    }
    return currentUrl;
}

function setActiveNavbar() {
    var navItems = document.getElementsByClassName('nav-item');
    var navLink = document.getElementsByClassName('nav-link');
    for(var i = 0; i < navItems.length; i++) {
        if(filterUrl(navLink[i].href).toLowerCase() == filterUrl(window.location).toLowerCase()) {
            navItems[i].setAttribute('class', 'nav-item active');
        }
        else {
            navItems[i].setAttribute('class', 'nav-item');
        }
    }
}

function setDate() {
    var element = document.getElementById('date');
    var date = new Date();
    var year = date.getFullYear();
    element.innerHTML = year;
}


function animateMotto() {
    var element1 = document.getElementsByClassName('motto')[1];
    var opacity = 0;
    var top = 0;
    if(element1) {
        var loop = setInterval(function() {
            opacity += 0.01;
            top += 0.07;
            element1.style.opacity = String(opacity);
            element1.style.top = top + 'rem';
            if(opacity > 1) {
                clearInterval(loop);
            }
        }, 20)
    }
}

function addUpdateComponent() {
    var button = document.getElementsByClassName('up-btn')[0];
    button.addEventListener('click',function() {
        var parent = document.getElementsByClassName('upload-component-parent')[0];
        parent.innerHTML = '<example-component></example-component>';
    });
}
setActiveNavbar();
setDate();
animateMotto();
