'use strict';
let createPackForm = $('#createPackForm');
let packsDOMTable = $('#packsDOMTable');
let addServicePackForm = $('#addServicePackForm');
let packServicesTable = $('#packServicesTable');
let packPriceInput = $('#packPriceInput');
let packNameInput = $('#packNameInput');
let packUpdated = false;

function createPack() {
    let serviceIndexes = [];
    createPackForm.find('#inputServicePackTitle').children('option:selected').each((index, dom) => {
        serviceIndexes.push(dom.value);
    });
    let name = createPackForm.find('#inputNamePackTitle').val();
    let price = createPackForm.find('#inputPricePackTitle').val();
    let params = {
        name: name,
        price: price,
        services: serviceIndexes
    };
    let completeCallBack = (response) => {
        Swal.fire({
            text: "Pack crée avec succée",
            title: 'Success',
            icon: 'success',
        });
        let result = JSON.parse(response.responseText);
        packsDOMTable.append("<tr id=\"" + result.id + "\">\n" +
            "<td>" + result.id + "</td>\n" +
            "<td>" + result.name + "</td>\n" +
            "<td>" + result.services.length + "\n" +
            "</td>\n" +
            "<td>" + result.price + "dt\n" +
            "</td>\n" +
            "<td>\n" +
            "<a href=\"#\" class=\"badge badge-success\">Détailles</a>\n" +
            "</td>\n" +
            "<td>\n" +
            "<a href=\"\" class=\"badge badge-danger\">Supprimer</a>\n" +
            "</td>")

    };
    makeAjaxCall("/Packs/new-pack", "POST", params, null, completeCallBack);
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

function deletePack(id) {
    let row = $('#packRow' + id);
    let callbackComplete = () => {
        row.remove();
    };
    let params = {id: id};
    makeAjaxCall("/Packs/delete-pack", "POST", params, null, callbackComplete);
}

function removeServiceFromPack(id) {
    let params = {
        packId: packId,
        ServiceId: id
    };
    let completeCallback = () => {
        $('#packServiceRow' + id).remove();
        let service = packServices.find((e) => e.id === id);
        availableServices.push(service);
        packServices.splice(
            packServices.indexOf(service),
            1
        );
        Swal.fire({
            text: "Service " + service.name + " à étais retirer du pack avec succée",
            title: 'Success',
            icon: 'success',
        });
        addServicePackForm.find('#inputDetailsPackServices').append("" +
            "<option value=\"" + service.id + "\">" + service.name + "</option>");
    };
    makeAjaxCall("/Packs/remove-service-from-pack", "POST", params, null, completeCallback);
}

function addServiceToPack() {

    let serviceIndexes = [];
    addServicePackForm.find('#inputDetailsPackServices').children('option:selected').each((index, dom) => {
        serviceIndexes.push(dom.value);
        let serviceItem = availableServices.find((e) => e.id == dom.value);
        if (serviceItem != undefined) {
            availableServices.splice(availableServices.indexOf(serviceItem), 1);
            addServicePackForm.find("#inputDetailsPackServices option[value=\"" + dom.value + "\"]").remove();
        } else console.error("couldn't find the requested service");
    });
    let params = {
        packId: packId,
        services: serviceIndexes
    };
    let completeCallBack = (data) => {
        let result = JSON.parse(data.responseText);
        result.services.forEach((dataResult) => {
            let serviceX = packServices.find(e => e.id === dataResult.id);
            if (serviceX === undefined) {
                packServicesTable
                    .append("<tr id=\"packServiceRow" + dataResult.id + "\">\n" +
                        "<td>" + dataResult.id + "</td>\n" +
                        "<td>" + dataResult.name + "</td>\n" +
                        "<td>" + dataResult.categories.title + "</td>\n" +
                        "<td>" + dataResult.price + "</td>\n" +
                        "<td><a href=\"javascript:void(0)\" class=\"badge badge-danger\"\n" +
                        "onclick=\"removeServiceFromPack(" + dataResult.id + ")\">\n" +
                        "Retirer service du pack\n" +
                        "</a></td>\n" +
                        "</tr>");
                packServices.push({
                    id: dataResult.id,
                    name: dataResult.name,
                    price: dataResult.price
                });

            }
            Swal.fire({
                text: "Services ajoutées aux pack avec succée",
                title: 'Success',
                icon: 'success',
            });
        });
    };
    if(availableServices.length>0) {
        makeAjaxCall("/Packs/add-service-to-pack", "POST", params, null, completeCallBack);
    }
}

function updatePack() {
    let params = {
        id: packId,
        name: packNameInput.val(),
        price: packPriceInput.val(),
    };
    let completeCallback = () => {
        if (packUpdated)
            Swal.fire({
                text: "Pack modifié avec succée",
                title: 'Success',
                icon: 'success',
            });
        window.location.href = "/Packs";
    };
    makeAjaxCall("/Packs/update-pack", "POST", params, null, completeCallback);
}

