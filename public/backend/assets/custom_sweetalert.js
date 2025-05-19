$(function () {
    "use strict";
    $(document).on('click', '.delete-confirm', function () {
        let url = $(this).data('route');
        let csrf = $(this).data('csrf');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Delete Data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {
                        _token: csrf,
                        _method: 'DELETE'
                    },
                    success: function (data) {
                        if (data.error) {
                            Swal.fire(
                                'Error!',
                                data.error,
                                'error'
                            )
                        }else{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            location.reload();
                        }
                       
                    },
                    error: function (request, status, error) {
                        alert(error);
                    }
                });

                
            }
        })
    });
});

$(function () {
    "use strict";
    $(document).on('click', '.transfer-approve', function () {
        let url = $(this).data('route');
         let csrf = $(this).data('csrf');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Approve Transfer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {
                        _method: 'POST',
                        _token: csrf,
                    },
                    success: function (data) {

                        location.reload();

                    }
                });
                Swal.fire(
                    'Approved!',
                    'Your Transfer has been Approved.',
                    'success'
                )
            }
        })


    });
});

$(function () {
    "use strict";
    $(document).on('click', '.voucher-approve', function () {
        let url = $(this).data('route');
         let csrf = $(this).data('csrf');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Approve Voucher",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {
                        _method: 'POST',
                        _token: csrf,
                    },
                    success: function (data) {

                        location.reload();

                    }
                });
                Swal.fire(
                    'Approved!',
                    'Your Voucher has been Approved.',
                    'success'
                )
            }
        })


    });
});


function confirm() {
    let link = $('#status_route').val();
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Approve 2",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.value) {
            window.location.href = link;
            Swal.fire(
                'Confirmed!',
                'Your Enrollment has been approved.',
                'success'
            )
        }
    })
}

$(function () {
    "use strict";
    $(document).on('click', '.reverse-voucher', function () {
        let url = $(this).data('route');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Reverse this Voucher",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: url,
                    data: {
                        _method: 'GET'
                    },
                    success: function (data) {

                        location.reload();

                    }
                });
                Swal.fire(
                    'Done!',
                    'Voucher has been Reversed.',
                    'success'
                )
            }
        })


    });
});


$(function () {
    "use strict";
    $(document).on('click', '.deactive-employee', function () {
        let url = $(this).data('route');
        let csrf = $(this).data('csrf');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Deactive Data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Deactive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {
                        _method: 'POST',
                        _token: csrf,
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
                Swal.fire(
                    'Deactived!',
                    'Your Employee has been Deactived.',
                    'success'
                )
            }
        })
    });
});
