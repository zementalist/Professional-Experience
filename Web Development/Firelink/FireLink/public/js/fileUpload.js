window.onload = function() {
    let dropContainer = document.getElementById("drop_zone");
    var dropCover = document.getElementById('drop-cover');
    var progressContainer = document.getElementsByClassName('progress-container')[0];
    var progressBar = document.getElementsByClassName('progress-bar')[0];
    var uploadBtn = document.getElementById('uploadBtn');
    var asyncAlert = document.getElementById('asyncAlert');
    var file = document.getElementById('file');
    var MAX_SIZE = file.getAttribute('maxSize');
    MAX_SIZE = Math.round(MAX_SIZE / 1000);
    // Get file name beside edited button (choose file)
    file.addEventListener('change', function() {
        if('files' in file) {
            var fileSize = file.files[0].size / 1000000;
            if(file.files.length > 1) {
                alert("Choose 1 file only!");
                return "ONLY 1 FILE ALLOWED!!!";
            }
            else if(fileSize > MAX_SIZE) {
                asyncAlert.setAttribute('class', 'alert alert-danger session-message');
                asyncAlert.innerHTML = "The file may not be greater than " + MAX_SIZE + " MB";
            }
            else {
                document.getElementById('filename').innerHTML = file.files[0].name;
                asyncAlert.innerHTML = "";
                asyncAlert.removeAttribute('class');
            }
        }

    })
    // disable submitting form onclick(fileLabel)
    document.getElementById('fileLabel').addEventListener('click', function(event) {
        event.preventDefault();
    })

    // Handling file drag && drop


    dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
        evt.preventDefault();
        dropCover.style.display = "block";
    };

    dropContainer.ondrop = function(evt) {
    // pretty simple -- but not for IE :(
        if(evt.dataTransfer.files.length > 1) {
            alert("Choose 1 file only!");
            evt.preventDefault();
            dropCover.style.display = "none";
        }
        else if((evt.dataTransfer.files[0].size / 1000000) > Math.round(MAX_SIZE)) {
            alert("Your file size must be at most " + Math.round(MAX_SIZE) + "MB");
            evt.preventDefault();
            dropCover.style.display = "none";
        }
        else {
            document.getElementById('file').files = evt.dataTransfer.files;
            evt.preventDefault();
            dropCover.style.display = "none";
        }
    };

    // Handling file upload progress bar

    let uploadProgress = []

    function updateProgress(fileNumber, percent) {
        uploadProgress[fileNumber] = percent
        let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length * 2;
        progressBar.style.width = total + "%";
        progressBar.innerHTML = Math.round(total) + "%";
    }


    function uploadFile() {
        var url = '/uploadProgress';
        var xhr = new XMLHttpRequest()
        var formData = new FormData(document.getElementById('myForm'));
        xhr.open('POST', url, true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        progressContainer.style.display = "block";
        uploadBtn.setAttribute('disabled', true);
        uploadBtn.value = "Uploading ..";

        // Update progress (can be used to show progress indicator)
        xhr.upload.addEventListener("progress", function(e) {
            updateProgress(1, (e.loaded * 100.0 / e.total) || 100)
        })

        xhr.addEventListener('readystatechange', function(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
            updateProgress(1, 100) // <- Add this
            }
            else if (xhr.readyState == 4 && xhr.status != 200) {
            // Error. Inform the user
            }
        })

        xhr.send(formData)
        }



        (function () {
            document.getElementById("myForm").onsubmit = uploadFile;
        })();
}