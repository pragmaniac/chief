<?php

namespace Thinktomorrow\Chief\Pages;

use Thinktomorrow\Chief\Concerns\Morphable\GlobalMorphableScope;
use Thinktomorrow\Chief\Concerns\Sluggable\SluggableContract;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model implements SluggableContract
{
    protected $table = 'page_translations';
    public $guarded = [];
    public $timestamps = true;

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function pageWithoutCollectionScope()
    {
        return $this->page()->withoutGlobalScope(GlobalMorphableScope::class);
    }

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}
