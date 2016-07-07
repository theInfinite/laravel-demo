$(function() {
    $('#addUserForm').on('submit', function(e) {

        $pwd = $('#password').val();
        $pwd_confirm = $('#password-confirm').val();
        if($pwd != $pwd_confirm) {

            alert('Password do not match');
        }
        else {
            $.ajaxSetup({
                header: $('meta[name="_token"]').attr('content')
            })
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '/addUser',
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    if(data == 'Success') {

                        alert('You have successfully registered');
                        window.location.reload();
                    }
                },
                error: function (data) {
                    console.log('data');
                    console.log(data);
                    if(data.responseText == 'already exist'){
                        alert('Email Exist');
                    }
                }
            })
        }});

});

var searchRequest = null;

$(function () {

    $("#search_keyword").keyup(function () {
        var token = $('input[name="_token"]').val();
        var that = this,
            value = $(this).val();

            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "POST",
                url: "/findList",
                data: {
                    '_token' :token,
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(result){
                    data = JSON.parse(result);

                    $("#userListing").html(data.content);
                    $("#pagination").html(data.pagination);
                }
            });
    });
});



var showData = function () {

        var token = $('input[name="_token"]').val();
        var that = this,
            value = '';

        if (searchRequest != null)
            searchRequest.abort();
        searchRequest = $.ajax({
            type: "POST",
            url: "/findList",
            data: {
                '_token' :token,
                'search_keyword' : value
            },
            dataType: "text",
            success: function(result){

                $("#userListing").html(result);
            }
        });
}

var deleteRequest = null;

var deleteUser = function($emailId) {

    var token = $('input[name="_token"]').val();
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this user detail!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },

        function(isConfirm){

            if(isConfirm) {

                swal("Deleted!", "The user has been deleted.", "success");

                $.ajax({
                    type: "POST",
                    url: "/deleteUser",
                    data: {
                        '_token' :token,
                        'emailId' : $emailId
                    },
                    dataType: "text",
                    success: function(result){
                        $("#userListing").html(result);
                    }
                })
            }
        });
}

var editUser = function($emailId, $userId) {

    console.log($emailId);

    var token = $('input[name="_token"]').val();
    var username = $('#nameEdit' + $userId).val();
    console.log('#nameEdit' + $userId);
    console.log(username);

    var emailId = $('#emailEdit' + $userId).val();
    var password = $('#passwordEdit' + $userId).val();

        swal({
                title: "Are you sure?",
                text: "You will not be able to revert the user detail!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, update it!",
                closeOnConfirm: false
            },

            function(isConfirm){

                if(isConfirm) {

                    swal("Updated!", "The user detail has been updated.", "success");
        $.ajax({
            type: "POST",
            url: "/editUser",
            data: {
                '_token': token,
                'username': username,
                'emailId': emailId,
                'password': password
            },
            dataType: "text",
            success: function (result) {

                $("#loader").show();
                $("#userListing").hide();
                $("#UserListheading").hide();

                setTimeout(function () {
                    $("#loader").hide();
                    $("#userListing").show();
                    $("#UserListheading").show();
                    showData();
                }, 1000);

            }
        });
        }});
}