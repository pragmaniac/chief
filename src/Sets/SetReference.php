<?php

declare(strict_types=1);

namespace Thinktomorrow\Chief\Sets;

use Illuminate\Support\Collection;
use Thinktomorrow\Chief\FlatReferences\FlatReference;
use Thinktomorrow\Chief\FlatReferences\ProvidesFlatReference;

class SetReference implements ProvidesFlatReference
{
    /** @var string */
    private $key;

    /** @var string */
    private $action;

    /** @var array */
    private $parameters;

    /** @var string */
    private $label;

    public function __construct(string $key, string $action, array $parameters = [], string $label = null)
    {
        $this->key = $key;
        $this->action = $action;
        $this->parameters = $parameters;
        $this->label = $label;
    }

    public static function fromArray(string $key, array $values): SetReference
    {
        // Constraints
        if (!isset($values['action'])) {
            throw new \InvalidArgumentException('Set reference array is missing required values for the "action" keys. Given: ' . print_r($values, true));
        }

        return new static(
            $key,
            $values['action'],
            $values['parameters'] ?? [],
            $values['label'] ?? null
        );
    }

    public static function all(): Collection
    {
        $sets = config('thinktomorrow.chief.sets', []);

        return collect($sets)->map(function ($set, $key) {
            return SetReference::fromArray($key, $set);
        });
    }

    public static function find($key): ?SetReference
    {
        return static::all()->filter(function ($ref) use ($key) {
            return $ref->key() == $key;
        })->first();
    }

    /**
     * Run the query and collect the resulting items into a GenericSet object.
     *
     * @return Set
     */
    public function toSet(): Set
    {
        // Reconstitute the action - optional @ ->defaults to the name of the set e.g. @upcoming
        list($class, $method) = $this->parseAction($this->action, camel_case($this->key));

        $this->validateAction($class, $method);

        $result = call_user_func_array([app($class),$method], $this->parameters);

        if (! $result instanceof Set && $result instanceof Collection) {
            return new Set($result->all(), $this->key);
        }

        return $result;
    }

    public function store()
    {
        return StoredSetReference::create([
            'key'        => $this->key,
            'action'     => $this->action,
            'parameters' => $this->parameters,
        ]);
    }

    public function key()
    {
        return $this->key;
    }

    private static function parseAction($action, $default_method = '__invoke'): array
    {
        if (false !== strpos($action, '@')) {
            return explode('@', $action);
        }

        return [$action, $default_method];
    }

    private static function validateAction($class, $method)
    {
        if (! class_exists($class)) {
            throw new \InvalidArgumentException('The class ['.$class.'] isn\'t a valid class reference or does not exist in the chief-settings.sets config entry.');
        }

        if (!method_exists($class, $method)) {
            throw new \InvalidArgumentException('The method ['.$method.'] does not exist on the class ['.$class.']. Make sure you provide a valid method to the action value in the chief-settings.sets config entry.');
        }
    }

    public function flatReference(): FlatReference
    {
        return new FlatReference(static::class, $this->key);
    }

    public function flatReferenceLabel(): string
    {
        return $this->label ?? $this->key;
    }

    public function flatReferenceGroup(): string
    {
        return 'set';
    }
}
