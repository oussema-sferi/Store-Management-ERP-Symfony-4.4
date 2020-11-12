'use strict';

let expensesDOMTable = $('#expensesDOMTable');
let createExpenseForm = $('#createExpensesForm');
let updateExpenseForm = $('#updateExpenseForm');
let descriptionLength = $('#descriptionLength');
let globalId;

function newExpense() {
    let isPayed = createExpenseForm.find('#addIsPayedAmountInput').val();
    let params = {
        title: createExpenseForm.find("#addExpenseTitleInput").val(),
        description: createExpenseForm.find("#addExpenseDescriptionInput").val(),
        amount: createExpenseForm.find("#addExpenseAmountInput").val(),
        payableAt: createExpenseForm.find("#addPayableAtAmountInput").val(),
        isPayed: isPayed,
        category: createExpenseForm.find("#addCategoryInput").val()
    };
    createExpenseForm.find("#addExpenseTitleInput").val("");
    createExpenseForm.find("#addExpenseDescriptionInput").val("");
    createExpenseForm.find("#addExpenseAmountInput").val("");
    createExpenseForm.find("#addPayableAtAmountInput").val("");

    let completeCallback = (e) => {
        let data = JSON.parse(e.responseText);
        let creationDate = new Date(parseInt('' + data.creationDate.timestamp + '') * 1000).toLocaleDateString();
        let payableAt = new Date(parseInt('' + data.payableAt.timestamp + '') * 1000).toLocaleDateString();
        let isPayed = data.isPayed;
        let style;
        let payedResult;
        if (isPayed) {
            payedResult = "Payée";
            style = "badge-success"
        } else {
            style = "badge-danger";
            payedResult = "Non payée";
        }
        expensesList.push({
            id: data.id,
            title: data.title,
            description: data.description,
            amount: data.amount,
            creationDate: new Date(parseInt('' + data.creationDate.timestamp + '') * 1000),
            payableAt: new Date(parseInt('' + data.payableAt.timestamp + '') * 1000),
            isPayed: isPayed,
            category: data.category.id
        });
        expensesDOMTable
            .append("<tr id=\"expenseRow" + data.id + "\">\n" +
                "<td>" + data.id + "</td>\n" +
                "<td>" + data.title + "</td>\n" +
                "<td>" + data.description + "</td>\n" +
                "<td>" + data.category.title + "</td>\n" +
                "<td>" + data.amount + " Dt</td>\n" +
                "<td>\n" +
                "" + creationDate + "" +
                "</td>\n" +
                "<td>\n" +
                "" + payableAt + "" +
                "</td>\n" +
                "<td>\n" +
                "<span class=\"" + style + "\">" + payedResult + "</span>\n" +
                "</td>\n" +
                "<td >\n" +
                "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"" +
                " onclick=\"initParams(" + data.id + ")\">Modifier</a>\n" +
                "</td>\n" +
                "<td>\n" +
                "<a href=\"javascript:void(0)\" class=\"badge badge-danger\" \n" +
                "                                    onclick=\"deleteExpense(" + data.id + ")\">Supprimer</a>" +
                "</td>\n" +
                "</tr>");
        Swal.fire({
            text: "Charge ajouté avec succée",
            title: 'Success',
            icon: 'success',
        });
    };
    makeAjaxCall("/Expenses/new-expense", "POST", params, null, completeCallback);

}

