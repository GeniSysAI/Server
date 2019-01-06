/**
 * @author Adam Milton-Barker <adammiltonbarker@gmail.com>
 */

var iotJumpWayWebSoc = 
{

    "client": null,
    "connected": false,
    "host": "iot.techbubbletechnologies.com",
    "port": 9001,
    "useTLS": true,
    "cleansession": true,
    "mqttOptions": {
        locationID: 91, 
        applicationID: 76,
        applicationName: "GeniSysWebSockets",
        userName: "57oLJcbSrvb7",
        passwd: "Zy3ngwy#h3okkc?upgGq"
    },
    "connect": function ()
    {
        var reconnectTimeout = 2000;
        this.thisLocationID = iotJumpWayWebSoc.mqttOptions.locationID;
		
        this.client = new Paho.MQTT.Client(
			this.host, 
			this.port, 
			iotJumpWayWebSoc.mqttOptions.applicationName
		);
        
        var lwt = new Paho.MQTT.Message("OFFLINE");
        lwt.destinationName = iotJumpWayWebSoc.mqttOptions.locationID+"/Applications/"+iotJumpWayWebSoc.mqttOptions.applicationID+"/Status";
        lwt.qos = 0;
        lwt.retained = false;
		
        this.client.onConnectionLost = this.onConnectionLost;
        this.client.onMessageArrived = this.onMessageArrived;

        this.client.connect({
			userName: iotJumpWayWebSoc.mqttOptions.userName,
			password: iotJumpWayWebSoc.mqttOptions.passwd,
			timeout: 3,
			useSSL: this.useTLS,
			cleanSession: this.cleansession,
			onSuccess: this.onConnect,
			onFailure: this.onFail,
            willMessage: lwt
		});
    },
    "onConnect": function () 
    {
        this.connected = true;
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Connected to the iotJumpWay</p>");
        iotJumpWayWebSoc.publishToApplicationStatus();
        iotJumpWayWebSoc.subscribeToAll( {
            locationID: iotJumpWayWebSoc.mqttOptions.locationID
        });			
    },
    "onFail": function (message)
    {
        this.connected = false;
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | iotJumpWay connection failed: " + message.errorMessage + "</p>");
		
    },
    "onConnectionLost": function (responseObject) 
    {
        this.connected = false;
        if (responseObject.errorCode !== 0) 
        {
            $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | iotJumpWay connection lost: " + responseObject.errorMessage + "</p>");
        }
    },
    "onMessageArrived": function (message) 
    {
        var messageObj = {
            "topic": message.destinationName,
            "retained": message.retained,
            "qos": message.qos,
            "payload": message.payloadString,
            "timestamp": moment()
        };
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Received iotJumpWay Communication: " + message.payloadString + ", with Quality Of Service: " + message.qos+"</p>");
    },
    "disconnect": function ()
    {
        this.client.disconnect();
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Disconnected from iotJumpWay</p>");
    },
    "subscribeToAll": function()
    {  
        this.client.subscribe(iotJumpWayWebSoc.mqttOptions.locationID+"/Devices/#", {qos: 0});
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Subscribed to: " + iotJumpWayWebSoc.mqttOptions.locationID +"/Devices/#</p>");
        
    },
    "publishToApplicationStatus": function()
    {		
		message = new Paho.MQTT.Message("ONLINE");
        message.destinationName = iotJumpWayWebSoc.mqttOptions.locationID+"/Applications/"+iotJumpWayWebSoc.mqttOptions.applicationID+"/Status";	
        this.client.send(message);
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Published to: "  + iotJumpWayWebSoc.mqttOptions.locationID + "/Applications/" + iotJumpWayWebSoc.mqttOptions.applicationID + "/Status</p>");
        console.log("Published to: " + iotJumpWayWebSoc.mqttOptions.locationID + "/Applications/" + iotJumpWayWebSoc.mqttOptions.applicationID + "/Status");
        
    },
    "publishToDeviceCommands": function (params) 
    {
		message = new Paho.MQTT.Message(params.message);
        message.destinationName = params.locationID+"/Devices/"+params.zoneID+"/"+params.deviceID+"/Commands";	
        this.client.send(message);
        $("#status").prepend("<p>" + new Date($.now()) + " | iotJumpWay | STATUS | Published to: " + params.locationID+"/Devices/"+params.zoneID+"/"+params.deviceID+"/Command</p>");
	}
};
$(document).ready(function() 
{
    iotJumpWayWebSoc.connect();
});