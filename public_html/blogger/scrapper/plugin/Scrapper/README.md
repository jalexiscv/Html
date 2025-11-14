# Scrapper (Plugin WordPress)

API mínima para crear publicaciones vía REST sin librerías de terceros. Permite enviar título, contenido, imagen
destacada y categorías.

## Instalación

1. Copia la carpeta `Scrapper` a `wp-content/plugins/Scrapper` de tu instalación WordPress.
2. En el admin de WordPress, ve a Plugins y activa "Scrapper".
3. Tras activar, ve a **Scrapper (menú del WP‑Admin)** para ver el **token** y, si lo deseas, **rotarlo**. El token
   también se guarda como opción `scrapper_api_token`.

Nota: Aquí el código fuente está en `scrapper/plugin/Scrapper/` para desarrollo. Para probar en WordPress, asegúrate de
que exista la misma carpeta en `wp-content/plugins/`.

## Autenticación

- El plugin usa un **token** visible solo para administradores en su página del WP‑Admin.
- Para llamadas desde sistemas externos, envía el header: `X-Scrapper-Token: <TOKEN>`
- Opcionalmente (modo programático, estando logueado como admin), existen endpoints de administración:
    - GET `/wp-json/scrapper/v1/settings/token` (devuelve el token)
    - POST `/wp-json/scrapper/v1/settings/rotate-token` (rota el token)

## Configuración en WP‑Admin

- Menú: **Scrapper** → Verás:
    - **Token actual** en un campo de solo lectura y botón **Copiar** (JS nativo).
    - Botón **Rotar token** (protegido con nonce y confirmación).
- También se muestra el **endpoint REST** listo para usar:
    - `https://tu-sitio.com/wp-json/scrapper/v1/posts`

## Endpoints

- POST `/wp-json/scrapper/v1/posts`
    - Crea una publicación y devuelve `{ id, link, warning? }`.
    - Body JSON:
      ```json
      {
        "title": "Título del post",
        "content": "Contenido HTML o texto",
        "featured_image": "https://sitio/img.jpg" ,
        "categories": ["Noticias", 12, "Tecnología"],
        "status": "publish"
      }
      ```
    - `featured_image` acepta una URL o una cadena base64 (data URI): `data:image/png;base64,AAA...`
    - `categories` puede mezclar IDs numéricos y nombres. Los nombres inexistentes se crean.

## Ejemplos

- Crear post con cURL (Windows PowerShell):
  ```powershell
  $token = "TU_TOKEN"
  $body = @{ title = "Hola"; content = "<p>Contenido</p>"; featured_image = "https://ejemplo.com/imagen.jpg"; categories = @("Noticias", 2) } | ConvertTo-Json
  curl -Method POST -Uri "https://tu-sitio.com/wp-json/scrapper/v1/posts" -Headers @{ "Content-Type" = "application/json"; "X-Scrapper-Token" = $token } -Body $body
  ```

## Estructura

- `scrapper.php`: bootstrap del plugin, registro de rutas y **página de configuración (WP‑Admin)** para token.
- `includes/ApiController.php`: define endpoints REST.
- `includes/PostService.php`: crea publicaciones (`wp_insert_post`).
- `includes/TaxonomyService.php`: resuelve/crea categorías.
- `includes/MediaService.php`: adjunta imagen destacada desde URL o base64.

## Notas

- No usa librerías externas; solo funciones nativas de WordPress.
- Maneja errores con `WP_Error` y respuestas JSON.
- Si la imagen falla, el post se crea y se devuelve `warning`.
- El token es visible y rotable únicamente por administradores desde el WP‑Admin.
