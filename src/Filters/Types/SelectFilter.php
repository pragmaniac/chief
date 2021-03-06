<?php
declare(strict_types=1);

namespace Thinktomorrow\Chief\Filters\Types;

use Closure;
use Thinktomorrow\Chief\Filters\Filter;

class SelectFilter extends Filter
{
    public static function make(string $key)
    {
        return new static(new FilterType(FilterType::SELECT), $key);
    }

    public function apply($value = null): Closure
    {
        return $this->query && $this->query instanceof Closure ? $this->query : function ($query) {
            return $query;
        };
    }

    public function options(array $values)
    {
        $this->values['options'] = $values;

        return $this;
    }

    public function selected($values)
    {
        $this->values['selected'] = $values;

        return $this;
    }

    public function multiple($value)
    {
        $this->values['multiple'] = $value;

        return $this;
    }
}
