var websocketPort = wsPort ? wsPort : 8080;

var conn = new WebSocket('ws://localhost:' + websocketPort);

var idMessages = 'chatMessages';

conn.onopen = function(e) 
{
    console.log("Connection established!");
};

conn.onmessage = function(e) 
{
    document.getElementById(idMessages).value = e.data + '\n' + document.getElementById(idMessages).value;
    console.log(e.data);
};

conn.onerror = function(e) 
{
    console.log('Connection fail!');
};