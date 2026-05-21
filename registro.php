<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro-Came</title>
  <link rel="icon" type="image/png" href="img\logo.ico">
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#d43211",
            "background-light": "#f8f6f6",
            "background-dark": "#221310",
            "foreground-light": "#181211",
            "foreground-dark": "#f8f6f6",
            "input-light": "#ffffff",
            "input-dark": "#2a1815",
            "input-border-light": "#e6dddb",
            "input-border-dark": "#442f2b",
            "placeholder-light": "#896861",
            "placeholder-dark": "#a38e8a"
          },
          fontFamily: {
            "display": ["Epilogue", "sans-serif"]
          },
        },
      },
    };
  </script>

  <link rel="stylesheet" href="css/style.css" />
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-foreground-light dark:text-foreground-dark">
  <div class="flex flex-col min-h-screen">
    <header class="w-full">
      <div class="container mx-auto px-6 py-4 flex items-center gap-3">
        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
          
        </svg>
        <h1 class="text-2xl font-bold">//Cameriere</h1>
      </div>
    </header>

    <main class="flex-grow flex items-center justify-center p-6">
      <div class="w-full max-w-md bg-white dark:bg-background-dark border border-input-border-light dark:border-input-border-dark rounded-xl shadow-lg p-8 space-y-6">

        <!-- REGISTER -->
        <div id="register-section">
          <div class="text-center">
            <h2 class="text-3xl font-bold">Crear Cuenta</h2>
            <p class="mt-2 text-sm text-placeholder-light dark:text-placeholder-dark">
              Regístrate para comenzar.
            </p>
          </div>

          <form id="register-form" class="space-y-5" method="POST" action="php/registro.php">
            <div>
              <label for="reg-username" class="text-sm font-medium">Correo:</label>
              <input id="reg-username" name="username" type="text" placeholder="Coloca tu correo"
                class="form-input w-full px-4 py-3 rounded-lg bg-input-light dark:bg-input-dark border border-input-border-light dark:border-input-border-dark" required />
            </div>

            <div>
              <label for="reg-password" class="text-sm font-medium">Contraseña:</label>
              <input id="reg-password" name="password" type="password" placeholder="Contraseña"
                class="form-input w-full px-4 py-3 rounded-lg bg-input-light dark:bg-input-dark border border-input-border-light dark:border-input-border-dark" required />
            </div>

            <div>
              <label class="text-sm font-medium">Tipo de usuario</label>
              <select id="reg-role" name="role"
                class="form-select w-full px-4 py-3 rounded-lg bg-input-light dark:bg-input-dark border border-input-border-light dark:border-input-border-dark">
                <option value="cliente" selected>Cliente</option>
                <option value="admin">Administrador</option>
              </select>
            </div>

            <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-primary/90 transition-colors duration-300">
              Crear cuenta
            </button>

            <p class="text-sm text-center mt-4">
              ¿Ya tienes cuenta?
              <a href="index.php" class="text-primary hover:underline font-semibold">Inicia sesión</a>
            </p>
          </form>
        </div>

      </div>
    </main>
  </div>
</body>
</html>
