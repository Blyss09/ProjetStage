<?php @header('Content-Type: text/javascript; charset=utf-8');?>
    function checkTxt(value)
    {
        if(!/[^a-z A-Z]/.test(value))
            return false;
        return true;
    }

    function ValidateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(txtPhone) {
        //var a = document.getElementById(txtPhone).value;
        var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (filter.test(txtPhone)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function updateEmploye()
    {
        if($('#nom').val() != '' && $('#prenoms').val() != '' && $('#email').val() != ''
        && $('#nompro').val() != '' && $('#prenomspro').val() != '' && $('#telpro').val() != '' && $('#poste').val() != ''
        && $('#manager').val() != '' && $('#role').val() != '')
        {

            
            var msg = '';
            if($('#password').val() != '')
            {
                if($('#password').val().length < 8)
                    msg += 'Entrer plus de 8 caractères pour le mot de passe <br>';
            }
            if(checkTxt($("#nom").val()) != false)             
                msg += 'N\'utiliser que des caractères pour le champ Nom <br>';

            if(checkTxt($("#nompro").val()) != false)             
                msg += 'N\'utiliser que des caractères pour le champ Nom professionnel <br>';

            if(checkTxt($("#prenoms").val()) != false)             
                msg += 'N\'utiliser que des caractères pour le champ Prénoms <br>';

            if(validatePhone($("#telpro").val()) == false)             
                msg += 'Le format du téléphone professionnel est incorrect. (Utilisez:+33 00 000 0000/0033 00-000-0000/(33)00-000-0000) <br>';

            if(checkTxt($("#prenomspro").val()) != false)             
                msg += 'N\'utiliser que des caractères pour le champ Prénoms professionnel <br>';

            if(ValidateEmail($('#email').val()) == false)
            {
                msg += 'Le format de l\'adresse email est incorrect<br>';
            }
            
            if($('#tel').val() != '')
            {
                if(validatePhone($('#tel').val()) == false)
                {
                    msg += 'Le format du téléphone est incorrect. (Utilisez:+33 00 000 0000/0033 00-000-0000/(33)00-000-0000)<br>';
                }
            }

            if(msg != '')
            {
                toastr.error(msg);
                return ;
            }


            $.ajax({
            url: '/customer/updateUserAjax/0.' + Math.floor(Math.random() * 10000000000) + 1,
            type: "POST",
            enctype: 'multipart/form-data',
            data: {nom:$('#nom').val(),prenoms:$('#prenoms').val(),email:$('#email').val(),nompro:$('#nompro').val(),prenomspro:$('#prenomspro').val(),
                telpro:$('#telpro').val(),poste:$('#poste').val(),tel:$('#tel').val(),manager:$('#manager').val(),role:$('#role').val(),
                password:$('#password').val(),},
            success: function(msg) {
                console.log(msg);
                var val = msg.split("||");
                if (val[0] == "true") {
                    toastr.success(val[1]);
                    setTimeout(() => {
                        location.reload();
                    }, 500);


                } else if (val[0] == "false") {
                    toastr.error(val[1]);
                }
            }
        })
        }
        else
            toastr.error('Tous les champs avec * sont requis');
    }