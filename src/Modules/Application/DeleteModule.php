<?php
namespace Thinktomorrow\Chief\Modules\Application;

use Illuminate\Support\Facades\DB;
use Thinktomorrow\Chief\Relations\Relation;
use Thinktomorrow\Chief\Modules\Module;
use Thinktomorrow\Chief\Concerns\Translatable\TranslatableCommand;

class DeleteModule
{
    use TranslatableCommand;

    public function handle($id)
    {
        try {
            DB::beginTransaction();

            $module = Module::findOrFail($id);

            Relation::deleteRelationsOf($module->getMorphClass(), $module->id);

            $module->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
