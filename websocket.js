const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 3002 });

console.log("✅ WebSocket corriendo en puerto 3002");

wss.on("connection", (ws) => {

    console.log("🔌 Cliente conectado");

    ws.on("message", (message) => {

        console.log("📩 Mensaje recibido:", message.toString());

        // reenviar a todos
        wss.clients.forEach(client => {

            if (client.readyState === WebSocket.OPEN) {

                client.send(message.toString());
            }
        });
    });

    ws.on("close", () => {

        console.log("❌ Cliente desconectado");
    });
});