import asyncio
import websockets
import json
from datetime import datetime
from http.server import BaseHTTPRequestHandler, HTTPServer
import threading

connected_clients = set()

# =========================
# WEBSOCKET
# =========================
async def handle_client(websocket):
    connected_clients.add(websocket)

    client_id = id(websocket)
    print(f"Cliente {client_id} conectado")

    try:
        async for message in websocket:
            data = json.loads(message)

            # reenviar a todos
            for client in connected_clients:
                try:
                    await client.send(json.dumps(data))
                except:
                    pass

    except websockets.exceptions.ConnectionClosed:
        print(f"Cliente {client_id} desconectado")

    finally:
        connected_clients.remove(websocket)

# =========================
# HTTP API
# =========================
class RequestHandler(BaseHTTPRequestHandler):

    def do_POST(self):
        if self.path == "/nuevo-pedido":

            content_length = int(self.headers['Content-Length'])
            post_data = self.rfile.read(content_length)

            data = json.loads(post_data.decode())

            factura = {
                "type": "factura",
                "orden": data["orden"],
                "cliente": data["cliente"],
                "mesa": data["mesa"],
                "total": data["total"],
                "timestamp": datetime.now().isoformat()
            }

            asyncio.run(enviar_a_todos(factura))

            self.send_response(200)
            self.send_header("Content-Type", "application/json")
            self.end_headers()

            self.wfile.write(json.dumps({
                "success": True
            }).encode())

async def enviar_a_todos(data):

    if connected_clients:
        await asyncio.gather(*[
            client.send(json.dumps(data))
            for client in connected_clients
        ])

# =========================
# SERVIDORES
# =========================
async def websocket_server():
    async with websockets.serve(handle_client, "0.0.0.0", 3002):
        print("=" * 50)
        print("WebSocket activo")
        print("ws://localhost:3002")
        print("=" * 50)

        await asyncio.Future()

def http_server():
    server = HTTPServer(("0.0.0.0", 8000), RequestHandler)

    print("=" * 50)
    print("HTTP API activa")
    print("http://localhost:8000")
    print("=" * 50)

    server.serve_forever()

async def main():

    thread = threading.Thread(target=http_server)
    thread.start()

    await websocket_server()

if __name__ == "__main__":
    asyncio.run(main())