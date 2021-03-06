<?php

namespace Thinktomorrow\Chief\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Thinktomorrow\Chief\Pages\Page;
use Thinktomorrow\Chief\Modules\Module;
use Thinktomorrow\Chief\Sets\SetReference;
use Thinktomorrow\Chief\Sets\StoredSetReference;

class Relation extends Model
{
    public $timestamps = false;
    public $guarded = [];

    /**
     * Set the keys for a save update query.
     * We override the default save setup since we do not have a primary key in relation table.
     * There should however always be the parent and child references so we can use
     * those to target the record in database.
     *
     * @param Builder $query
     * @return Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('parent_type', $this->getMorphClass())
                ->where('parent_id', $this->getKey())
                ->where('child_type', $this->child_type)
                ->where('child_id', $this->child_id);

        return $query;
    }

    public function parent()
    {
        return $this->morphTo('parent', 'parent_type', 'parent_id');
    }

    public function child()
    {
        return $this->morphTo('child', 'child_type', 'child_id');
    }

    public static function parents($child_type, $child_id)
    {
        $relations = static::where('child_type', $child_type)
            ->where('child_id', $child_id)
            ->orderBy('sort', 'ASC')
            ->get();

        return $relations->map(function (Relation $relation) {
            $parent = $relation->parent;
            $parent->relation = $relation;
            return $parent;
        });
    }

    public static function children($parent_type, $parent_id)
    {
        $relations = static::where('parent_type', $parent_type)
                            ->where('parent_id', $parent_id)
                            ->orderBy('sort', 'ASC')
                            ->get();

        return $relations->map(function (Relation $relation) use ($parent_type, $parent_id) {

            // It could be that the child itself is soft-deleted, if this is the case, we will ignore it and move on.
            if (!$child = $relation->child) {
                if (!$relation->child()->withTrashed()->first()) {
//                if ((!method_exists($childInstance, 'trashed')) || ! $childInstance->onlyTrashed()->find($relation->child_id)) {
                    // If we cannot retrieve it then he collection type is possibly off, this is a database inconsistency and should be addressed
                    throw new \DomainException('Corrupt relation reference. Related child ['.$relation->child_type.'@'.$relation->child_id.'] could not be retrieved for parent [' . $parent_type.'@'.$parent_id.']. Make sure the morph key can resolve to a valid class.');
                }

                return null;
            }

            $child->relation = $relation;

            return $child;
        })

        // In case of soft-deleted entries, this will be null and should be ignored. We make sure that keys are reset in case of removed child
        ->reject(function ($child) {
            return is_null($child);
        })
        ->values();
    }

    public function delete()
    {
        return static::where('parent_type', $this->parent_type)
                ->where('parent_id', $this->parent_id)
                ->where('child_type', $this->child_type)
                ->where('child_id', $this->child_id)
                ->delete();
    }

    public static function deleteRelationsOf($type, $id)
    {
        $relations = static::where(function ($query) use ($type, $id) {
            return $query->where('parent_type', $type)
                         ->where('parent_id', $id);
        })->orWhere(function ($query) use ($type, $id) {
            return $query->where('child_type', $type)
                ->where('child_id', $id);
        })->get();

        foreach ($relations as $relation) {
            $relation->delete();
        }
    }
}
