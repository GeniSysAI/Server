var VoiceRecognition = 
{ 
	'bootUp' : function ()
	{
		sessionStorage.speakingState = "false"					
		annyang.addCallback('result', function(userSaid) 
		{
			console.log(userSaid)
		});
							
		annyang.addCallback('resultNoMatch', function(userSaid) 
		{ 	console.log(sessionStorage.speakingState)
			if(sessionStorage.speakingState=="false")
			{
				$("#GeniSysChat").prepend("Human: " + userSaid[0] +"<br />") 
				$.post( window.location.href , 'ftype=genisysInference&humanInput='+userSaid[0]+'&isVoice=1', function( Response )
				{ 
					var Response = jQuery.parseJSON( Response ); 
					var presponse = Response.ResponseData[0].Response
	
					VoiceSynthesis.Speak(presponse);
	
					$("#GeniSysChat").prepend("GeniSys: " + presponse +"<br />") 
					$("#humanInput").val("")
	
					if(Response.Redirect)
					{
						location.reload(Response.Redirect)
					}
					
				});
			}
		});
		
		annyang.setLanguage('en-GB')
		annyang.start();
		sessionStorage.recognitionState=true
    },
	'pause' : function ()
	{
		annyang.pause();
		sessionStorage.recognitionState=false
    },
	'resume' : function ()
	{
		annyang.resume();
		sessionStorage.recognitionState=true
    },
	'terminate' : function ()
	{
		annyang.abort();
		sessionStorage.recognitionState=false
    }
};

$(document).ready(function(){
		VoiceRecognition.bootUp()
});