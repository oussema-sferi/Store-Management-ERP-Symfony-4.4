'use strict';
const ServiceFormDOM = $('#addServiceForm');
const servicesTable = $('#servicesTable');
const updateServiceForm = $('#updateServiceForm');
let globalId = 0;

function createService() {
    const name = ServiceFormDOM.find('#nameServiceInput').val();
    const category = ServiceFormDOM.find('#categorySelector').val();
    const price = ServiceFormDOM.find('#priceInput').val();
    const params = {
        name: name,
        category: category,
        price: price
    };
    let completeCallback = (data) => {
        let result = JSON.parse(data.responseText);
        servicesList.push({
            id: result.id,
            name: result.name,
            category: result.categories.title,
            categoryId: result.categories.id,
            price: result.price
        });
        console.log(result);
        Swal.fire({
            text: "Service ajouté avec succée",
            title: 'Success',
            icon: 'success',
        });
        servicesTable.append("<tr class=\"animated zoomInUp delay-1s\" id=\"serviceRow" + result.id + "\">\n" +
            "<td>" + result.id + "</td>\n" +
            "<td>" + result.name + "</td>\n" +
            "<td>" + result.categories.title + "</td>\n" +
            "<td>" + result.price + " Dt</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick=\"initParams(" + result.id + ")\">Modifier</a>\n" +
            "</td>\n" +
            "<td>\n" +
            "<a href=\"javascript:void(0)\" class=\"badge badge-danger\" onclick=\"deleteService("+result.id+")\">Supprimer</a>\n" +
            "</td>\n" +
            "</tr>");
        resetDOM();
    };
    makeAjaxCall("/Services/create-service", "POST", params, null, completeCallback);
}

function updateService() {
    const name = updateServiceForm.find('#serviceNameUpdateInput').val();
    const category = updateServiceForm.find('#serviceCategoryUpdateInput').val();
    const price = updateServiceForm.find('#servicePriceUpdateInput').val();
    const params = {
        id: globalId,
        name: name,
        category: category,
        price: price
    };
    console.log(params);
    const completeCallBack = (data) => {
        let result = JSON.parse(data.responseText);
        let last=servicesList.find((e)=>e.id===result.id);
        servicesList[servicesList.indexOf(last)].id = result.id;
        servicesList[servicesList.indexOf(last)].name=result.name;
        servicesList[servicesList.indexOf(last)].category=result.categories.title;
        servicesList[servicesList.indexOf(last)].categoryId=result.categories.id;
        servicesList[servicesList.indexOf(last)].price=result.price;
        Swal.fire({
            text: "Service Modifié avec succée",
            title: 'Success',
            icon: 'success',
        });
        let row = $('#serviceRow' + result.id);
        row.html("<td>" + result.id + "</td>\n" +
            "<td>" + result.name + "</td>\n" +
            "<td>" + result.categories.title + "</td>\n" +
            "<td>" + result.price + "Dt</td>\n" +
            "<td >\n" +
            "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick=\"initParams(" + result.id + ")\">Modifier</a>\n" +
            "</td>\n" +
            "<td>\n" +
            "<a href=\"javascript:void(0)\" class=\"badge badge-danger\" onclick=\"deleteService("+result.id+")\">Supprimer</a>\n" +
            "</td>");
    };

    makeAjaxCall("/Services/update-service", "POST", params, null, completeCallBack);
}

function deleteService(id) {
    console.log('invoked');
    let url = "delete-service";
    let params=servicesList.find((e) => e.id === id);
    let successCallback = () => {
        let row = servicesList.find((e) => e.id === id);
        if (row != null) {
            servicesList.splice(servicesList.indexOf(row),1);
            $('#serviceRow'+id).remove();
            Swal.fire({
                text: "Service supprimé avec succée",
                title: 'Success',
                icon: 'success',
            });
        }
    };
    makeAjaxCall(url,"POST",params,successCallback,null);
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

function resetDOM() {
    ServiceFormDOM.find("#nameServiceInput").val("");
    ServiceFormDOM.find("#priceInput").val("");
}

function initParams(id) {
    globalId = id;
    let service = servicesList.find(e => e.id === id);
    if (service !== undefined) {
        updateServiceForm.find("#serviceNameUpdateInput").val(service.name);
        updateServiceForm.find("#serviceCategoryUpdateInput").val(service.categoryId);
        updateServiceForm.find("#servicePriceUpdateInput").val(service.price);
    } else
        console.log("impossible ");
}