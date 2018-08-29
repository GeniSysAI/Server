/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  GeniSys
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var GeniSys = {
    'AsyncLoad' : function (url, scriptId, callback) 
    {        
        var script      = document.createElement("script"),
            firstscript = document.getElementsByTagName('script')[0];
    
        script.async = true; 
        script.src = url; 
        script.id = scriptId;
    
        if ("function" === typeof(callback))
        {
          script.onload = function()
          {
            callback();
            script.onload = script.onreadystatechange = undefined;
          };
          script.onreadystatechange = function() {
            if ("loaded" === script.readyState || "complete" === script.readyState) 
            {
              script.onload();
            }
          };
        }        
        firstscript.parentNode.insertBefore(
            script, 
            firstscript);
    }
}

GeniSys.AsyncLoad(
    '/media/GeniSys/VoiceSynthesis.js',
    'VoiceSynthesis', 
    function(){
        VoiceSynthesis = VoiceSynthesis
        sessionStorage.VoiceSynthesisLoaded=true
        Logging.logMessage(
            "Core",
            "VoiceSynthesis",
            "VoiceSynthesis Script Loaded"
        );
    });
    
GeniSys.AsyncLoad(
    '/media/GeniSys/validation.js',
    'Validation', 
    function(){
        Validation = validation
        sessionStorage.ValidationLoaded=true
        Logging.logMessage(
            "Core",
            "Validation",
            "Validation Script Loaded"
        );
    });