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
                break;

            default: 

                switch (validation.usernameRegex.test($("#"+id).val())) 
                {
                    case false:
                        $("#"+id).addClass('formError');
                        retVal=false;
                        break;
        
                    default: 
                        $("#"+id).removeClass('formError');
                        retVal=true;
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
                break;

            default: 
                $("#"+id).removeClass('formError');
                retVal=true;
                break;
        }
        
        return retVal;
    },
    'submitValidation' : function(id)
    {
        submit=true;
        
        $('.username-validate').each(function() 
        { 
            if(!validation.usernameValidation($(this).attr('id')))
            {
                submit = false;
            }
        });
        
        $('.password-validate').each(function() 
        { 
            if(!validation.passwordValidation($(this).attr('id')))
            {
                submit = false;
            }
        });

        if(submit)
        {
            $.post( 
                window.location.href, 
                $(this).closest("form").serialize(), 
                function( ajaxResponse )
                {  
                    console.log(ajaxResponse)
                    var ajaxResponse = jQuery.parseJSON(ajaxResponse); 
                    switch (ajaxResponse.Response) {
                        case 'OK': 
                            console.log(ajaxResponse.Message);
                            $(this).closest("form")[0].reset();
                            break;
                        default: 
                            console.log(ajaxResponse.Message);
                            $(this).closest("form")[0].reset();
                            break;
                    }
            }); 
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