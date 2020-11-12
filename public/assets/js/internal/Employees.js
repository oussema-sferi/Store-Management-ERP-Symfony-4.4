'use strict';
const addEmployeeForm = $('#addEmployeeForm');
const EmployeesDOMTable = $('#EmployeesDOMTable');
const updateEmployeeForm = $('#updateEmployeeForm');
let globalId = 0;

function createEmployee() {
    const cin = addEmployeeForm.find('#addEmployeeCINInput').val();
    const fullName = addEmployeeForm.find('#addEmployeeFullNameInput').val();
    const salary = addEmployeeForm.find('#addEmployeeSalaryInput').val();
    const IsActive = parseInt(addEmployeeForm.find("#addEmployeeIsActiveInput").val()) !== 0;
    const params = {
        cin: cin,
        fullName: fullName,
        salary: salary,
        isActive: IsActive
    };
    let completeCallback = (data) => {
        let result = JSON.parse(data.responseText);
        EmployeesList.push({
            id: result.id,
            cin: result.cin,
            fullName: result.fullName,
            salary: result.salary,
            IsActive: result.isActive
        });
        let message = result.isActive ? "Actif" : "Inactif";
        console.log(result);
        Swal.fire({
            text: "Employée ajouté avec succée",
            title: 'Success',
            icon: 'success',
        });
        EmployeesDOMTable.
        append("<tr id=\"employeesRow"+result.id+"\">"+
            "<td>" + result.id + "</td>\n" +
            "<td>" + result.cin + "</td>\n" +
            "<td>" + result.fullName + "</td>\n" +
            "<td>" + result.salary + "</td>\n" +
            "<td>" + message + "\n" +
            "</td>\n" +
            "<td >\n" +
            "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick=\"initParams(" + result.id + ")\">Modifier</a>\n" +
            "</td>\n" +
            "<td >\n" +
            " <a href=\"javascript:void(0)\" class=\"badge badge-danger\" onclick=\"deleteEmployee("+result.id+")\">Supprimer</a>"+
            "</td>"+" </tr>");
        resetDOM();
    };
    makeAjaxCall("/employees/new-employee", "POST", params, null, completeCallback);
}

function updateEmployee() {
    const cin = updateEmployeeForm.find('#updateEmployeeCINInput').val();
    const fullName = updateEmployeeForm.find('#updateEmployeeFullNameInput').val();
    const salary = updateEmployeeForm.find('#updateEmployeeSalaryInput').val();
    const IsActive = parseInt(updateEmployeeForm.find("#updateEmployeeIsActiveInput").val()) !== 0;
    console.log(IsActive);
    const params = {
        id: globalId,
        cin: cin,
        fullName: fullName,
        salary: salary,
        isActive: IsActive
    };
    console.log(params);
    const completeCallBack = (data) => {
        console.log(data);
        let result = JSON.parse(data.responseText);
        let last = EmployeesList.find((e) => e.id === result.id);
        EmployeesList[EmployeesList.indexOf(last)].id = result.id;
        EmployeesList[EmployeesList.indexOf(last)].cin = result.cin;
        EmployeesList[EmployeesList.indexOf(last)].fullName = result.fullName;
        EmployeesList[EmployeesList.indexOf(last)].salary = result.salary;
        EmployeesList[EmployeesList.indexOf(last)].IsActive = result.isActive;
        Swal.fire({
            text: "Employee Modifié avec succée",
            title: 'Success',
            icon: 'success',
        });
        let message = result.isActive===true ? "Actif" : "Inactif";
        let row = $('#employeesRow' + result.id);
        row.html("<td>" + result.id + "</td>\n" +
            "<td>" + result.cin + "</td>\n" +
            "<td>" + result.fullName + "</td>\n" +
            "<td>" + result.salary + "</td>\n" +
            "<td>" + message + "\n" +
            "</td>\n" +
            "<td >\n" +
            "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-update\" class=\"badge badge-info\"\n" +
            "onclick=\"initParams(" + result.id + ")\">Modifier</a>\n" +
            "</td>\n" +
            "<td >\n" +
            " <a href=\"javascript:void(0)\" class=\"badge badge-danger\" onclick=\"deleteEmployee("+result.id+")\">Supprimer</a>"+
            "</td>");
    };

    makeAjaxCall("/employees/update-employee", "POST", params, null, completeCallBack);
}

function deleteEmployee(id) {
    let params = EmployeesList.find((e) => e.id === id);
    let successCallback = () => {
        let row = EmployeesList.find((e) => e.id === id);
        if (row != null) {
            EmployeesList.splice(EmployeesList.indexOf(row), 1);
            $('#employeesRow' + id).remove();
            Swal.fire({
                text: "Employée supprimé avec succée",
                title: 'Success',
                icon: 'success',
            });
        }
    };
    makeAjaxCall("/employees/remove-employee", "POST", params, null, successCallback);
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
    addEmployeeForm.find('#addEmployeeCINInput').val("");
    addEmployeeForm.find('#addEmployeeFullNameInput').val("");
    addEmployeeForm.find('#addEmployeeSalaryInput').val("");
    addEmployeeForm.find("#addEmployeeIsActiveInput").val(1);
}

function initParams(id) {
    globalId = id;
    let employee = EmployeesList.find(e => e.id === id);
    let value = employee.IsActive ? 1 : 0;
    if (employee !== undefined) {
        updateEmployeeForm.find("#updateEmployeeCINInput").val(employee.cin);
        updateEmployeeForm.find("#updateEmployeeFullNameInput").val(employee.fullName);
        updateEmployeeForm.find("#updateEmployeeSalaryInput").val(employee.salary);
        updateEmployeeForm.find("#updateEmployeeIsActiveInput").val(value);
    } else
        console.log("impossible ");
}