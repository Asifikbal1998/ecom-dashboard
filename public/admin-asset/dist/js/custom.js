$(document).ready(function () {
    // Check admin passwrd is correct or not
    $("#current_password").keyup(function () {
        let current_password = $('#current_password').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-current-password',
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == 'false') {
                    $('#is_validate').html('Current Password is Incorrect');
                } else if (resp == 'true') {
                    $('#is_validate').html('Current Password is Correct');
                }
            }, error: function () {
                alert("Error");
            }

        })
    });

    //Update cms page status
    $('.updateCmsPageStatus').click(function () {
        let status = $(this).children("i").attr("status");
        let page_id = $(this).attr("page_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-cms-page-status',
            data: { status: status, page_id: page_id },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $('#page-' + page_id).html("<i class='fas fa-toggle-off' style='color: gray;' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $('#page-' + page_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>")
                }
            }, error: function () {
                alert('error');
            }
        })
    });


    //Update Subadmin status
    $('.updateSubAdminStatus').click(function () {
        let status = $(this).children("i").attr("status");
        let page_id = $(this).attr("page_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-subadmin-status',
            data: { status: status, page_id: page_id },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $('#page-' + page_id).html("<i class='fas fa-toggle-off' style='color: gray;' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $('#page-' + page_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>")
                }
            }, error: function () {
                alert('error');
            }
        })
    });

        //Update Category status
        $('.updateCategoryStatus').click(function () {
            let status = $(this).children("i").attr("status");
            let page_id = $(this).attr("page_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-category-status',
                data: { status: status, page_id: page_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $('#page-' + page_id).html("<i class='fas fa-toggle-off' style='color: gray;' status='Inactive'></i>")
                    } else if (resp['status'] == 1) {
                        $('#page-' + page_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>")
                    }
                }, error: function () {
                    alert('error');
                }
            })
        });

        //Update product status
        $('.updateProductStatus').click(function () {
            let status = $(this).children("i").attr("status");
            let page_id = $(this).attr("page_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-product-status',
                data: { status: status, page_id: page_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $('#page-' + page_id).html("<i class='fas fa-toggle-off' style='color: gray;' status='Inactive'></i>")
                    } else if (resp['status'] == 1) {
                        $('#page-' + page_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>")
                    }
                }, error: function () {
                    alert('error');
                }
            })
        });

    // alert for delete cms page
    /* $('.confirmDelete').click(function () {  
        let name = $(this).attr('name');
        if( confirm('Are you sure to delete this '+name+ '?')) {
            return true;
        }
        return false;
    }); */

    // sweet alert for delete cms page
    $('.confirmDelete').click(function () {
        let record = $(this).attr('record');
        let recordid = $(this).attr('recordid');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/admin/"+record+"-delete/"+recordid;
            }
        });
        
    });

})