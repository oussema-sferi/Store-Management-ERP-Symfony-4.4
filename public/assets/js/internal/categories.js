let inputObject = $('#nameInput');
inputObject.val("");
let categoriesBody = $('#categoriesBody');
let globalId;
let globalTitle;

function deleteCategory(id, path) {
    let deleteCategoryCallbackSuccess = function () {
        $('#categoriesRow' + id).addClass("animated").addClass("zoomOutUp")
    };
    let deleteCategoryCallbackComplete = setTimeout(function () {
        $('#categoriesRow' + id).remove();
    }, 1000);
    const params = {id: id};
    makeAjaxCall(path, "POST", params, deleteCategoryCallbackSuccess, deleteCategoryCallbackComplete);
}

function makeAjaxCall(path, type, params, callbackSuccess, callbackComplete) {
    $.ajax(
        {
            url: path,
            type: type,
            dataType: "json",
            data: params,
            success: callbackSuccess,
            complete: callbackComplete
        }
    )
}

function createCategory(path) {
    const param = {title: inputObject.val()};
    let completeCallBack = function (e) {
        let item = JSON.parse(e.responseText);
        console.log(item);
        inputObject.val("");
        console.log(item);
        Swal.fire({
            text: "Categorie ajouté avec succée",
            title: 'Success',
            icon: 'success',
        });
        categoriesCollection.push(item);
        categoriesBody.append("<tr id=\"categoriesRow"+item.id+"\" class='animated zoomInUp'><td>" + item.id + "</td>\n" +
            "<td id=\"categoriesTitle" + item.id + "\">" + item.title + "</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick='initParams("+item.id+")'>Modifier</a>\n" +
            "</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" class=\"badge badge-danger\"\n" +
            "onclick='deleteCategory(" + item.id + ",\"/categories/delete-category\")'>Supprimer</a>\n" +
            "</td></tr>");
    };

    makeAjaxCall(path, "POST", param, null, completeCallBack);
}

function updateCategory() {
    console.log(globalId);
    console.log(globalTitle);
    let updateTitleDOM = $('#inputTitleUpdate');
    let completeCallback = (e) => {
        let data=JSON.parse(e.responseText);
        console.log(data);
        Swal.fire({
            text: "Categorie modifié avec succée",
            title: 'Success',
            icon: 'success',
        });
        let targetRow = $('#categoriesRow' + data.id);
        targetRow.html("<td>" + data.id + "</td>\n" +
            "<td id=\"categoriesTitle" + data.id + "\">" + data.title + "</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick='initParams("+data.id+")'>Modifier</a>\n" +
            "</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" class=\"badge badge-danger\"\n" +
            "onclick='deleteCategory(" + data.id + ",\"/categories/delete-category\")'>Supprimer</a>\n" +
            "</td>");
    };
    makeAjaxCall(UPDATE_PATH, "POST", {id: globalId, title: updateTitleDOM.val()}, null, completeCallback);
}
function initParams(id) {
    globalId=id;
    let updateTitleDOM = $('#inputTitleUpdate');
    globalTitle = $('#categoriesTitle' + id).text();
    updateTitleDOM.val(globalTitle);
}

