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


    //Update product Attribute status
    $('.updateProductAttributeStatus').click(function () {
        let status = $(this).children("i").attr("status");
        let page_id = $(this).attr("page_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-product-attribute-status',
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
                window.location.href = "/admin/" + record + "-delete/" + recordid;
            }
        });
    });


    // Add edit product attributes script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="size[]"  id="size[]" placeholder="Size" style="width: 150px;"/>&nbsp; <input type="text" name="sku[]" id="sku[]" placeholder="Sku" style="width: 150px;"/>&nbsp; <input type="text" name="price[]" id="price[]" placeholder="Price" style="width: 150px;"/>&nbsp; <input type="text" name="stock[]" id="stock[]" placeholder="Stock" style="width: 150px;"/><a href="javascript:void(0);" class="remove_button"> Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    // Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        } else {
            alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
        }
    });

    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
    // Add edit product attributes script end

})