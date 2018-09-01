/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  Logging
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var Logging = {

    'logMessage' : function(process, messageType, message)
    {
        console.log(new Date($.now()) + " | " + process + " | " + messageType + " | " + message);
    }
}