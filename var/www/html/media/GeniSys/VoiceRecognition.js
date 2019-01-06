var VoiceRecognition = { 
	'bootUp' : function (){
							
		annyang.addCallback('result', function(userSaid) {
			console.log(userSaid)
		});
							
		annyang.addCallback('resultNoMatch', function(userSaid) { console.log(userSaid)
			
			console.log(userSaid)
			$.post( window.location.href , 'query=true&recognizedText='+userSaid[0]+'&isVoice=1&staffControl='+sessionStorage.staffControl, function( Response )
			{ alert(Response)
				var Response = jQuery.parseJSON( Response ); 
				//console.log("Stil speaking")
				
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