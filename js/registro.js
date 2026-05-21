document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("register-form");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
      username: document.getElementById("reg-username").value,
      password: document.getElementById("reg-password").value,
      role: document.getElementById("reg-role").value
    };

    try {
      const response = await fetch("php/registro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });

      const result = await response.json();
      alert(result.message);
    } catch (error) {
      console.error("Error:", error);
      alert("Error al conectar con el servidor.");
    }
  });
});
