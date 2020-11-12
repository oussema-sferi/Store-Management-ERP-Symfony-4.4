"use strict";

let categoryForm = $('#service-category-modal');
let orderServiceDOMTable = $('#order-services-DOM-table');
let category = null;
let cart = [];
let inputTotal = $('#input-total');
let inputAPayer = $('#input-a-payer');
let employee = null;
let orderBonusInput = $('#input-bonus');
let reductionAmountInput = $('#input-reduction-amount');
let reductionRatioInput = $('#input-reduction-ratio');
let total = 0;
inputTotal.val(0);


function initCategoryModal(id) {
    category = categoriesList.find((e) => e.id === id);
    console.log(category);
    if (category !== undefined) {
        let services = category.services;
        categoryForm.find("#services-selection").empty();
        services.forEach((item) => {
            if (!item.isAdded)
                categoryForm.find("#services-selection").append("<option value=\"" + item.id + "\">" + item.name + "</option>")
        });
    }
}


function addServicesToCheckOut() {
    console.log("invoked category");
    console.log(category);
    console.log('end invoked category');
    categoryForm.find("#services-selection").children('option:selected').each((index, dom) => {
        let service = category.services.find((e) => e.id === parseInt(dom.value));
        if (!service.isAdded) {
            let employeeId = categoryForm.find("#employees-selection").val();
            employee = employeesList.find((e) => e.id === parseInt(employeeId));
            cart.push({
                id: service.id,
                name: service.name,
                categoryId: service.categoryId,
                price: service.price,
                isAdded: true,
                employee: employee
            });
            total += service.price;
            console.log(total);
            orderServiceDOMTable.append("<tr id=\"cart" + service.id + "\">\n" +
                "<td>" + service.id + "</td>\n" +
                "<td>" + service.name + "</td>\n" +
                "<td>" + service.price + "</td>\n" +
                "<td>" + employee.fullName + "</td>\n" +
                "<td>\n" +
                "<a href=\"javascript:void(0)\" class=\"badge badge-white\" onclick=\"removeServiceFromCart(" + parseInt(service.id) + ")\">Supprimer</a>\n" +
                "</td>\n" +
                "</tr>");
            categoriesList[categoriesList.indexOf(category)].services[category.services.indexOf(service)].isAdded = true;
            console.log("--------cart--------------");
            console.table(cart);
        }
    });
    console.log(parseInt(inputTotal.val()) + total);
    inputTotal.val(total + parseInt(orderBonusInput.val()));
    inputAPayer.val(inputTotal.val());
}

function removeServiceFromCart(id) {
    let service = cart.find((e) => e.id === parseInt(id));
    if (service !== undefined) {
        let categorie = categoriesList.find((c) => c.id === service.categoryId);
        if (categorie !== undefined) {
            total -= parseInt(service.price);
            inputTotal.val(total + parseInt(orderBonusInput.val()));
            inputAPayer.val(total + parseInt(orderBonusInput.val()) - (parseInt(reductionAmountInput.val())));
            let result = categorie.services.find((x) => x.id === service.id);
            if (result !== undefined) {
                console.log("mitsketa");
                console.log(result);
                let index = categoriesList.indexOf(categorie);
                categorie.services[categorie.services.indexOf(result)].isAdded = false;
                console.log(index);
                categoriesList[index] = categorie;
                cart.splice(cart.indexOf(service), 1);
                $('#cart' + result.id).remove();
                console.log("--------cart--------------");
                console.table(cart);
            } else console.error("Mal9itech el result");
        } else console.error("mal9itech el cateogire");
    } else console.error("Mal9itech jemla kol service");
}

function onOrderBonusPressed() {
    if (!isNaN(orderBonusInput.val())) {
        let sum = total + parseInt(orderBonusInput.val());
        inputTotal.val(sum);
        inputAPayer.val(sum);
    } else {
        inputTotal.val(total);
        inputAPayer.val(total);
        orderBonusInput.val(0);
    }
}

function onReductionAmountPressed() {
    if (!isNaN(reductionAmountInput.val())) {
        let sum = (total + parseInt(orderBonusInput.val())) - parseInt(reductionAmountInput.val());
        inputAPayer.val(sum);
        let reduction = (parseInt(reductionAmountInput.val()) / (total + parseInt(orderBonusInput.val()))) * 100;
        reductionRatioInput.val(reduction);
    } else {
        reductionRatioInput.val(0);
        reductionAmountInput.val(0);
    }

}

function onReductionRatioPressed() {
    if (!isNaN(reductionRatioInput.val())) {
        let reductionRatio = parseInt(reductionRatioInput.val());
        if (reductionRatio > 100) {
            reductionRatio = 100;
            reductionRatioInput.val(100);
        }
        let sum = ((total + parseInt(orderBonusInput.val())) / 100) * reductionRatio;
        reductionAmountInput.val(sum);
        let tt = (total + parseInt(orderBonusInput.val())) - parseInt(reductionAmountInput.val());
        inputAPayer.val(tt);
    } else {
        reductionRatioInput.val(0);
        reductionAmountInput.val(0);
    }
}

function confirmOrder() {
    let params = {
        rows: cart,
        total: (total + parseInt(orderBonusInput.val())),
        finalTotal: ((total + parseInt(orderBonusInput.val())) - parseInt(reductionAmountInput.val())),
        reductionRatio: parseInt(reductionRatioInput.val()),
    };
    let completeCallback = () => {
        window.location.href = '/store';
    };
    if (cart.length > 0) {
        makeAjaxCall("/store/create-order", "POST", params, null, completeCallback);
    } else {
        Swal.fire({
            text: "Veuillez ajouter au moins un service au panier pour passer la commande",
            title: 'Success',
            icon: 'error',
        });
    }
}

function confirmOrderAdmin() {
    let date = $('#input-date').val();
    let params = {
        rows: cart,
        total: (total + parseInt(orderBonusInput.val())),
        finalTotal: ((total + parseInt(orderBonusInput.val())) - parseInt(reductionAmountInput.val())),
        reductionRatio: parseInt(reductionRatioInput.val()),
        date: date
    };
    let completeCallback = () => {
        window.location.href = '/Orders';
    };
    if (cart.length > 0) {
        makeAjaxCall("/Orders/create-order-Admin", "POST", params, null, completeCallback);
    } else {
        Swal.fire({
            text: "Veuillez ajouter au moins un service au panier pour passer la commande",
            title: 'Success',
            icon: 'error',
        });
    }
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