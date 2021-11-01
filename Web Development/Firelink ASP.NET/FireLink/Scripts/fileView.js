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
    if(link && !window.location.href.includes("files/")) {
        // Change url to this.file.url
        var fullHostName = location.hostname + (location.port ? ':' + location.port : '');
        let fileURL = "http://" + window.location.pathname.replace("/upload", "") + fullHostName + link.value.replace(fullHostName, "");
        window.history.replaceState(null, null, fileURL);

    }
    // if a file found => copy button && link found => add click event to buttons
    if (link && copy) {
        link.select();
        copy.addEventListener('click', copyLink);
        reportButton.addEventListener('click', copyLink);
    }

}