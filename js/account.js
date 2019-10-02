

    $('#submitData').on('click', function(e) {

        if ( $('#password').val() != $('#confirmPassword').val()) {
            $("#password, #confirmPassword" ).attr("style",  "border-color: red" );
            $("#passwordHelpBlock").text('Passwords do not match');
            e.preventDefault();
            
        }
        
    })

