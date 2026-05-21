document.addEventListener("DOMContentLoaded", async () => {
  const menuContainer = document.getElementById("menuContainer");
  const cartSidebar = document.getElementById("cartSidebar");
  const cartBtn = document.getElementById("cartBtn");
  const closeCart = document.getElementById("closeCart");
  const cartItems = document.getElementById("cartItems");
  const cartTotal = document.getElementById("cartTotal");
  const cartCount = document.getElementById("cartCount");
  const logoutBtn = document.getElementById("logoutBtn");
  const checkoutBtn = document.getElementById("checkoutBtn");
  const mesaSelect = document.getElementById("mesaSelect");
  const pedidosSection = document.getElementById("pedidosSection");
  const pedidosContainer = document.getElementById("pedidosContainer");

  let carrito = [];

  // ✅ Cargar productos
  async function cargarProductos() {
    const response = await fetch("obtener_productos.php");
    const productos = await response.json();
    menuContainer.innerHTML = "";

    if (productos.length === 0) {
      menuContainer.innerHTML = "<p>No hay productos disponibles.</p>";
      return;
    }

    productos.forEach(prod => {
      const card = document.createElement("div");
      card.className = "bg-white shadow-md rounded-xl p-4 flex flex-col justify-between hover:shadow-lg transition";
      card.innerHTML = `
        <div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">${prod.producto}</h3>
          <p class="text-primary font-semibold mb-3">$${parseFloat(prod.precio).toFixed(2)}</p>
        </div>
        <button class="bg-primary text-white py-2 rounded-lg font-semibold hover:bg-amber-600 transition">
          Agregar al carrito
        </button>
      `;
      card.querySelector("button").addEventListener("click", () => agregarAlCarrito(prod));
      menuContainer.appendChild(card);
    });
  }

  // ✅ Cargar mesas en el selector
  async function cargarMesas() {
    const response = await fetch("mesas.php?action=listar");
    const mesas = await response.json();
    mesaSelect.innerHTML = `<option value="">-- Selecciona una mesa --</option>`;
    mesas.forEach(mesa => {
      const option = document.createElement("option");
      option.value = mesa.idCame;
      option.textContent = `Mesa ${mesa.Mesa}`;
      mesaSelect.appendChild(option);
    });
  }

  // ✅ Agregar productos al carrito
  function agregarAlCarrito(prod) {
    const existente = carrito.find(item => item.idproductos === prod.idproductos);
    if (existente) {
      existente.cantidad++;
    } else {
      carrito.push({ ...prod, cantidad: 1 });
    }
    actualizarCarrito();
  }

  // ✅ Actualizar carrito
  function actualizarCarrito() {
    cartItems.innerHTML = "";
    let total = 0;

    carrito.forEach(item => {
      total += item.precio * item.cantidad;
      const div = document.createElement("div");
      div.className = "flex justify-between items-center border-b border-gray-200 pb-2";
      div.innerHTML = `
        <div>
          <h4 class="font-semibold text-gray-800">${item.producto}</h4>
          <p class="text-sm text-gray-500">Cantidad: ${item.cantidad}</p>
        </div>
        <div class="text-right">
          <p class="text-primary font-semibold">$${(item.precio * item.cantidad).toFixed(2)}</p>
          <button class="text-sm text-red-500 hover:underline mt-1">Eliminar</button>
        </div>
      `;
      div.querySelector("button").addEventListener("click", () => eliminarDelCarrito(item.idproductos));
      cartItems.appendChild(div);
    });

    cartTotal.textContent = `$${total.toFixed(2)}`;
    cartCount.textContent = carrito.length;
  }

  // ✅ Eliminar producto
  function eliminarDelCarrito(id) {
    carrito = carrito.filter(item => item.idproductos !== id);
    actualizarCarrito();
  }

  // ✅ Finalizar pedido
  checkoutBtn.addEventListener("click", async () => {
    if (carrito.length === 0) {
      alert("Tu carrito está vacío.");
      return;
    }

    const idCame = mesaSelect.value;
    if (!idCame) {
      alert("Debes seleccionar una mesa.");
      return;
    }

    const idCliente = document.body.dataset.idcliente || 1; // ⚠️ idCliente desde sesión PHP

    const res = await fetch("guardar_pedido.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        idCliente,
        idCame,
        productos: carrito.map(item => ({
          idProductos: item.idproductos,
          cantidad: item.cantidad
        }))
      })
    });

    const data = await res.json();
    if (data.success) {
      alert("Pedido registrado con éxito. Código: " + data.codOrden);
      carrito = [];
      actualizarCarrito();
      cartSidebar.classList.add("translate-x-full");
      cargarPedidos(); // refrescar pedidos del cliente
    } else {
      alert("Error al guardar pedido: " + data.error);
    }
  });

  // ✅ Mostrar/Ocultar carrito
  cartBtn.addEventListener("click", () => cartSidebar.classList.toggle("translate-x-full"));
  closeCart.addEventListener("click", () => cartSidebar.classList.add("translate-x-full"));

  // ✅ Cargar pedidos del cliente replicando carrito
  async function cargarPedidos() {
    const res = await fetch("pedidos.php");
    const pedidos = await res.json();
    pedidosContainer.innerHTML = "";

    if (pedidos.length === 0) {
      pedidosContainer.innerHTML = "<p>No tienes pedidos registrados.</p>";
      return;
    }

    pedidos.forEach(p => {
      const div = document.createElement("div");
      div.className = "bg-white shadow-md rounded-xl p-4 mb-4";

      let productosHTML = "";
      p.productos.forEach(item => {
        productosHTML += `
          <div class="flex justify-between items-center border-b border-gray-200 pb-2">
            <div>
              <h4 class="font-semibold text-gray-800">${item.Producto}</h4>
              <p class="text-sm text-gray-500">Cantidad: ${item.Cantidad}</p>
            </div>
            <div class="text-right">
              <p class="text-primary font-semibold">$${(item.Precio * item.Cantidad).toFixed(2)}</p>
            </div>
          </div>
        `;
      });

      div.innerHTML = `
        <p class="mb-2"><strong>Orden:</strong> ${p.CodOrden}</p>
        <p class="mb-2"><strong>Mesa:</strong> ${p.idCame}</p>
        ${productosHTML}
        <div class="flex justify-between text-lg font-semibold mt-2">
          <span>Total:</span>
          <span class="text-primary">$${parseFloat(p.Total).toFixed(2)}</span>
        </div>
      `;
      pedidosContainer.appendChild(div);
    });
  }

  // ✅ Sidebar navigation (Menú / Pedidos)
  document.querySelectorAll(".category-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const section = btn.dataset.section;

      // Ocultar secciones
      menuContainer.classList.add("hidden");
      pedidosSection.classList.add("hidden");

      if (section === "menu") {
        menuContainer.classList.remove("hidden");
      } else if (section === "pedidos") {
        pedidosSection.classList.remove("hidden");
        cargarPedidos();
      }
    });
  });

  // ✅ Cerrar sesión
  logoutBtn.addEventListener("click", () => {
    window.location.href = "logout.php";
  });

  // ✅ Inicializar
  cargarProductos();
  cargarMesas();
  cargarPedidos();
});
