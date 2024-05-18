var http = require("http"),
  fs = require("fs");
var xssfilter = require("xss");
var httpServer = http.createServer(httphandler);
var socketio = require("socket.io")(httpServer);
var port = 8080;
httpServer.listen(port);
console.log("HTTPS server is listenning on port " + port);

function httphandler(request, response) {
  response.writeHead(200); // 200 OK
  //ensure you have the front-end UI client.html
  var clientUI_stream = fs.createReadStream("./team05-client.html");
  clientUI_stream.pipe(response);
}
socketio.on("connection", function (socketclient) {
  console.log(
    "A new socket.IO client is connected: " +
      socketclient.client.conn.remoteAddress +
      ": " +
      socketclient.id
  );
  socketclient.on("message", (data) => {
    var data = xssfilter(data);
    console.log("Received data: " + data);
    // socketio.emit("message", socketclient.id + "says:" + data);
    socketio.emit("message", data);
  });
  socketclient.on("typing", (data) => {
    var data = xssfilter(data);
    console.log(data, " is typing");
    // Broadcast the typing event to all connected clients
    socketio.emit("typing", data);
  });
});
