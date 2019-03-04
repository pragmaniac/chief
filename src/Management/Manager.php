<?php

namespace Thinktomorrow\Chief\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Thinktomorrow\Chief\Fields\Fields;
use Thinktomorrow\Chief\Fields\Types\Field;
use Thinktomorrow\Chief\Fields\FieldArrangement;
use Thinktomorrow\Chief\Management\Details\Details;

interface Manager
{
    /**
     * Set the specific model to be managed.
     *
     * Either give a specific model to manage or if no parameter passed,
     * we will assume a generic model instance instead for e.g. create and store.
     *
     * @param $model
     * @return Manager
     */
    public function manage($model): Manager;

    public function isAssistedBy(string $assistant): bool;

    public function assistant(string $assistant): Assistant;

    /**
     * Find an instance by id wrapped in a Manager
     *
     * @param $id
     * @return Manager
     */
    public function findManaged($id): Manager;

    /**
     * Get all managed models wrapped in a Manager
     * E.g. used for the index.
     *
     * @return Collection of ManagedModel
     */
    public function findAllManaged(): Collection;

    /**
     * Retrieve the managed model instance
     * @return mixed
     */
    public function model();

    public function route($verb): ?string;

    public function can($verb): bool;

    /**
     * @param $verb
     * @throws NotAllowedManagerRoute
     */
    public function guard($verb);

    /**
     * The set of fields that should be manageable for a certain model.
     *
     * Additionally, you should:
     * 1. Make sure to setup the proper migrations and
     * 2. For a translatable field you should add this field to the $translatedAttributes property of the model as well.
     *
     * @return Fields
     */
    public function fields(): Fields;

    /**
     * This determines the arrangement of the manageable fields
     * on the create and edit forms. By default, all fields
     * are presented in their order of appearance
     *
     * @param null $key pinpoint to a specific field arrangement e.g. for create page.
     * @return FieldArrangement
     */
    public function fieldArrangement($key = null): FieldArrangement;

    /**
     * @param Field|string $field
     * @return mixed
     */
    public function getFieldValue($field);

    public function setField(Field $field, Request $request);

    public function saveFields(): Manager;

    public function renderField(Field $field);

    /**
     * Action to execute deletion of the model.
     * @return mixed
     */
    public function delete();

    /**
     * This method can be used to manipulate the store request payload
     * before being passed to the storing / updating the models.
     *
     * @param Request $request
     * @return Request
     */
    public function storeRequest(Request $request): Request;

    /**
     * This method can be used to manipulate the update request payload
     * before being passed to the storing / updating the models.
     *
     * @param Request $request
     * @return Request
     */
    public function updateRequest(Request $request): Request;

    /**
     * Information regarding a specific managed model instance.
     *
     * @return Details
     */
    public function details(): Details;

    /**
     * Information for display on the managers index page.
     *
     * @return Details
     */
    public function indexDetails(): Details;
}
