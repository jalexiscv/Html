<?php
declare(strict_types=1);

namespace Kint\Renderer\Rich;

use DateTime;
use DateTimeZone;
use Kint\Zval\Representation\Representation;

class TimestampPlugin extends AbstractPlugin implements TabPluginInterface
{
    public function renderTab(Representation $r): ?string
    {
        if ($dt = DateTime::createFromFormat('U', (string)$r->contents)) {
            return '<pre>' . $dt->setTimeZone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s T') . '</pre>';
        }
        return null;
    }
}