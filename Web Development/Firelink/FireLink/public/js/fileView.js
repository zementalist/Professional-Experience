window.onload = function() {
    var copy = document.getElementById('copy');
    var link = document.getElementById('link');
    var reportButton = document.getElementById('repBtn');
    // function to copy link //
    function copyLink()
    {
        link.select();
        document.execCommand("copy");
        var alertElement = document.createElement('div');
        var parent = document.getElementById('alertZone');
        alertElement.setAttribute('class', 'alert alert-success');
        alertElement.innerHTML = "Copied!";
        alertElement.style.fontWeight = 900;
        parent.appendChild(alertElement);
        setTimeout(function() {
            alertElement.parentNode.removeChild(alertElement);
        }, 3000)
    }
    if(link) {
        // Change url to this.file.url
        window.history.pushState("", "",  link.value);
    }
    // if a file found => copy button && link found => add click event to buttons
    if(link && copy) {
        link.select();
        copy.addEventListener('click', copyLink);
        reportButton.addEventListener('click', copyLink);
    }

}