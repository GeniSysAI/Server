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
		sessionStorage.speakingState=true
		VoiceRecognition.pause()
		var VSynth = new SpeechSynthesisUtterance(text);
		var voices = this.synthesis.getVoices()

		VSynth.voice = voices[3];
		VSynth.pitch = 1;
		VSynth.rate = 1;
		this.synthesis.speak(VSynth);

		VSynth.onend = function(event) 
		{
			VoiceRecognition.resume()
			sessionStorage.speakingState=false
		}
	}, 
	'StopSpeaking' :  function()
	{
        this.synthesis.cancel();
    } 
}