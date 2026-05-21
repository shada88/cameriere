<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cameriere - Iniciar Sesión</title>
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

        <!-- LOGIN -->
        <div id="login-section">
          <div class="text-center">
            <h2 class="text-3xl font-bold">Iniciar Sesión</h2>
            <p class="mt-2 text-sm text-placeholder-light dark:text-placeholder-dark">
              Accede a tu cuenta para gestionar los pedidos.
            </p>
          </div>

          <form id="login-form" class="space-y-5" method="POST" action="php/login.php">
            <div>
              <label for="login-username" class="text-sm font-medium">Correo:</label>
              <input id="login-username" name="username" type="text" placeholder="Ingresa tu correo"
                class="form-input w-full px-4 py-3 rounded-lg bg-input-light dark:bg-input-dark border border-input-border-light dark:border-input-border-dark" required />
            </div>

            <div>
              <label for="login-password" class="text-sm font-medium">Contraseña</label>
              <input id="login-password" name="password" type="password" placeholder="Contraseña"
                class="form-input w-full px-4 py-3 rounded-lg bg-input-light dark:bg-input-dark border border-input-border-light dark:border-input-border-dark" required />
            </div>

            <fieldset class="flex gap-4 items-center" style="margin-top: 0.25rem;">
              <legend class="sr-only">Tipo de usuario</legend>
              <label class="text-sm font-medium w-full">Soy:</label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="role" value="cliente" checked class="form-radio" />
                <span class="text-sm">Cliente</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="role" value="admin" class="form-radio" />
                <span class="text-sm">Administrador</span>
              </label>
            </fieldset>

            <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-primary/90 transition-colors duration-300">
              Acceder
            </button>

            <p class="text-sm text-center mt-4">
              ¿No tienes una cuenta?
              <a href="registro.php" class="text-primary hover:underline font-semibold">Regístrate aquí</a>
            </p>
          </form>
        </div>

      </div>
    </main>
  </div>
</body>
</html>
