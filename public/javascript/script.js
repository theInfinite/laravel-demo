//$('#addUserForm').on('submit', function(e) {
//    e.preventDefault();
//    alert('hreeeeee');
//});



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
                    console.log(result);
                    $("#userListing").html(result);
                }
            });
    });
});

var deleteRequest = null;

var deleteUser = function($emailId) {

    var token = $('input[name="_token"]').val();

    if (deleteRequest != null)
        deleteRequest.abort();
    deleteRequest = $.ajax({
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
    });
}