window.onload = () => {
    let data = [];
    let sort = "DESC";
    let selectedFileType = "";

    document.getElementById('SubmitBtn').addEventListener('click', find);
    document.getElementById("sortInput").value = sort;
    document.getElementById("sortSwitch").addEventListener('click', changeSort);

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function fillTableWith(files) {
        var t = "";
        for (var i = 0; i < files.length; i++) {
            let date = new Date(parseInt(files[i].CreatedAt.replace(/[^\d]/ig, "")));
            date = formatDate(date);
            var tr = `
                <tr>
                    <td>${files[i].Id}</td>
                    <td>${files[i].Name}</td>
                    <td>${files[i].Size}</td>
                    <td>${files[i].Extension}</td>
                    <td>${files[i].Username}</td>
                    <td>${date}</td>
                    <td>
                        <form class="form2" id="${files[i].Id}">
                            <input type="hidden" name="securecode" value="${files[i].SecureCode}">
                            <input type="hidden" name="responsetype" value="json">
                            <input type="button" value="Delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
`;
            t += tr;
        }
        let tableBody = document.getElementById("table-body");
        tableBody.innerHTML = "";
        tableBody.innerHTML += t;
        let forms = document.getElementsByClassName("form2");
        for (var i = 0; i < forms.length; i++) {
            forms[i].addEventListener("click", remove);
        }
    }

    function find() {
        event.preventDefault();
        var url = "/control/find/file";
        var form = document.getElementById('form');
        var value = document.getElementsByClassName('searchTerm')[0].value;
        let inputIsValid = form["type"].value != "" && form["method"].value != "";
        if (inputIsValid) {
            selectedFileType = form["type"].value.toLowerCase();
            var query = url;
            fetch(query, {
                method: 'post',
                credentials: "same-origin",
                body: new FormData(form)
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Request Failed!");
            }, networkError => {
                console.log(networkError.message);
            }).then(jsonResponse => {
                //this.data = jsonResponse; Set table
                var files = jsonResponse;
                fillTableWith(files);
            })
        }
    }

    function changeSort() {
        if (sort == "DESC") {
            sort = "ASC";
            document.getElementById('sortIcon').setAttribute('class', 'fas fa-sort-up');
        }
        else {
            sort = "DESC";
            document.getElementById('sortIcon').setAttribute('class', 'fas fa-sort-down');
        }
        document.getElementById('sortInput').value = sort;
        document.getElementById('SubmitBtn').click();
    }

    function remove() {
        var form = event.currentTarget;
        var id = event.currentTarget.getAttribute('id');
        var url = `/files/${selectedFileType}/${id}/delete`;
        var confirmed = confirm("Are you sure you want to delete this file ?");
        if (id.length > 0 && confirmed) {
            var query = url;
            fetch(query, {
                method: 'post',
                credentials: "same-origin",
                body: new FormData(form)
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Request Failed!");
            }, networkError => {
                console.log(networkError.message);
            }).then(jsonResponse => {
                if (jsonResponse == 1) {
                    alert("File is deleted successfully");
                    document.getElementById('SubmitBtn').click();
                }
                else
                    alert("Failed to delete file");

            })
        }
    }

}
