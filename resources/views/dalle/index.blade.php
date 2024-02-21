<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DALL-E Image Generator</title>
</head>
<body>
    <h1>DALL-E Image Generator</h1>
    
    <form action="{{ route('dalle.generate') }}" method="post" id="generateForm" enctype="multipart/form-data">
        @csrf
        <label for="prompt">Texto de entrada:</label><br>
        <textarea name="prompt" id="prompt" rows="4" cols="50"></textarea><br><br>
        <button type="submit">Generar Imagen</button>
    </form>

    <div id="imageContainer">
        <!-- Aquí se mostrará la imagen generada -->
    </div>
    
    <script>
        // Manejar la respuesta de la solicitud AJAX
        document.querySelector('#generateForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que se envíe el formulario de forma predeterminada

            // Obtener el token CSRF
            var csrfToken = document.querySelector('input[name="_token"]').value;

            // Realizar una solicitud AJAX para generar la imagen
            fetch(this.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Agregar el token CSRF como encabezado personalizado
                },
                body: JSON.stringify({
                    _token: csrfToken, // También incluir el token CSRF en el cuerpo de la solicitud
                    prompt: document.getElementById('prompt').value
                })
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar la imagen generada en el contenedor de imágenes
                var imageContainer = document.getElementById('imageContainer');
                imageContainer.innerHTML = `<img src="${data}" alt="Generated Image">`;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
