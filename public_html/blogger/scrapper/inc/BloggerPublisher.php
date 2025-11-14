<?php

/**
 * Clase para manejar la publicación de contenido en Blogger a través de la API v3.
 *
 * - Gestiona el flujo de autenticación OAuth 2.0 de Google.
 * - Almacena el token de acceso en la sesión.
 * - Obtiene el ID del blog a partir de su URL.
 * - Publica nuevos posts con título y contenido HTML.
 */
class BloggerPublisher
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $blogUrl;
    private $blogId;
    private $accessToken;

    /**
     * Constructor.
     * Carga la configuración desde un array.
     *
     * @param array $config Configuración de la API de Blogger.
     */
    public function __construct(array $config)
    {
        // Cargar credenciales desde el archivo JSON especificado
        $credentialsPath = $config['credentials_json'] ?? '';
        if (file_exists($credentialsPath)) {
            $credentials = json_decode(file_get_contents($credentialsPath), true)['web'] ?? [];
            $this->clientId = $credentials['client_id'] ?? '';
            $this->clientSecret = $credentials['client_secret'] ?? '';
        }

        $this->redirectUri = $config['redirect_uri'] ?? '';
        $this->blogUrl = $config['blog_url'] ?? '';
        $this->accessToken = $_SESSION['blogger_access_token'] ?? null;
    }

    /**
     * Inicia el flujo de autenticación OAuth 2.0.
     * Redirige al usuario a la página de consentimiento de Google.
     */
    public function authenticate()
    {
        $authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
                'client_id' => $this->clientId,
                'redirect_uri' => $this->redirectUri,
                'scope' => 'https://www.googleapis.com/auth/blogger',
                'response_type' => 'code',
                'access_type' => 'offline',
                'prompt' => 'consent'
            ]);

        header('Location: ' . $authUrl);
        exit;
    }

    /**
     * Maneja el callback de la autenticación OAuth 2.0.
     * Intercambia el código de autorización por un token de acceso.
     *
     * @param string $code El código de autorización recibido de Google.
     * @return bool True si se obtuvo el token, false en caso contrario.
     */
    public function handleCallback($code)
    {
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $postData = [
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $tokenData = json_decode($response, true);

        if (isset($tokenData['access_token'])) {
            $this->accessToken = $tokenData['access_token'];
            $_SESSION['blogger_access_token'] = $this->accessToken;
            return true;
        }

        return false;
    }

    /**
     * Publica un nuevo post en el blog.
     *
     * @param string $title El título del post.
     * @param string $content El contenido HTML del post.
     * @return array La respuesta de la API de Blogger.
     */
    public function publishPost($title, $content)
    {
        if (!$this->accessToken) {
            return ['error' => 'No access token available.'];
        }

        $blogId = $this->getBlogId();
        if (!$blogId) {
            return ['error' => 'Could not retrieve Blog ID.'];
        }

        // Hacemos la petición más explícita: es para publicar (no borrador) y debe importar las imágenes.
        $postUrl = "https://www.googleapis.com/blogger/v3/blogs/{$blogId}/posts/?fetchImages=true&isDraft=false";
        $postData = json_encode([
            'kind' => 'blogger#post',
            'title' => $title,
            'content' => $content
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Obtiene el ID del blog a partir de la URL del blog.
     *
     * @return string|null El ID del blog o null si no se encuentra.
     */
    public function getBlogId()
    {
        if ($this->blogId) {
            return $this->blogId;
        }

        if (!$this->accessToken) {
            return null;
        }

        $blogInfoUrl = 'https://www.googleapis.com/blogger/v3/blogs/byurl?url=' . urlencode($this->blogUrl);
        $headers = [
            'Authorization: Bearer ' . $this->accessToken
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $blogInfoUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $blogInfo = json_decode($response, true);

        if (isset($blogInfo['id'])) {
            $this->blogId = $blogInfo['id'];
            return $this->blogId;
        }

        return null;
    }

    /**
     * Verifica si el usuario está autenticado (tiene un token de acceso).
     *
     * @return bool True si está autenticado, false en caso contrario.
     */
    public function isAuthenticated()
    {
        return !empty($this->accessToken);
    }
}
