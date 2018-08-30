var VoiceRecognition = { 
	'bootUp' : function (){
							
		annyang.addCallback('result', function(userSaid) {
			console.log(userSaid)
		});
							
		annyang.addCallback('resultNoMatch', function(userSaid) { console.log(userSaid)
			
			if(sessionStorage.speakingState=="false"){ 
				$("#TIA_Recognition_Window").prepend('<div class="TIA_Recognised_Speach"><strong>YOU:</strong><br />'+userSaid[0]+'</div>');
				$.post( window.location.href , 'query=true&recognizedText='+userSaid[0]+'&isVoice=1&staffControl='+sessionStorage.staffControl, function( Response ){ alert(Response)
					var Response = jQuery.parseJSON( Response ); 
					
				});
			} else {
				//console.log("Stil speaking")
			}
			
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
		
$('body').on('click','#vrOn',function(e){ 			
			
	if (annyang) {
			
		setTimeout(function(){

			if($('#vrOn').is(':checked')){
									
				VoiceSynthesis.Communicate("Voice recognition is now active");
				$('#actionResponse').text("Voice recognition is now active.");
				$('#actionResponseModal').modal('show');
				sessionStorage.recognitionState="true"
				
				setTimeout(function(){
					VoiceRecognition.bootUp()
				},4000); 
				
			} else {
									
				annyang.abort();
				
				VoiceSynthesis.Communicate("Voice recognition is now disabled");
				$('#actionResponse').text("Voice recognition is now disabled.");
				$('#actionResponseModal').modal('show');
				sessionStorage.recognitionState="false"
				
				
			}
		},1000); 
	
	} else {
								
		sessionStorage.recognitionState="false"
		VoiceSynthesis.Communicate("Sorry, my speech recognition features are not compatible with your browser. Please use Google Chrome or use the chat feature below.");
		$('#actionResponse').text("Sorry, my speech recognition features are not compatible with your browser. Please use Google Chrome or use the chat feature below.");
		$('#vrOn').attr('checked', false);
		$('#actionResponseModal').modal('show');
		
	}
}); 

$(document).ready(function(){
	if(sessionStorage.recognitionState=="true"){
		VoiceRecognition.bootUp()
		$('#vrOn').attr('checked', true);
	}
});