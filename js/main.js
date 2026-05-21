document.addEventListener("DOMContentLoaded", () => {
  const contenedorMenu = document.getElementById("menu");

  fetch("php/obtener_productos.php")
    .then(response => {
      if (!response.ok) throw new Error("Error en la respuesta del servidor");
      return response.json();
    })
    .then(data => {
      if (data.error) {
        contenedorMenu.innerHTML = `<p>Error: ${data.error}</p>`;
        return;
      }

      contenedorMenu.innerHTML = ""; // Limpia el contenedor

      data.forEach(item => {
        const card = document.createElement("div");
        card.classList.add("card");

        card.innerHTML = `
          <h3>${item.producto}</h3>
          <p>Precio: $${item.precio}</p>
        `;

        contenedorMenu.appendChild(card);
      });
    })
    .catch(error => {
      console.error("Error al cargar los productos:", error);
      contenedorMenu.innerHTML = `<p>Error al cargar el menú.</p>`;
    });
});
