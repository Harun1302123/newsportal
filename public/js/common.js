$(document).ready(function () {
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
    $('[data-toggle="tooltip"]').tooltip();
    $("[data-toggle=popover]").popover()
});

$('body a').click(function (e) {
    console.log(10);
    let _token = $('input[name="_token"]').val();
    let action = $(this).text();
    let url = $(this).attr('href');

    if (typeof action === "undefined") {
        action = $(this).attr('id');
        if (typeof action === "undefined") {
            action = $(this).attr('name');
        }
    }

    $.ajax({
        url: '/api/action/new-job',
        type: 'post',
        data: {
            _token: _token,
            user_id: user_id,
            url: url,
            message: 'ok',
            ip_address: ip_address,
            action: action
        },
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (response) {

        },
        error: function (xhr, errors) {
        }

    });

});

$('body button').click(function (e) {
    var _token = $('input[name="_token"]').val();
    var action = $(this).text();
    var url = $(this).attr('href');

    if (typeof action === "undefined") {
        action = $(this).attr('id');
        if (typeof action === "undefined") {
            action = $(this).attr('name');
        }
    }
    $.ajax({
        url: '/api/action/new-job',
        type: 'post',
        data: {
            _token: _token,
            user_id: user_id,
            url: url,
            message: 'ok',
            ip_address: ip_address,
            action: action
        },
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (response) {
        },

    });

});


$(window).bind("load", function () {
    let _token = $('input[name="_token"]').val();
    let url = window.location.href;

    $.ajax({
        _token: _token,
        url: '/api/new-job',
        type: 'post',
        async: false,
        crossDomain: true,
        data: {
            user_id: user_id,
            url: url,
            message: 'ok',
            ip_address: ip_address
        },
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (response) {
        },
        error: function (xhr, errors) {
            debugger
        }
    });
});
