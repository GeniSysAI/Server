/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  Form Validation
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var validation = {
    
    'emailRegex' : /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    'phoneRegex' : /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/,
    'usernameRegex' : /^[a-zA-Z0-9]+$/,
    'urlRegex' : /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,
    'usernameValidation' : function(id)
    {
        var retVal = false;
        switch ($("#"+id).val()) 
        {
            case "":
                $("#"+id).addClass('formError');
                retVal=false;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Username Empty"
                );
                break;

            default: 

                switch (validation.usernameRegex.test($("#"+id).val())) 
                {
                    case false:
                        $("#"+id).addClass('formError');
                        retVal=false;
                        Logging.logMessage(
                            "Core",
                            "Validation",
                            "Username Validation Failed ("+ $("#"+id).val() + ")"
                        );
                        break;
        
                    default: 
                        $("#"+id).removeClass('formError');
                        retVal=true;
                        Logging.logMessage(
                            "Core",
                            "Validation",
                            "Username Validation OK ("+ $("#"+id).val() + ")"
                        );
                        break;
                }
                break;
        }

        return retVal;

    },
    'passwordValidation' : function(id)
    { 
        var retVal = false;
        switch ($("#"+id).val()) 
        {
            case "":
                $("#"+id).addClass('formError');
                retVal=false;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Password Validation Failed"
                );
                break;

            default: 
                $("#"+id).removeClass('formError');
                retVal=true;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Password Validation OK"
                );
                break;
        }
        
        return retVal;
    },
    'submitValidation' : function(id)
    {
        console.log("HERE")
        submit=true;
        
        $('.username-validate').each(function() 
        { 
            if(!validation.usernameValidation(this.id))
            {
                submit = false;
            }
        });
        
        $('.password-validate').each(function() 
        { 
            if(!validation.passwordValidation(this.id))
            {
                submit = false;
            }
        });

        if(submit)
        {
            $.post( 
                window.location.href, 
                $("#"+id).closest("form").serialize(), 
                function( ajaxResponse )
                {  
                    console.log(ajaxResponse)
                    var ajaxResponse = jQuery.parseJSON(ajaxResponse); 
                    $("#"+id).closest("form")[0].reset();
                    switch (ajaxResponse.Response) {
                        case 'OK': 			
                            setTimeout(function(){
                                console.log(ajaxResponse.Message);
                                VoiceSynthesis.Speak(ajaxResponse.Message)	
                                setTimeout(function(){
                                    location.reload("/dashboard")
                                },1000); 
                            },1000); 
                            break;
                        default: 	
                            setTimeout(function(){		
                                console.log(ajaxResponse.Message);
                                VoiceSynthesis.Speak(ajaxResponse.Message)	
                            },1000); 
                            break;
                    }
                }
            ); 
        }
        else
        {
            console.log("Submit Error")
        }
    },
    'ResetForm': function(id)
    {
        $("#"+id).closest('form').attr('id')[0].reset();
    }
};   

$('.container').on(
    'focusout',
    '.username-validate',
    function(){ 
        validation.usernameValidation($(this).attr('id'));
    });    
    
$('.container').on(
    'focusout',
    '.password-validate',
    function(){ 
        validation.passwordValidation($(this).attr('id'));
    });

$('.container').on(
    'click', 
    '#formSubmit',  
    function (e){
        e.preventDefault();
        validation.submitValidation($(this).attr('id'));
});