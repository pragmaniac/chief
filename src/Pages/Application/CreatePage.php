<?php

namespace Thinktomorrow\Chief\Pages\Application;

use Thinktomorrow\Chief\Pages\Page;
use Thinktomorrow\Chief\Common\Translatable\TranslatableCommand;
use Illuminate\Support\Facades\DB;
use Thinktomorrow\Chief\Pages\PageTranslation;
use Thinktomorrow\Chief\Common\UniqueSlug;

class CreatePage
{
    use TranslatableCommand;

    public function handle(string $collection, array $translations): Page
    {
        try {
            DB::beginTransaction();

            $page = Page::create(['collection' => $collection]);

            foreach($translations as $locale => $value){
                $value = $this->enforceUniqueSlug($value, $page, $locale);
                
                $page->updateTranslation($locale, $value);
            }

            DB::commit();

            return $page->fresh();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param array $translations
     * @param $page
     * @return array
     */
    private function enforceUniqueSlug(array $translation, $page, $locale): array
    {
        $translation['slug']    = $translation['slug'] ?? $translation['title']; 
        $translation['slug']    = UniqueSlug::make(new PageTranslation)->get($translation['slug'], $page->getTranslation($locale));

        return $translation;
    }
}
