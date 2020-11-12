let employeesSelection = $('#employee-select');
let appointmentType = $('#appointment-type');

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

function markEmployeeAsAppointed() {
    let param = {
        id: parseInt(employeesSelection.val()),
        type: appointmentType.val()
    };
    let completeCallback = (response) => {
        let result = JSON.parse(response.responseText);
        console.log(response);
        console.log('message al sari3');
        if (result.accepted===true) {
            console.log(result);
            Swal.fire({
                text: result.message,
                title: 'Success',
                icon: 'success',
            });
        } else {
            console.log(result);
            Swal.fire({
                text: result.message,
                title: 'Réponse ',
                icon: 'error',
            });
        }
    };
    makeAjaxCall("/Attendance/pointage-entre-sortie", "POST", param, null, completeCallback);
}