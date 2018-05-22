<?php

namespace Chief\Tests\Feature\Users;

use Chief\Tests\ChiefDatabaseTransactions;
use Chief\Tests\TestCase;
use Chief\Users\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordTest extends TestCase
{
    use ChiefDatabaseTransactions;

    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->user = new User();
        $this->user->email = 'email';
        $this->user->firstname = 'firstname';
        $this->user->lastname = 'lastname';
        $this->user->password = Hash::make('password');
        $this->user->save();
    }


    /** @test */
    function only_logged_in_user_can_update_password()
    {
        $this->assertFalse(auth()->guard('admin')->check());

        $response = $this->put(route('back.password.update'), ['password' => 'new password', 'password_confirm' => 'new password']);
        $response->assertRedirect(route('back.login'));

        // Assert password remains the same
        $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    }

    /** @test */
    function when_user_fills_in_password_prompt_password_gets_updated()
    {
        $response = $this->actingAs($this->user, 'admin')
                         ->put(route('back.password.update'), ['password' => 'new password', 'password_confirmation' => 'new password']);

        $response->assertRedirect(route('back.dashboard'));

        // Assert password is changed
        $this->assertTrue(Hash::check('new password', $this->user->fresh()->password));
    }
}