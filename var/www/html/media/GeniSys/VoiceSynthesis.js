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
		VoiceSynthesis.synth.speak(new SpeechSynthesisUtterance(text));
	}, 
	'StopSpeaking' :  function()
	{
        VoiceSynthesis.synth.cancel();
    } 
}