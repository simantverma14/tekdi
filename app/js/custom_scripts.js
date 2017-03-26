/* ==== Admin cutom scripts ======== */
$(function () {

    "use strict";

    //add validation for letters only
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Letters and spaces only please");
    
    jQuery.validator.addMethod('intlphone', function(value) { 
        return (value.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/)); 
    }, 'Please enter a valid phone number');

    //Data table
    if ($('#users_table').length){ 
        var table =  $('#users_table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            stateSave: true,
            "aaSorting": [],
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "Nothing found - sorry",
                //"info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            columnDefs: [
                { orderable: false, targets: -1 }
             ]
        });

        // Setup - add a text input to each footer cell
        $('#users_table thead tr#filterrow th').each(function () {
            var title = $('#users_table thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        });

        // Apply the filter
        $("#users_table thead input").on('keyup change', function () {
            table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });
    }

    //confirm box for delete file
    $('#confirmDelete').on('shown.bs.modal', function (e) {
        $(this).find('#confirm').attr('href', $(e.relatedTarget).data('href'));
    });

    //ckeditor
    if ($('#about_you').length){
        CKEDITOR.config.height = 150;
        CKEDITOR.config.width = 'auto';
        CKEDITOR.replace('about_you');
    }
    
    // Birthday picker in user add form
    if($('#birthdaypicker').length){
        $('#birthdaypicker').datetimepicker({
            viewMode: 'years',
            format: 'YYYY/MM/DD'
        });
    }

    // Validate Add User form
    $("#adduser").validate({
        ignore: [],
        rules: {
            name: {
                lettersonly: true,
                required: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + "app/check-email.php",
                    type: "post",
                    data: {
                        CSRF_token: function () {
                            return $("[name='CSRF_token']").val();
                        },
                        email: function () {
                            return $("#email").val();
                        }
                    }
                }
            },
            country_id: {
                required: true
            },
            mobile_number: {
                required: true,
                intlphone: true,
                minlength: 7,
                maxlength:15
            },
            birthday: {
                required: true
            },
            about_you: {
                required: function(){
                    CKEDITOR.instances.about_you.updateElement();
                }
            }
        },
        messages: {
            email: {
                required: "Please enter email address",
                remote: "Email address already registered"
            },
            country_id: {
                required: "Please select country"
            },
            birthday: {
                required: "Please select birthday"
            },
            about_you: {
                cke_required: "Please enter about info"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.attr('id') == 'about_you') {
                error.insertAfter('#cke_about_you');
            }  else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var form_data = $(form).serializeArray();
            form_data.push({name: 'form_type', value: 'add_user'});
            $.post(site_url + "app/ajax.php", form_data, function (data) {
                if (data.status) {
                    $('#btn-adduser').attr('disabled', 'disabled');
                    $('#btn-adduser').button('loading');
                    
                    $('#usersuccess').find('p').html(data.messsage);
                    $('#usersuccess').show();
                    $("#usersuccess").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).closest("." + $(this).attr("data-hide")).hide();
                        window.location = site_url+ "index.php?page=users&action=list";
                    });
                } else {
                    $('#useralert').find('p').html(data.messsage);
                    $('#useralert').show();
                }
            }, 'json');
        }
    });

    // Validate Edit User form
    $("#edituser").validate({
        ignore: [],
        rules: {
            name: {
                lettersonly: true,
                required: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + "app/check-email.php",
                    type: "post",
                    data: {
                        CSRF_token: function () {
                            return $("[name='CSRF_token']").val();
                        },
                        user_id: function () {
                            return $("[name='user_id']").val();
                        },
                        email: function () {
                            return $("#email").val();
                        }
                    }
                }
            },
            country_id: {
                required: true
            },
            mobile_number: {
                required: true,
                intlphone: true,
                minlength: 7,
                maxlength:15
            },
            birthday: {
                required: true
            },
            about_you: {
                required: function(){
                    CKEDITOR.instances.about_you.updateElement();
                }
            }
        },
        messages: {
            email: {
                required: "Please enter email address",
                remote: "Email address already registered"
            },
            country_id: {
                required: "Please select country"
            },
            birthday: {
                required: "Please select birthday"
            },
            about_you: {
                cke_required: "Please enter about info"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.attr('id') == 'about_you') {
                error.insertAfter('#cke_about_you');
            }  else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var form_data = $(form).serializeArray();
            form_data.push({name: 'form_type', value: 'edit_user'});
            $.post(site_url + "app/ajax.php", form_data, function (data) {
                if (data.status) {
                    $('#btn-edituser').attr('disabled', 'disabled');
                    $('#btn-edituser').button('loading');
                    
                    $('#editsuccess').find('p').html(data.messsage);
                    $('#editsuccess').show();
                    $("#editsuccess").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).closest("." + $(this).attr("data-hide")).hide();
                        window.location = site_url+ "index.php?page=users&action=list";
                    });
                } else {
                    $('#editalert').find('p').html(data.messsage);
                    $('#editalert').show();
                }
            }, 'json');
        }
    });
});
