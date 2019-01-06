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
    'textValidation' : function(id)
    {
        var retVal = false;
        switch ($("#"+id).val())
        {
            case '':
                $("#"+id).addClass('formError');
                retVal=false;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Text Field Empty"
                );
                break;

            default:
                $("#"+id).removeClass('formError');
                retVal=true;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Text Field Validation OK ("+ $("#"+id).val() + ")"
                );
        }
        return retVal;
    },
    'selectValidation' : function(id)
    {
        var retVal = false;
        switch ($("#"+id).val())
        {
            case '':
                $("#"+id).addClass('formError');
                retVal=false;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Select Empty"
                );
                break;

            case undefined:
                $("#"+id).addClass('formError');
                retVal=false;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Select Undefined"
                );
                break;

            default:
                $("#"+id).removeClass('formError');
                retVal=true;
                Logging.logMessage(
                    "Core",
                    "Validation",
                    "Select Validation OK ("+ $("#"+id).val() + ")"
                );
        }
        return retVal;
    },
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
    'submitValidation' : function(id, toAppend = false, appendIt = null, appendItID = null)
    {
        submit=true;

        Logging.logMessage(
            "Core",
            "Forms",
            "Begin Form Submission"
        );
        
        $('.username-validate').each(function() 
        { 
            if(!validation.usernameValidation(this.id))
            {
                submit = false;
                console.log(this.id)
            } 
        });
        
        $('.password-validate').each(function() 
        { 
            if(!validation.passwordValidation(this.id))
            {
                submit = false;
                console.log(this.id)
            }
        });
        
        $('.text-validate').each(function() 
        { 
            if(!validation.textValidation(this.id))
            {
                submit = false;
                console.log(this.id)
            }
        });
        
        $('.select-validate').each(function() 
        { 
            if(!validation.selectValidation(this.id))
            {
                submit = false;
                console.log(this.id)
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
                    switch (ajaxResponse.Response) 
                    {
                        case 'OK':

                            switch (toAppend)
                            {
                                case true:

                                    if(ajaxResponse.ResponseData instanceof Array)
                                    {
                                        presponse = ajaxResponse.ResponseData[0].Response 
                                    }
                                    else
                                    {
                                        presponse = ajaxResponse.ResponseData.Response
                                    }

                                    VoiceSynthesis.Speak(presponse);

                                    $("#"+appendItID).prepend("GeniSys: " + presponse +"<br />") 
                                    $("#humanInput").val("")

                                    if(ajaxResponse.Redirect)
                                    {
                                        window.location.replace(location.protocol + '//' + location.hostname + ajaxResponse.Redirect)
                                    }
                                    break;

                                default:

                                    if(ajaxResponse.Redirect)
                                    {
                                        window.location.replace(location.protocol + '//' + location.hostname + ajaxResponse.Redirect)
                                    }
                                    break;
                            }

                            Logging.logMessage(
                                "Core",
                                "Forms",
                                "Form Submission Successful"
                            );
                            break;

                        default:
                        
                            switch (toAppend)
                            {
                                case true:

                                    if(ajaxResponse.ResponseData instanceof Array)
                                    {
                                        presponse = ajaxResponse.ResponseData[0].Response
                                    }
                                    else
                                    {
                                        presponse = ajaxResponse.ResponseData.Response
                                    }

                                    VoiceSynthesis.Speak(presponse);

                                    $("#"+appendItID).prepend("GeniSys: " + presponse +"<br />") 
                                    $("#humanInput").val("")

                                    if(ajaxResponse.Redirect)
                                    {
                                        window.location.replace(location.protocol + '//' + location.hostname + ajaxResponse.Redirect)
                                    }
                                    break;

                                default: 
                                    break;
                            }
                            
                            Logging.logMessage(
                                "Core",
                                "Forms",
                                "Form Submission Failed: "+ajaxResponse.ResponseMessage
                            );

                            break;
                    }
                }
            ); 
        }
        else
        { 
            Logging.logMessage(
                "Core",
                "Forms",
                "Form Submission Failed"
            );
        }
    },
    'ResetForm': function(id)
    {
        $("#"+id).closest('form').attr('id')[0].reset();
    }
};   

$('#wrapper').on(
    'focusout',
    '.text-validate',
    function(){ 
        validation.textValidation($(this).attr('id'));
    });  

$('#wrapper').on(
    'focusout',
    '.select-validate',
    function(){ 
        validation.selectValidation($(this).attr('id'));
    });  

$('#wrapper').on(
    'click', 
    '#formSubmit',  
    function (e){
        e.preventDefault();
        validation.submitValidation($(this).attr('id'));
}); 

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
        
        var toAppend   = false;
        var appendIt   = $(this).closest("form").attr('append');
        var appendItID = $(this).closest("form").attr('appendid');

        if (typeof appendIt !== typeof undefined && appendIt !== false) 
        {
            var toAppend = true;
            console.log(toAppend)
            console.log(appendItID)
        }

        validation.submitValidation($(this).attr('id'), toAppend, appendIt, appendItID);
});

$('#wrapper').on(
    'click', 
    '#formSubmit',  
    function (e){
        e.preventDefault();
        
        var toAppend   = false;
        var appendIt   = $(this).closest("form").attr('append');
        var appendItID = $(this).closest("form").attr('appendid');

        if (typeof appendIt !== typeof undefined && appendIt !== false) 
        {
            var toAppend = true;
            $("#"+appendItID).prepend("Human: " + $("#humanInput").val()+"<br />");
        }

        validation.submitValidation($(this).attr('id'), toAppend, appendIt, appendItID);
});

$('#wrapper').on(
    'click', 
    '#mediaFormSubmit',  
    function (e){
        e.preventDefault();
        $(this).closest("form").submit();
});

$('#form').keypress(function (e) {
    if (e.which == 13) {
        
        var toAppend   = false;
        var appendIt   = $(this).closest("form").attr('append');
        var appendItID = $(this).closest("form").attr('appendid');

        if (typeof appendIt !== typeof undefined && appendIt !== false) 
        {
            var toAppend = true;
            $("#"+appendItID).prepend("Human: " + $("#humanInput").val()+"<br />");
        }

        validation.submitValidation($(this).attr('id'), toAppend, appendIt, appendItID);
        return false;
    }
});