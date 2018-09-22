var VoiceRecognition = { 
	'bootUp' : function (){
							
		annyang.addCallback('result', function(userSaid) {
			console.log(userSaid)
		});
							
		annyang.addCallback('resultNoMatch', function(userSaid) { console.log(userSaid)
			
			console.log(userSaid)
			$("#GeniSysChat").prepend("Human: " + userSaid[0] +"<br />") 
			$.post( window.location.href , 'ftype=genisysInference&humanInput='+userSaid[0]+'&isVoice=1', function( Response )
			{ 
				console.log(Response)
				var Response = jQuery.parseJSON( Response ); 
				presponse    = Response.ResponseData[0].Response
				console.log(Response.ResponseData)

				$("#GeniSysChat").prepend("GeniSys: " + presponse +"<br />") 
				$("#humanInput").val("")

				if(Response.Redirect)
				{
					location.reload(Response.Redirect)
				}
				
			});
			
		});
		
		annyang.setLanguage('en-GB')
		annyang.start();
		
		
    },
	'pause' : function (){
		
		annyang.pause();
		
    },
	'resume' : function (){
		
		annyang.resume();
		sessionStorage.recognitionState=="true"
		
    },
	'terminate' : function (){
		
		annyang.abort();
		sessionStorage.recognitionState=="false"
		
    }
};

$(document).ready(function(){
		VoiceRecognition.bootUp()
});