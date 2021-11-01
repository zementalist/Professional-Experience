window.onload = () => {
    let backcolors = ['#21094e', '#511281', '#4ca1a3', '#04009a', '#a9f1df', '#00adb5']
    document.querySelectorAll(".file-card .icon")[0].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
    document.querySelectorAll(".file-card .icon")[1].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
    document.querySelectorAll(".file-card .icon")[2].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
    document.querySelectorAll(".file-card .icon")[3].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
    document.querySelectorAll(".file-card .icon")[4].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
    document.querySelectorAll(".file-card .icon")[5].style.color = backcolors[Math.round(Math.random() * backcolors.length)];
}

function submitForm(filetype) {
    let allowed_files = ['image', 'audio', 'video', 'compressed', 'document'];
    if (allowed_files.includes(filetype)) {
        let form = document.getElementById('form');
        form.setAttribute('action', 'UploadForm/' + filetype);
        form.submit();
    }
    return;
    
}