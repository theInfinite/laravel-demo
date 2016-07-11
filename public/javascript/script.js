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

var closeImage = function(e,$id) {
    e.preventDefault();
    alert('Image will be closed :: ' + $id);
    var token = $('input[name="_token"]').val();
    $.ajax({
        type: "POST",
        url: "/closeImage",
        data: {
            '_token': token,
            'file_id': $id
        },
        dataType: "text",
        success: function(result){
            console.log(result);
            $("#imageListing").html(result);
        }
    })
}



var uploadImage = function (e) {
    e.preventDefault();

    var CSRF_TOKEN = $('input[name="_token"]').val();
    var file = $('#file')[0].files[0];
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : CSRF_TOKEN }
    });
    //var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')

    var formData = new FormData();
    console.log(formData);
    formData.append('file',file);
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/uploadImage",
        data:formData,
        contentType: false,
        processData: false,

    })
};


//var CSRF_TOKEN = $('input[name="_token"]').val();
//var file = $('#file')[0].files[0];
//
//var formData = new FormData();
//formData.append('file',file);
//console.log(file);
//// console.log($(this));
//// return;
//
//// $.post('gallery/add',formData,function (data) {
//// console.log(data);
//// $("#message").html(data);
////// getGalleryData();
////
//// });
//// return false;
//$.ajaxSetup({
//    headers: { 'X-CSRF-Token' : CSRF_TOKEN }
//});
//$.ajax({
//    type: "POST",
//    url: "gallery/add", // Url to which the request is send
//    data: formData,
//    contentType: false,
//    processData: false,
//    success: function(data) // A function to be called if request succeeds
//    {
//        console.log(data);
//        if(data == 'success'){
//            $('#addButton').show();
//            $('#uploadimage').hide();
//            $('#file').val('');
//            getGalleryData();
//        }else if(data == 'no category'){
//            swal({
//                title: 'Please Add category First!',
//                text: 'Category Missing!',
//                type: 'warning',
//                timer: 3000
//            });
//        }else {
//            swal({
//                title: 'Something Went Wrong!',
//                text: 'Try Again!',
//                type: 'warning',
//                timer: 3000
//            });
//        }
//    }
//});

$(function() {
    $('#addMarkerForm').on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            header: $('meta[name="_token"]').attr('content')
        })

        $.ajax({
            type: "POST",
            url: '/addMarker',
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                if(data == 'Success') {

                    alert('You have successfully added marker');
                    window.location.reload();
                }
            },
            error: function (data) {
                console.log('data');
                console.log(data);
                if(data.responseText == 'already exist'){
                    alert('Record already exist!');
                }
            }
        })
    });
});

function initMap() {
    var token = $('input[name="_token"]').val();
    $.ajax({
        type: "POST",
        url: '/getMarkers',
        data: {
            '_token': token
        },
        success: function (locations) {

            var mapDiv = document.getElementById('map');
            var map = new google.maps.Map(mapDiv, {
                center: {lat: 20.5937, lng: 78.9629},
                zoom: 4
            });

            Object.size = function(obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key)) size++;
                }
                return size;
            };

// Get the size of an object
            var size = Object.size(locations);

            for(var i = 1; i <= size; i++) {

                new google.maps.Marker({
                    position: {lat: parseFloat(locations[i]['lat']), lng: parseFloat(locations[i]['lng'])},
                    map: map,
                    title: locations[i]['placeName']
                });
            }
        },
        error: function (locations) {

           alert('Record already exist!');
        }
    })
}

function addMarker1() {
    var mapDiv = document.getElementById('map');
    var map = new google.maps.Map(mapDiv, {
        center: {lat: 20.5937, lng: 78.9629},
        zoom: 4
    });
    new google.maps.Marker({
        position: {lat: 25.1695, lng: 75.854},
        map: map,
        title: 'Namaste India!'
    });

    new google.maps.Marker({
        position: {lat: 20.5937, lng: 78.9629},
        map: map,
        title: 'Namaste India!'
    });
}
