/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  GeniSys
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var GeniSys = 
{
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
    },
    'startTime' : function() 
    {
        var today  = new Date();
        var locale = "en-us";
        var month  = today.toLocaleString(locale, {month: "long"});
        var y      = today.getFullYear();
        var d      = today.getDay()
        var h      = today.getHours();
        var h      = today.getHours();
        var m      = today.getMinutes();
        var s      = today.getSeconds();

        document.getElementById('clock').innerHTML = GeniSys.ordinalSuffix(d) + " " + month + " " + y + " " + h + ":" + GeniSys.checkTime(m) + ":" + GeniSys.checkTime(s);
        var t = setTimeout(
            GeniSys.startTime, 
            500);
    },
    'checkTime' : function(i)
    {
        if (i < 10) {i = "0" + i};
        return i;
    },
    'ordinalSuffix' : function(i) 
    {
        var j = i % 10,
            k = i % 100;
        if (j == 1 && k != 11) {
            return i + "st";
        }
        if (j == 2 && k != 12) {
            return i + "nd";
        }
        if (j == 3 && k != 13) {
            return i + "rd";
        }
        return i + "th";
        
    }
}

GeniSys.startTime();
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
    '/media/GeniSys/VoiceRecognition.js',
    'VoiceSynthesis', 
    function(){
        VoiceRecognition = VoiceRecognition
        sessionStorage.VoiceRecognitionLoaded=true
        Logging.logMessage(
            "Core",
            "VoiceRecognition",
            "VoiceRecognition Script Loaded"
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
            