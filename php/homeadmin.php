<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cameriere - Administrador</title>
  <link rel="icon" type="image/png" href="img\logo.ico">
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

  <!-- ✅ estilos -->
  
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
<body class="bg-background font-display text-gray-800">

  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-md flex flex-col">
      <div class="p-4 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-primary mb-3"> Cameriere Admin</h2>
        <nav class="space-y-2">
          <button class="category-btn" data-section="mesas">Mesas</button>
          <button class="category-btn" data-section="productos">Productos</button>
          <button class="category-btn" data-section="facturas">Facturas</button>
        </nav>
      </div>

      <div class="p-4 border-t border-gray-200 mt-auto">
        <button id="logoutBtn" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-amber-600 transition">Cerrar sesión</button>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="flex justify-between items-center p-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold">Panel de Administración</h1>
      </header>

      <div class="flex-1 overflow-y-auto p-6">
        
        <!-- Sección Mesas -->
        <section id="mesasSection" class="hidden">
          <h2 class="text-xl font-bold mb-4">Administrar Mesas</h2>
          <form id="formMesa" class="flex gap-4 mb-6">
            <input type="text" id="mesaNombre" placeholder="Número/Nombre de mesa" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-amber-600">Añadir Mesa</button>
          </form>
          <div id="mesasContainer" class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <!-- Mesas dinámicas -->
          </div>
        </section>

        <!-- Sección Productos -->
        <section id="productosSection" class="hidden">
          <h2 class="text-xl font-bold mb-4">Administrar Productos</h2>
          <form id="formProducto" class="flex gap-4 mb-6">
            <input type="text" id="productoNombre" placeholder="Nombre del producto" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            <input type="number" id="productoPrecio" placeholder="Precio" class="w-32 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-amber-600">Añadir Producto</button>
          </form>
          <div id="productosContainer" class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <!-- Productos dinámicos -->
          </div>
        </section>
        <section id="facturasSection" class="hidden">
          <h2 class="text-xl font-bold mb-4">Facturas</h2>
          <div id="facturasContainer" class="space-y-4">
            <!-- Facturas dinámicas -->
          </div>
        </section>


      </div>
    </main>
  </div>

  <!-- ✅ script para manejar la interfaz -->
  <script src="http://localhost/cameriere/admin.js"></script>
</body>
</html>
