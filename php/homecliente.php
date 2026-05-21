<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cameriere - Cliente</title>
  <link rel="icon" type="image/png" href="img\logo.ico">
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

  <!-- ✅ Solo existe style.css, y subimos un nivel -->
  <link rel="stylesheet" href="../css/style.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#d97706',
            background: '#f8f6f6'
          },
          fontFamily: {
            display: ['Epilogue', 'sans-serif']
          }
        }
      }
    }
  </script>
</head>
<body class="bg-background font-display text-gray-800" 
      data-idcliente="<?php echo $_SESSION['idCliente'] ?? ''; ?>">

  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-md flex flex-col">
      <div class="p-4 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-primary mb-3"> Cameriere</h2>
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3 top-2.5 text-primary">search</span>
          <input type="text" id="searchInput" placeholder="Buscar..." class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
      </div>

      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <!-- ✅ Botón Menú -->
        <button class="category-btn" data-section="menu">Menú</button>
        <!-- ✅ Botón Tus Pedidos -->
        <button class="category-btn" data-section="pedidos">Tus Pedidos</button>
      </nav>

      <div class="p-4 border-t border-gray-200">
        <button id="logoutBtn" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-amber-600 transition">Cerrar sesión</button>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="flex justify-between items-center p-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold">Menú del Restaurante</h1>
        <button id="cartBtn" class="relative p-2 rounded-full hover:bg-primary/10 transition">
          <span class="material-symbols-outlined text-primary text-3xl">shopping_cart</span>
          <span id="cartCount" class="absolute -top-1 -right-1 bg-primary text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
        </button>
      </header>

      <div class="flex flex-1 overflow-hidden">
        <!-- Productos -->
        <section id="menuContainer" class="flex-1 p-6 grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 overflow-y-auto">
          <!-- Productos dinámicos -->
        </section>

        <!-- Tus Pedidos -->
        <section id="pedidosSection" class="hidden p-6">
          <h2 class="text-xl font-bold mb-4">Tus Pedidos</h2>
          <div id="pedidosContainer" class="space-y-4">
            <!-- Pedidos dinámicos -->
          </div>
        </section>

        <!-- Carrito -->
        <aside id="cartSidebar" class="w-96 bg-white border-l border-gray-200 shadow-xl transform translate-x-full transition-transform duration-300 fixed right-0 top-0 h-full p-6 flex flex-col">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Tu Pedido</h2>
            <button id="closeCart" class="text-primary text-2xl">&times;</button>
          </div>
          <div id="cartItems" class="flex-1 overflow-y-auto space-y-4"></div>
          
          <!-- ✅ Selector de mesa -->
          <div class="border-t border-gray-200 pt-4 mt-4">
            <label for="mesaSelect" class="block text-sm font-semibold mb-2">Selecciona tu mesa:</label>
            <select id="mesaSelect" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary mb-4">
              <option value="">-- Selecciona una mesa --</option>
              <!-- Opciones dinámicas cargadas desde la BD -->
            </select>

            <div class="flex justify-between text-lg font-semibold">
              <span>Total:</span>
              <span id="cartTotal" class="text-primary">$0</span>
            </div>
            <button id="checkoutBtn" class="w-full mt-4 bg-primary text-white py-3 rounded-lg font-bold hover:bg-amber-600 transition">
              Finalizar Pedido
            </button>
          </div>
        </aside>
      </div>
      
    </main>
  </div>

  <!-- ✅ Subimos un nivel para llegar a js/menu.js -->
  <script src="../js/menu.js"></script>
</body>
</html>
