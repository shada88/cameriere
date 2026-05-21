document.addEventListener("DOMContentLoaded", () => {
  const menuContainer = document.getElementById("menuContainer");
  const cartSidebar = document.getElementById("cartSidebar");
  const cartBtn = document.getElementById("cartBtn");
  const closeCart = document.getElementById("closeCart");
  const cartItems = document.getElementById("cartItems");
  const cartTotal = document.getElementById("cartTotal");
  const cartCount = document.getElementById("cartCount");
  const checkoutBtn = document.getElementById("checkoutBtn");

  let carrito = [];

  // Mostrar/Ocultar carrito
  cartBtn.addEventListener("click", () => cartSidebar.classList.remove("translate-x-full"));
  closeCart.addEventListener("click", () => cartSidebar.classList.add("translate-x-full"));

  // Cargar productos desde la base de datos
  async function cargarProductos() {
    try {
      const res = await fetch("php/obtener_productos.php");
      const productos = await res.json();
      mostrarProductos(productos);
    } catch (error) {
      menuContainer.innerHTML = `<p class="text-red-500">Error al cargar productos</p>`;
      console.error(error);
    }
  }

  function mostrarProductos(productos) {
    menuContainer.innerHTML = "";
    productos.forEach(p => {
      const card = document.createElement("div");
      card.className = "bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition";
      card.innerHTML = `
        <div class="p-4">
          <h3 class="font-bold text-lg">${p.producto}</h3>
          <p class="font-semibold text-primary mb-3">$${p.precio}</p>
          <button data-id="${p.idproductos}" data-nombre="${p.producto}" data-precio="${p.precio}"
            class="w-full bg-primary text-white py-2 rounded-lg hover:bg-amber-600 transition">
            Agregar al carrito
          </button>
        </div>
      `;
      menuContainer.appendChild(card);
    });

    document.querySelectorAll("[data-id]").forEach(btn => {
      btn.addEventListener("click", () => agregarAlCarrito(btn.dataset));
    });
  }

  function agregarAlCarrito(prod) {
    const existente = carrito.find(p => p.idproductos === prod.id);
    if (existente) {
      existente.cantidad++;
      existente.subtotal = existente.cantidad * existente.precio;
    } else {
      carrito.push({
        idproductos: parseInt(prod.id),
        producto: prod.nombre,
        precio: parseFloat(prod.precio),
        cantidad: 1,
        subtotal: parseFloat(prod.precio)
      });
    }
    actualizarCarrito();
  }

  function actualizarCarrito() {
    cartItems.innerHTML = "";
    let total = 0;
    carrito.forEach((item, i) => {
      total += item.subtotal;
      const div = document.createElement("div");
      div.className = "flex justify-between items-center border-b pb-2 mb-2";
      div.innerHTML = `
        <div>
          <h4 class="font-semibold">${item.producto}</h4>
          <p class="text-sm text-gray-600">x${item.cantidad} - $${item.subtotal}</p>
        </div>
        <button data-i="${i}" class="text-red-500 font-bold">&times;</button>
      `;
      div.querySelector("button").addEventListener("click", () => eliminarDelCarrito(i));
      cartItems.appendChild(div);
    });
    cartTotal.textContent = `$${total.toFixed(2)}`;
    cartCount.textContent = carrito.length;
  }

  function eliminarDelCarrito(i) {
    carrito.splice(i, 1);
    actualizarCarrito();
  }

  checkoutBtn.addEventListener("click", async () => {
    if (carrito.length === 0) {
      alert("El carrito está vacío.");
      return;
    }

    const total = carrito.reduce((a, i) => a + i.subtotal, 0);
    const data = {
      idCliente: 1, // Temporal hasta implementar login
      productos: carrito,
      total
    };

    try {
      const res = await fetch("php/guardar_pedido.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });
      const r = await res.json();
      alert(r.message);
      if (r.success) {
        carrito = [];
        actualizarCarrito();
        cartSidebar.classList.add("translate-x-full");
      }
    } catch (e) {
      alert("Error al enviar pedido.");
      console.error(e);
    }
  });

  cargarProductos();
});
