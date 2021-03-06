<?php

namespace Thinktomorrow\Chief\Tests\Feature\Management;

use Thinktomorrow\Chief\Fields\FieldArrangement;
use Thinktomorrow\Chief\Fields\Fields;
use Thinktomorrow\Chief\Fields\FieldsTab;
use Thinktomorrow\Chief\Fields\RemainingFieldsTab;
use Thinktomorrow\Chief\Fields\Types\Field;
use Thinktomorrow\Chief\Fields\Types\InputField;
use Thinktomorrow\Chief\Management\Register;
use Thinktomorrow\Chief\Tests\Feature\Management\Fakes\ManagedModelFake;
use Thinktomorrow\Chief\Tests\Feature\Management\Fakes\ManagedModelFakeTranslation;
use Thinktomorrow\Chief\Tests\Feature\Management\Fakes\ManagerFake;
use Thinktomorrow\Chief\Tests\Feature\Management\Fakes\ManagerFakeWithFieldTabs;
use Thinktomorrow\Chief\Tests\TestCase;

class FieldArrangementTest extends TestCase
{
    private $manager;
    private $model;

    protected function setUp(): void
    {
        parent::setUp();

        ManagedModelFake::migrateUp();
        ManagedModelFakeTranslation::migrateUp();

        $this->setUpDefaultAuthorization();

        app(Register::class)->register('fakes', ManagerFake::class, ManagedModelFake::class);

        $this->model = ManagedModelFake::create(['title' => 'Foobar', 'custom_column' => 'custom']);
        $this->manager = (new ManagerFake(app(Register::class)->first()))->manage($this->model);
    }

    /** @test */
    public function a_tab_can_be_added()
    {
        $arrangement = new FieldArrangement(new Fields([]), [new FieldsTab('first-tab')]);

        $this->assertCount(1, $arrangement->tabs());
        $this->assertCount(2, $arrangement->addTab(new FieldsTab('second-tab'))->tabs());
    }

    /** @test */
    public function a_tab_can_be_added_at_specific_position()
    {
        $arrangement = new FieldArrangement(new Fields([]), [new FieldsTab('first-tab')]);

        $arrangement = $arrangement->addTab(new FieldsTab('second-tab'), 0);

        $this->assertEquals('second-tab', $arrangement->tabs()[0]->title());
    }

    /** @test */
    public function adding_a_tab_is_an_immutable_action()
    {
        $arrangement = new FieldArrangement(new Fields([]), [new FieldsTab('first-tab')]);

        $this->assertCount(2, $arrangement->addTab(new FieldsTab('second-tab'))->tabs());
        $this->assertCount(1, $arrangement->tabs());
    }

    /** @test */
    public function remaining_field_is_automatically_placed_in_last_tab()
    {
        $arrangement = new FieldArrangement(new Fields([
            InputField::make('first-input-field'), InputField::make('second-input-field')
        ]), [new FieldsTab('first-tab', ['first-input-field'])]);

        $arrangement = $arrangement->addTab(new RemainingFieldsTab('second-tab', []));

        $this->assertCount(2, $arrangement->tabs());
        $this->assertCount(2, $arrangement->fields());
    }

    /** @test */
    public function by_default_fields_are_arranged_by_their_order_of_appearance()
    {
        $arrangement = $this->manager->fieldArrangement();

        $this->assertFalse($arrangement->hasTabs());
        $this->assertCount(6, $arrangement->fields());
        $this->assertEquals('title', $arrangement->fields()[0]->key);
        $this->assertEquals('avatar', $arrangement->fields()[4]->key);
        $this->assertEquals('doc', $arrangement->fields()[5]->key);
    }

    /** @test */
    public function fields_can_be_arranged_by_tabs()
    {
        app(Register::class)->register('fakes', ManagerFakeWithFieldTabs::class, ManagedModelFake::class);
        $manager = (new ManagerFakeWithFieldTabs(app(Register::class)->first()))->manage($this->model);
        $arrangement = $manager->fieldArrangement();

        $this->assertTrue($arrangement->hasTabs());

        $this->assertCount(3, $arrangement->tabs()[0]->fields());
        $this->assertCount(2, $arrangement->tabs()[1]->fields());
        $this->assertInstanceOf(Field::class, $arrangement->tabs()[1]->fields()[0]);
    }
}
