<?php

declare(strict_types=1);

namespace Thinktomorrow\Chief\Management\Details;

use Illuminate\Contracts\Support\Arrayable;

class Sections implements Arrayable
{
    /** @var array */
    protected $values = [];

    public function get($attribute = null)
    {
        if (array_key_exists($attribute, $this->values)) {
            return $this->values[$attribute];
        }

        return null;
    }

    public function has($attribute): bool
    {
        return null !== $this->get($attribute);
    }

    public function set($attribute, $value)
    {
        $this->values[$attribute] = $value;

        return $this;
    }

    public function __get($attribute)
    {
        return $this->get($attribute);
    }

    public function __set($attribute, $value)
    {
        return $this->set($attribute, $value);
    }

    public function __toString()
    {
        return (string) $this->get('key');
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->values;
    }
}
