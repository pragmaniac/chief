<?php

namespace Thinktomorrow\Chief\Pages;

use Illuminate\Support\Collection;
use Thinktomorrow\Chief\Common\Collections\HasCollection;
use Thinktomorrow\Chief\Common\Relations\ActingAsChild;
use Thinktomorrow\Chief\Common\Relations\ActingAsParent;
use Thinktomorrow\Chief\Common\Relations\ActsAsChild;
use Thinktomorrow\Chief\Common\Relations\ActsAsParent;
use Thinktomorrow\Chief\Common\Relations\Relation;
use Thinktomorrow\Chief\Common\Translatable\Translatable;
use Thinktomorrow\Chief\Common\Translatable\TranslatableContract;
use Dimsav\Translatable\Translatable as BaseTranslatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Thinktomorrow\AssetLibrary\Traits\AssetTrait;
use Thinktomorrow\Chief\Common\Traits\Featurable;
use Thinktomorrow\Chief\Common\Traits\Archivable\Archivable;
use Thinktomorrow\Chief\Common\TranslatableFields\HtmlField;
use Thinktomorrow\Chief\Common\TranslatableFields\InputField;
use Thinktomorrow\Chief\Media\MediaType;
use Thinktomorrow\Chief\Menu\ActsAsMenuItem;
use Thinktomorrow\Chief\Common\Publish\Publishable;

class Page extends Model implements TranslatableContract, HasMedia, ActsAsParent, ActsAsChild, ActsAsMenuItem
{
    use HasCollection,
        AssetTrait,
        Translatable,
        BaseTranslatable,
        SoftDeletes,
        Publishable,
        Featurable,
        Archivable,
        ActingAsParent,
        ActingAsChild;

    // Explicitly mention the translation model so on inheritance the child class uses the proper default translation model
    protected $translationModel = PageTranslation::class;
    protected $translationForeignKey = 'page_id';
    protected $translatedAttributes = [
        'slug', 'title', 'content', 'short', 'seo_title', 'seo_description',
    ];

    public $table = "pages";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $with = ['translations'];

    /**
     * The collection scope for the specific class.
     * @var string
     */
    protected static $collectionScopeClass = PageCollectionScope::class;

    /**
     * Each page model can expose the managed translatable fields. These should be included as attributes just like the regular
     * translatable attributes. This method allows for easy installation of the form fields in chief.
     *
     * @param null $key
     * @return array
     */
    final public static function translatableFields($key = null)
    {
        $translatableFields = array_merge(static::defaultTranslatableFields(), static::customTranslatableFields());

        return $key ? array_pluck($translatableFields, $key) : $translatableFields;
    }

    /**
     * The custom addition of fields for a page model.
     *
     * To add a field, you should:
     * 1. override this method with your own and return the comprised list of fields.
     * 2. Setup the proper migrations and add the new field to the translatable values of the collection.
     *
     * @return array
     */
    public static function customTranslatableFields(): array
    {
        return [];
    }

    /**
     * The default set of fields for a page model.
     *
     * If you wish to remove any of these fields, you should:
     * 1. override this method with your own and return the comprised list of fields.
     * 2. Provide a migration to remove the column from database and remove the fields from the translatable values of the model.
     *
     * Note that the following translated fields are always present and cannot be removed:
     * - title
     * - slug
     * - seo_title
     * - seo_description
     *
     * @return array
     */
    public static function defaultTranslatableFields(): array
    {
        return [
            'title' => InputField::make()->label('titel'),
            'short' => HtmlField::make()->label('Korte samenvatting')->description('Wordt gebruikt voor overzichtspagina\'s.'),
            'content' => HtmlField::make()->label('Inhoud'),
        ];
    }

    /**
     * Details of the collection such as naming, key and class.
     * Used in several dynamic parts of the admin application.
     *
     * @param null $key
     * @return object
     */
    public static function collectionDetails($key = null)
    {
        $collectionKey = (new static)->collectionKey();

        $names = (object) [
            'key'      => $collectionKey,
            'class'    => static::class,
            'singular' => $collectionKey == 'statics' ? 'pagina' : ucfirst(str_singular($collectionKey)),
            'plural'   => $collectionKey == 'statics' ? 'pagina\'s' : ucfirst(str_plural($collectionKey)),
        ];

        return $key ? $names->$key : $names;
    }

