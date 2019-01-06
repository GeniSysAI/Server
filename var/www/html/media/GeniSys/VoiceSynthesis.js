/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  Voice Synthesis
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var VoiceSynthesis = 
{
	'synthesis'    : window.speechSynthesis,
	'Speak' : function (text)
	{
		text = text.replace(new RegExp('GeniSys', 'g'), '');

		VoiceRecognition.pause()

		var VSynth = new SpeechSynthesisUtterance(text);
		var voices = this.synthesis.getVoices()

		VSynth.voice = voices[0];
		VSynth.pitch = 1;
		VSynth.rate = 1;

		sessionStorage.speakingState="true"
		this.synthesis.speak(VSynth);

		VSynth.onend = function(event) 
		{
			setTimeout(function()
			{ 
				console.log("End")
				VoiceRecognition.resume()
				sessionStorage.speakingState="false"
		
			}, 1500);
		}
	}, 
	'StopSpeaking' :  function()
	{
        this.synthesis.cancel();
    } 
}