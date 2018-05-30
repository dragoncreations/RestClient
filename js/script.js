$(document).ready(function () {
    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        postPerson(form);
        form.find("input[type=text]").val("");
    });

    $('#edit_form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        putPerson(form, $('#edit'));
    });

    getPeople();
});

$(document).on('click', 'a.btn-danger', function (e) {
    e.preventDefault();
    var modal = $('#confirm-delete');
    var button = modal.find('.btn-ok');
    var pID = $(this).data('pid');
    button.attr('title', pID);
});

$(document).on('click', 'a.btn-success', function (e) {
    e.preventDefault();
    var modal = $('#edit');
    var pID = $(this).data('pid');
    getPerson(pID, modal);
});

$(document).on('click', 'a.btn-ok', function (e) {
    e.preventDefault();
    var pID = $(this).attr('title');
    deletePerson(pID);
    $('#confirm-delete').modal('hide');
});

function getPeople(id) {
    $.ajax({
        url: "ajax.php",
        type: "get",
        dataType: 'html',
        data: {
            actionName: 'getPeople'
        },
        success: function (response) {
            $('.table tbody').html(response);
        }
    });
}

function getPerson(id, modal) {
    var input_id = modal.find('#edit_id');
    var input_firstname = modal.find('#edit_firstname');
    var input_lastname = modal.find('#edit_lastname');

    $.ajax({
        url: "ajax.php",
        type: "get",
        dataType: 'json',
        data: {
            actionName: 'getPeople',
            params: id
        },
        success: function (response) {
            input_id.val(response.id);
            input_firstname.val(response.firstname);
            input_lastname.val(response.lastname);
        }
    });
}

function postPerson(form) {
    $.ajax({
        url: "ajax.php",
        type: "post",
        dataType: 'text',
        data: {
            actionName: 'postPerson',
            params: form.serialize()
        },
        success: function (response) {
            getPeople();
        }
    });
}

function putPerson(form, modal) {
    $.ajax({
        url: "ajax.php",
        type: "post",
        dataType: 'text',
        data: {
            actionName: 'putPerson',
            params: form.serialize()
        },
        success: function (response) {
            modal.modal('hide');
            getPeople();
        }
    });
}

function deletePerson(id) {
    $.ajax({
        url: "ajax.php",
        type: "post",
        dataType: 'text',
        data: {
            actionName: 'deletePerson',
            params: id
        },
        success: function (response) {
            getPeople();
        }
    });
}