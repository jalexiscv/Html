<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Libraries\Mailer;

/**
 * Configure Mailer with DSN string.
 *
 * @see https://en.wikipedia.org/wiki/Data_source_name
 *
 * @author Oleg Voronkovich <oleg-voronkovich@yandex.ru>
 */
class DSNConfigurator
{
    /**
     * Create new Mailer instance configured by DSN.
     *
     * @param string $dsn DSN
     * @param bool $exceptions Should we throw external exceptions?
     *
     * @return Mailer
     */
    public static function mailer($dsn, $exceptions = null)
    {
        static $configurator = null;

        if (null === $configurator) {
            $configurator = new DSNConfigurator();
        }

        return $configurator->configure(new Mailer($exceptions), $dsn);
    }

    /**
     * Configure Mailer instance with DSN string.
     *
     * @param Mailer $mailer Mailer instance
     * @param string $dsn DSN
     *
     * @return Mailer
     */
    public function configure(Mailer $mailer, $dsn)
    {
        $config = $this->parseDSN($dsn);

        $this->applyConfig($mailer, $config);

        return $mailer;
    }

    /**
     * Parse DSN string.
     *
     * @param string $dsn DSN
     *
     * @return array Configuration
     * @throws Exception If DSN is malformed
     *
     */
    private function parseDSN($dsn)
    {
        $config = $this->parseUrl($dsn);

        if (false === $config || !isset($config['scheme']) || !isset($config['host'])) {
            throw new \Exception('Malformed DSN');
        }

        if (isset($config['query'])) {
            parse_str($config['query'], $config['query']);
        }

        return $config;
    }

    /**
     * Parse a URL.
     * Wrapper for the built-in parse_url function to work around a bug in PHP 5.5.
     *
     * @param string $url URL
     *
     * @return array|false
     */
    protected function parseUrl($url)
    {
        if (\PHP_VERSION_ID >= 50600 || false === strpos($url, '?')) {
            return parse_url($url);
        }

        $chunks = explode('?', $url);
        if (is_array($chunks)) {
            $result = parse_url($chunks[0]);
            if (is_array($result)) {
                $result['query'] = $chunks[1];
            }
            return $result;
        }

        return false;
    }

    /**
     * Apply configuration to mailer.
     *
     * @param Mailer $mailer Mailer instance
     * @param array $config Configuration
     *
     * @throws Exception If scheme is invalid
     */
    private function applyConfig(Mailer $mailer, $config)
    {
        switch ($config['scheme']) {
            case 'mail':
                $mailer->isMail();
                break;
            case 'sendmail':
                $mailer->isSendmail();
                break;
            case 'qmail':
                $mailer->isQmail();
                break;
            case 'smtp':
            case 'smtps':
                $mailer->isSMTP();
                $this->configureSMTP($mailer, $config);
                break;
            default:
                throw new \Exception(
                    sprintf(
                        'Invalid scheme: "%s". Allowed values: "mail", "sendmail", "qmail", "smtp", "smtps".',
                        $config['scheme']
                    )
                );
        }

        if (isset($config['query'])) {
            $this->configureOptions($mailer, $config['query']);
        }
    }

    /**
     * Configure SMTP.
     *
     * @param Mailer $mailer Mailer instance
     * @param array $config Configuration
     */
    private function configureSMTP($mailer, $config)
    {
        $isSMTPS = 'smtps' === $config['scheme'];

        if ($isSMTPS) {
            $mailer->SMTPSecure = Mailer::ENCRYPTION_STARTTLS;
        }

        $mailer->Host = $config['host'];

        if (isset($config['port'])) {
            $mailer->Port = $config['port'];
        } elseif ($isSMTPS) {
            $mailer->Port = SMTP::DEFAULT_SECURE_PORT;
        }

        $mailer->SMTPAuth = isset($config['user']) || isset($config['pass']);

        if (isset($config['user'])) {
            $mailer->Username = $config['user'];
        }

        if (isset($config['pass'])) {
            $mailer->Password = $config['pass'];
        }
    }

    /**
     * Configure options.
     *
     * @param Mailer $mailer Mailer instance
     * @param array $options Options
     *
     * @throws Exception If option is unknown
     */
    private function configureOptions(Mailer $mailer, $options)
    {
        $allowedOptions = get_object_vars($mailer);

        unset($allowedOptions['Mailer']);
        unset($allowedOptions['SMTPAuth']);
        unset($allowedOptions['Username']);
        unset($allowedOptions['Password']);
        unset($allowedOptions['Hostname']);
        unset($allowedOptions['Port']);
        unset($allowedOptions['ErrorInfo']);

        $allowedOptions = \array_keys($allowedOptions);

        foreach ($options as $key => $value) {
            if (!in_array($key, $allowedOptions)) {
                throw new \Exception(
                    sprintf(
                        'Unknown option: "%s". Allowed values: "%s"',
                        $key,
                        implode('", "', $allowedOptions)
                    )
                );
            }

            switch ($key) {
                case 'AllowEmpty':
                case 'SMTPAutoTLS':
                case 'SMTPKeepAlive':
                case 'SingleTo':
                case 'UseSendmailOptions':
                case 'do_verp':
                case 'DKIM_copyHeaderFields':
                    $mailer->$key = (bool)$value;
                    break;
                case 'Priority':
                case 'SMTPDebug':
                case 'WordWrap':
                    $mailer->$key = (int)$value;
                    break;
                default:
                    $mailer->$key = $value;
                    break;
            }
        }
    }
}