function DecrementDescriptionLength() {
    let charactersLengthAllowed = 50 - createExpenseForm.find("#addExpenseDescriptionInput").val().length;
    if (charactersLengthAllowed <= 0) {
        let finalMessage = createExpenseForm.find("#addExpenseDescriptionInput").val().substr(0, 49);
        createExpenseForm.find("#addExpenseDescriptionInput").val(finalMessage);
    }
    descriptionLength.text(charactersLengthAllowed);
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

function deleteExpense(id) {
    let params = {
        id: id
    };
    let completeCallBack = () => {
        $('#expenseRow' + id).remove();
        Swal.fire({
            text: "Charge retiré avec succée",
            title: 'Success',
            icon: 'success',
        });
    };
    makeAjaxCall("/Expenses/remove-expense", "POST", params, null, completeCallBack);
}

function initParams(id) {
    globalId = id;
    let expense = expensesList.find((e) => e.id === id);
    if (expense !== undefined) {
        updateExpenseForm.find("#updateExpenseTitleInput").val(expense.title);
        updateExpenseForm.find("#updateExpenseDescriptionInput").val(expense.description);
        updateExpenseForm.find("#updateExpenseAmountInput").val(expense.amount);
        updateExpenseForm.find("#updatePayableAtAmountInput").val(expense.payableAt.toJSON().slice(0, 19));
        updateExpenseForm.find("#updateCategoryInput").val(expense.category);
        console.log(expense.isPayed);
        if (expense.isPayed)
            updateExpenseForm.find("#updateIsPayedAmountInput").val(1);
        else
            updateExpenseForm.find("#updateIsPayedAmountInput").val(0);
    }
}

function updateExpense() {
    let expense = expensesList.find(e => e.id === globalId);
    let isPayed = updateExpenseForm.find('#updateIsPayedAmountInput').val();
    console.log(isPayed);
    if (expense !== undefined) {
        console.log('invoked ');
        let params = {
            id: globalId,
            title: updateExpenseForm.find("#updateExpenseTitleInput").val(),
            description: updateExpenseForm.find("#updateExpenseDescriptionInput").val(),
            amount: updateExpenseForm.find("#updateExpenseAmountInput").val(),
            payableAt: updateExpenseForm.find("#updatePayableAtAmountInput").val(),
            isPayed: isPayed,
            category:updateExpenseForm.find("#updateCategoryInput").val()
        };
        let completeCallback = (result) => {
            let response = JSON.parse(result.responseText);
            expensesList[expensesList.indexOf(expense)].title = response.title;
            expensesList[expensesList.indexOf(expense)].description = response.description;
            expensesList[expensesList.indexOf(expense)].amount = response.amount;
            expensesList[expensesList.indexOf(expense)].payableAt =
                new Date(parseInt('' + response.payableAt.timestamp + '') * 1000);
            expensesList[expensesList.indexOf(expense)].isPayed = response.isPayed;
            expensesList[expensesList.indexOf(expense)].category = response.category.id;
            let style = response.isPayed ? "badge-success" : "badge-danger";
            let payedResult = response.isPayed ? "Payée" : "Non payée";
            let row = $('#expenseRow' + response.id);
            row.html(
                "<td>" + response.id + "</td>\n" +
                "<td>" + response.title + "</td>\n" +
                "<td>" + response.description + "</td>\n" +
                "<td>" + response.category.title + "</td>\n" +
                "<td>" + response.amount + " Dt</td>\n" +
                "<td>\n" +
                "" + expensesList[expensesList.indexOf(expense)].creationDate.toLocaleDateString() + "" +
                "</td>\n" +
                "<td>\n" +
                "" + expensesList[expensesList.indexOf(expense)].payableAt.toLocaleDateString() + "" +
                "</td>\n" +
                "<td>\n" +
                "<span class=\"" + style + "\">" + payedResult + "</span>\n" +
                "</td>\n" +
                "<td >\n" +
                "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"" +
                "onclick=\"initParams(" + response.id + ")\">Modifier</a>\n" +
                "</td>\n" +
                "<td>\n" +
                "<a href=\"javascript:void(0)\" class=\"badge badge-danger\" \n" +
                "                                    onclick=\"deleteExpense(" + response.id + ")\">Supprimer</a>" +
                "</td>\n" +
                "</tr>");
            Swal.fire({
                text: "Charge modifié avec succée",
                title: 'Success',
                icon: 'success',
            });
        };
        makeAjaxCall("/Expenses/update-expense", "POST", params, null, completeCallback)
    }
}
