<?php @header('Content-Type: text/javascript; charset=utf-8');?>
    function submitForm()
    {
        if($('#email').val() != '' && $('#password').val() != '')
        {
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                url: "/login-ajax",
                type: "POST",
                enctype: 'multipart/form-data',
                data: {email: email,password:password},
                success: function(msg) {
                    console.log(msg);
                    var val = msg.split("||");
                    if (val[0] == "true") {
                        toastr.success(val[1]);
                    } else if (val[0] == "false") {
                        toastr.error(val[1]);
                    }
                }
            });
        }
        else
        {
            toastr.error('Tous les champs sont requis');
        }
    }