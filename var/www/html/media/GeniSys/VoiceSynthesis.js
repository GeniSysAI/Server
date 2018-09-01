/////////////////////////////////////////////////////////
// 
// @project GeniSys AI Location UI
// @module  Voice Synthesis
// @author  Adam Milton-Barker <www.adammiltonbarker.com>
// 
/////////////////////////////////////////////////////////

var VoiceSynthesis = {
	'synth'    : window.speechSynthesis,
	'settings' : 
	{
		'inputForm'   : document.querySelector('form'),
		'inputTxt'    : document.querySelector('.txt'),
		'voiceSelect' : document.querySelector('select'),
		'pitch'       : document.querySelector('#pitch'),
		'pitchValue'  : document.querySelector('.pitch-value'),
		'rate'        : document.querySelector('#rate'),
		'rateValue'   : document.querySelector('.rate-value')
	},
	'Speak' : function (text)
	{
		var voices = window.speechSynthesis.getVoices();
		var msg = new SpeechSynthesisUtterance();
		msg.voice = voices[10];
		msg.voiceURI = 'system';
		msg.volume = 1; 
		msg.rate = 1; 
		msg.pitch = 1;
		msg.lang = 'en-US';
		this.synth.speak(msg);
	}, 
	'StopSpeaking' :  function()
	{
        this.synth.cancel();
    } 
}