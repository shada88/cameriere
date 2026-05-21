const socket = new WebSocket("ws://localhost:3002");

socket.onopen = () => {
    console.log("✅ Conectado al WebSocket");
};

socket.onmessage = (event) => {

    console.log("📩 Mensaje RAW:", event.data);

    try {

        const data = JSON.parse(event.data);

        console.log("📦 Evento recibido:", data);

        if (data.type === "factura") {

            alert(
                `Nuevo pedido\nMesa: ${data.mesa}\nTotal: $${data.total}`
            );

            if (typeof cargarFacturas === "function") {
                cargarFacturas();
            }
        }

    } catch (error) {

        console.error("❌ Error leyendo JSON:", error);
        console.log("⚠️ Lo recibido NO era JSON válido");
    }
};

socket.onclose = () => {
    console.log("❌ WebSocket desconectado");
};

socket.onerror = (error) => {
    console.error("❌ Error WebSocket:", error);
};

document.addEventListener("DOMContentLoaded", () => {

    const logoutBtn = document.getElementById("logoutBtn");

    const mesasSection = document.getElementById("mesasSection");
    const productosSection = document.getElementById("productosSection");
    const facturasSection = document.getElementById("facturasSection");

    const mesasContainer = document.getElementById("mesasContainer");
    const productosContainer = document.getElementById("productosContainer");
    const facturasContainer = document.getElementById("facturasContainer");

    // =========================
    // NAVEGACIÓN
    // =========================

    document.querySelectorAll(".category-btn").forEach(btn => {

        btn.addEventListener("click", () => {

            const section = btn.dataset.section;

            [mesasSection, productosSection, facturasSection]
                .forEach(s => s.classList.add("hidden"));

            if (section === "mesas") {

                mesasSection.classList.remove("hidden");
                cargarMesas();

            } else if (section === "productos") {

                productosSection.classList.remove("hidden");
                cargarProductos();

            } else if (section === "facturas") {

                facturasSection.classList.remove("hidden");
                cargarFacturas();
            }
        });
    });

    // =========================
    // MESAS
    // =========================

    async function cargarMesas() {

        try {

            const res = await fetch("mesas.php?action=listar");

            const texto = await res.text();

            console.log("📥 Respuesta mesas:", texto);

            const mesas = JSON.parse(texto);

            mesasContainer.innerHTML = "";

            if (mesas.length === 0) {

                mesasContainer.innerHTML =
                    "<p>No hay mesas registradas.</p>";

                return;
            }

            mesas.forEach(mesa => {

                const card = document.createElement("div");

                card.className =
                    "bg-white shadow-md rounded-xl p-4 flex justify-between items-center";

                card.innerHTML = `
                    <span class="font-bold text-gray-800">
                        Mesa ${mesa.Mesa}
                    </span>

                    <div class="flex gap-2">
                        <button class="editarBtn text-blue-500 hover:underline">
                            Editar
                        </button>

                        <button class="eliminarBtn text-red-500 hover:underline">
                            Eliminar
                        </button>
                    </div>
                `;

                card.querySelector(".eliminarBtn")
                    .addEventListener("click", () => eliminarMesa(mesa.idCame));

                card.querySelector(".editarBtn")
                    .addEventListener("click", () =>
                        editarMesa(mesa.idCame, mesa.Mesa)
                    );

                mesasContainer.appendChild(card);
            });

        } catch (error) {

            console.error("❌ Error cargando mesas:", error);
        }
    }

    document.getElementById("formMesa")
        .addEventListener("submit", async e => {

            e.preventDefault();

            const mesaNombre =
                document.getElementById("mesaNombre").value;

            if (!mesaNombre) return;

            try {

                const res = await fetch("mesas.php", {
                    method: "POST",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded"
                    },
                    body:
                        `action=guardar&mesa=${encodeURIComponent(mesaNombre)}`
                });

                const data = await res.json();

                console.log(data);

                if (data.success) {

                    cargarMesas();

                    document.getElementById("mesaNombre").value = "";
                }

            } catch (error) {

                console.error(error);
            }
        });

    async function eliminarMesa(id) {

        try {

            const res =
                await fetch(`mesas.php?action=eliminar&id=${id}`);

            const data = await res.json();

            if (data.success) {
                cargarMesas();
            }

        } catch (error) {

            console.error(error);
        }
    }

    async function editarMesa(id, mesaActual) {

        const nuevoNombre =
            prompt("Editar nombre de la mesa:", mesaActual);

        if (!nuevoNombre) return;

        try {

            const res = await fetch("mesas.php", {
                method: "POST",
                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },
                body:
                    `action=editar&id=${id}&mesa=${encodeURIComponent(nuevoNombre)}`
            });

            const data = await res.json();

            if (data.success) {
                cargarMesas();
            }

        } catch (error) {

            console.error(error);
        }
    }

    // =========================
    // PRODUCTOS
    // =========================

    async function cargarProductos() {

        try {

            const res =
                await fetch("productos.php?action=listar");

            const texto = await res.text();

            console.log("📥 Respuesta productos:", texto);

            const productos = JSON.parse(texto);

            productosContainer.innerHTML = "";

            if (productos.length === 0) {

                productosContainer.innerHTML =
                    "<p>No hay productos registrados.</p>";

                return;
            }

            productos.forEach(prod => {

                const card = document.createElement("div");

                card.className =
                    "bg-white shadow-md rounded-xl p-4 flex flex-col justify-between";

                card.innerHTML = `
                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        ${prod.Producto}
                    </h3>

                    <p class="text-primary font-semibold mb-3">
                        $${parseFloat(prod.Precio).toFixed(2)}
                    </p>

                    <div class="flex gap-2">

                        <button class="editarBtn text-blue-500 hover:underline">
                            Editar
                        </button>

                        <button class="eliminarBtn text-red-500 hover:underline">
                            Eliminar
                        </button>

                    </div>
                `;

                card.querySelector(".eliminarBtn")
                    .addEventListener("click", () =>
                        eliminarProducto(prod.idProductos)
                    );

                card.querySelector(".editarBtn")
                    .addEventListener("click", () =>
                        editarProducto(
                            prod.idProductos,
                            prod.Producto,
                            prod.Precio
                        )
                    );

                productosContainer.appendChild(card);
            });

        } catch (error) {

            console.error("❌ Error cargando productos:", error);
        }
    }

    document.getElementById("formProducto")
        .addEventListener("submit", async e => {

            e.preventDefault();

            const nombre =
                document.getElementById("productoNombre").value;

            const precio =
                document.getElementById("productoPrecio").value;

            if (!nombre || !precio) return;

            try {

                const res = await fetch("productos.php", {
                    method: "POST",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded"
                    },
                    body:
                        `action=guardar&producto=${encodeURIComponent(nombre)}&precio=${encodeURIComponent(precio)}`
                });

                const data = await res.json();

                if (data.success) {

                    cargarProductos();

                    document.getElementById("productoNombre").value = "";
                    document.getElementById("productoPrecio").value = "";
                }

            } catch (error) {

                console.error(error);
            }
        });

    async function eliminarProducto(id) {

        try {

            const res =
                await fetch(`productos.php?action=eliminar&id=${id}`);

            const data = await res.json();

            if (data.success) {
                cargarProductos();
            }

        } catch (error) {

            console.error(error);
        }
    }

    async function editarProducto(id, nombreActual, precioActual) {

        const nuevoNombre =
            prompt("Editar nombre:", nombreActual);

        const nuevoPrecio =
            prompt("Editar precio:", precioActual);

        if (!nuevoNombre || !nuevoPrecio) return;

        try {

            const res = await fetch("productos.php", {
                method: "POST",
                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },
                body:
                    `action=editar&id=${id}&producto=${encodeURIComponent(nuevoNombre)}&precio=${encodeURIComponent(nuevoPrecio)}`
            });

            const data = await res.json();

            if (data.success) {
                cargarProductos();
            }

        } catch (error) {

            console.error(error);
        }
    }

    // =========================
    // FACTURAS
    // =========================

    async function cargarFacturas() {

        try {

            const res = await fetch("facturas.php");

            const texto = await res.text();

            console.log("📥 Respuesta facturas:", texto);

            const facturas = JSON.parse(texto);

            facturasContainer.innerHTML = "";

            if (facturas.length === 0) {

                facturasContainer.innerHTML =
                    "<p>No hay facturas registradas.</p>";

                return;
            }

            facturas.forEach(f => {

                const div = document.createElement("div");

                div.className =
                    "bg-white shadow-md rounded-xl p-4";

                div.innerHTML = `
                    <p><strong>Orden:</strong> ${f.CodOrden}</p>
                    <p><strong>Cliente:</strong> ${f.idCliente}</p>
                    <p><strong>Mesa:</strong> ${f.idCame}</p>
                    <p><strong>Total:</strong> $${parseFloat(f.Total).toFixed(2)}</p>
                `;

                facturasContainer.appendChild(div);
            });

        } catch (error) {

            console.error("❌ Error cargando facturas:", error);
        }
    }

    logoutBtn.addEventListener("click", () => {

        window.location.href = "logout.php";
    });

    // =========================
    // PARACAÍDAS DE SEGURIDAD (POLLING)
    // =========================
    // Refrescamos los pedidos automáticamente cada 5 segundos
    setInterval(() => {
        if (typeof cargarFacturas === "function") {
            cargarFacturas();
        }
    }, 5000);

});