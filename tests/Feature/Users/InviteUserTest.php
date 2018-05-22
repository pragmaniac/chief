<?php

namespace Chief\Tests\Feature\Users;

use App\Notifications\InvitationMail;
use Chief\Tests\ChiefDatabaseTransactions;
use Chief\Tests\TestCase;
use Chief\Users\Invites\Invitation;
use Chief\Users\Invites\InvitationState;
use Chief\Users\User;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

class InviteUserTest extends TestCase
{
    use ChiefDatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->setUpDefaultAuthorization();
    }

    /** @test */
    function only_admin_can_view_the_invite_form()
    {
        $response = $this->asAdmin()->get(route('back.users.create'));
        $response->assertStatus(200);
    }

    /** @test */
    function regular_author_cannot_view_the_invite_form()
    {
        $response = $this->asAuthor()->get(route('back.users.create'));

        $response->assertStatus(302)
            ->assertRedirect(route('back.dashboard'))
            ->assertSessionHas('messages.error');
    }

    /** @test */
    function inviting_a_new_user()
    {
        Notification::fake();

        $this->disableExceptionHandling();

        $response = $this->asAdmin()
                         ->post(route('back.users.store'), $this->validParams());

        $response->assertStatus(302)
            ->assertRedirect(route('back.users.index'))
            ->assertSessionHas('messages.success');

        $newUser = User::findByEmail('new@example.com');

        $this->assertNewValues($newUser);
        $this->assertEquals(InvitationState::PENDING, $newUser->invitation->state());

        Notification::assertSentTo(new AnonymousNotifiable(), InvitationMail::class);
    }

    /** @test */
    function it_can_render_the_invitation_mail()
    {
        $invitee = factory(User::class)->create();
        $inviter = $this->developer();

        $invitation = Invitation::make($invitee->id, $inviter->id);

        $this->verifyMailRender((new InvitationMail($invitation))->toMail('foobar@example.com'));
    }

    /** @test */
    function only_authenticated_admin_can_invite_an_user()
    {
        $response = $this->post(route('back.users.store'), $this->validParams());

        $response->assertRedirect(route('back.login'));
        $this->assertCount(0, User::all());
    }

    /** @test */
    function regular_author_cannot_invite_an_user()
    {
        $response = $this->asAuthor()->post(route('back.users.store'), $this->validParams());

        $response->assertRedirect(route('back.dashboard'));
        $this->assertCount(1, User::all()); // Existing author
    }

    /** @test */
    function when_creating_user_firstname_is_required()
    {
        $this->assertValidation(new User(), 'firstname', $this->validParams(['firstname' => '']),
            route('back.users.index'),
            route('back.users.store'),
            1 // creating account (developer) already exists
        );
    }

    /** @test */
    function when_creating_user_lastname_is_required()
    {
        $this->assertValidation(new User(), 'lastname', $this->validParams(['lastname' => '']),
            route('back.users.index'),
            route('back.users.store'),
            1 // creating account (developer) already exists
        );
    }

    /** @test */
    function when_creating_user_role_is_required()
    {
        $this->assertValidation(new User(), 'roles', $this->validParams(['roles' => []]),
            route('back.users.index'),
            route('back.users.store'),
            1 // creating account (developer) already exists
        );
    }

    private function validParams($overrides = [])
    {
        $params = [
            'firstname' => 'new firstname',
            'lastname' => 'new lastname',
            'email' => 'new@example.com',
            'roles' => ['author'],
        ];

        foreach ($overrides as $key => $value){
            array_set($params,  $key, $value);
        }

        return $params;
    }

    private function assertNewValues(User $user)
    {
        $this->assertEquals('new firstname', $user->firstname);
        $this->assertEquals('new lastname', $user->lastname);
        $this->assertEquals('new@example.com', $user->email);
        $this->assertEquals(['author'], $user->roles->pluck('name')->toArray());
    }
}