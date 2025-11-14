<?php

namespace App\Filters;

use Higgs\Filters\FilterInterface;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;

class SingleTabFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Obtener la ruta actual para identificar la página
        $currentRoute = $request->getUri()->getPath();
        $pageKey = 'page_open_' . md5($currentRoute);
        $tokenKey = $pageKey . '_token';
        $timeKey = $pageKey . '_time';

        // Obtener el token de la URL
        $currentToken = $request->getGet('tab_token');

        // Si no hay token, generar uno nuevo
        if (!$currentToken) {
            $token = bin2hex(random_bytes(16));
            $session->set($tokenKey, $token);
            $session->set($timeKey, time());

            // Redirigir con el token
            $newUrl = current_url() . '?tab_token=' . $token;
            if ($request->getGet()) {
                $params = $request->getGet();
                unset($params['tab_token']);
                if (!empty($params)) {
                    $newUrl .= '&' . http_build_query($params);
                }
            }
            return redirect()->to($newUrl);
        }

        // Verificar si el token es válido
        $storedToken = $session->get($tokenKey);
        $lastActivity = $session->get($timeKey);

        // Timeout de 30 segundos sin actividad (pestaña cerrada)
        $timeout = 30;
        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            // Token expirado, permitir nueva pestaña
            $session->set($tokenKey, $currentToken);
            $session->set($timeKey, time());
            return;
        }

        // Si el token no coincide, bloquear
        if ($storedToken && $storedToken !== $currentToken) {
            return view('errors/duplicate_tab');
        }

        // Actualizar el timestamp
        $session->set($timeKey, time());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita hacer nada después
    }
}

?>