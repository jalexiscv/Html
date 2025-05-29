<?php

namespace App\Modules\Maintenance\Models;

use App\Modules\Storage\Models\Storage_Attachments;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $massets, esta deberá ser igualada a  model('App\Modules\Maintenance\Models\Maintenance_Assets');
 * @Instruction $massets = model('App\Modules\Maintenance\Models\Maintenance_Assets');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Maintenance_Attachments extends Storage_Attachments
{

}

?>