    /**
     * TODO: these flatten and inflate methods should be out of this class into their own environment...
     * They are also used for the relation select fields.
     * @return mixed
     */
    public static function flattenForSelect()
    {
        return self::ignoreCollection()->get()->map(function (Page $page) {
            return [
                'id'    => $page->getRelationId(),
                'label' => $page->getRelationLabel(),
                'group' => $page->getRelationGroup(),
            ];
        });
    }

    public static function flattenForGroupedSelect(): Collection
    {
        $grouped = [];

        self::flattenForSelect()->each(function ($entry) use (&$grouped) {
            if (isset($grouped[$entry['group']])) {
                $grouped[$entry['group']]['values'][] = $entry;
            } else {
                $grouped[$entry['group']] = ['group' => $entry['group'], 'values' => [$entry]];
            }
        });

        // We remove the group key as we need to have non-assoc array for the multiselect options.
        return collect(array_values($grouped));
    }

    public static function inflate($relateds = [])
    {
        if (!is_array($relateds)) {
            $relateds = [$relateds];
        }

        if (count($relateds) == 1 && is_null(reset($relateds))) {
            $relateds = [];
        }

        return collect($relateds)->map(function ($related) {
            list($type, $id) = explode('@', $related);
            
            return (new $type)->ignoreCollection()->find($id);
        })->first();
    }

    public function mediaUrls($type = null): Collection
    {
        return $this->getAllFiles($type)->map->getFileUrl();
    }

    public function mediaUrl($type = null): ?string
    {
        return $this->mediaUrls($type)->first();
    }

    public static function mediaFields($key = null)
    {
        $types = [
            MediaType::HERO => [
                'type' => MediaType::HERO,
                'label' => 'Hoofdafbeelding',
                'description' => '',
            ],
            MediaType::THUMB => [
                'type' => MediaType::THUMB,
                'label' => 'Thumbnails',
                'description' => '',
            ],
        ];

        return $key ? array_pluck($types, $key) : $types;
    }

    /**
     * Set a custom morph class for the morph relations because we
     * mostly want the Page as morph relationship instead of the
     * child class.
     */
//    public function getMorphClass()
//    {
//        return self::class;
//    }

//    public function getOwnMorphClass()
//    {
//        return parent::getMorphClass();
//    }

    public static function findPublished($id)
    {
        return (($page = self::ignoreCollection()->published()->find($id)))
            ? $page
            : null;
    }

    public static function findBySlug($slug)
    {
        return ($trans = PageTranslation::findBySlug($slug)) ? self::ignoreCollection()->find($trans->page_id) : null;
    }

    public static function findPublishedBySlug($slug)
    {
        return ($trans = PageTranslation::findBySlug($slug)) ? self::findPublished($trans->page_id) : null;
    }

    public function scopeSortedByCreated($query)
    {
        $query->orderBy('created_at', 'DESC');
    }

    public function presentForParent(ActsAsParent $parent, Relation $relation): string
    {
        return 'Dit is de relatie weergave van een pagina onder ' . $parent->id;
    }

    public function presentForChild(ActsAsChild $child, Relation $relation): string
    {
        return 'Dit is de relatie weergave van een pagina als parent voor ' . $child->id;
    }

    public function getRelationId(): string
    {
        return $this->getMorphClass().'@'.$this->id;
    }

    public function getRelationLabel(): string
    {
        return $this->title ?? '';
    }

    public function getRelationGroup(): string
    {
        return static::collectionDetails('plural');
    }

    public function previewUrl()
    {
        // TODO: how we allow for these default routes to be set up in every new project?
//        return '';
        return route('pages.show', $this->slug).'?preview-mode';
    }

    public function menuUrl(): string
    {
        // TODO: how we allow for these default routes to be set up in every new project?
//        return '';
        return route('pages.show', $this->slug);
    }

    public function menuLabel(): string
    {
        return $this->title;
    }
}
