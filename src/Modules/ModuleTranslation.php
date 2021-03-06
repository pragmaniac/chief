<?php

namespace Thinktomorrow\Chief\Modules;

use Illuminate\Database\Eloquent\Model;

class ModuleTranslation extends Model
{
    public $guarded = [];
    public $timestamps = true;
    protected $table = 'module_translations';

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
