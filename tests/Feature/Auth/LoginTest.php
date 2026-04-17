<?php

declare(strict_types=1);

it('loads the login page', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertViewIs('auth.login');
});

it('authenticates a user with valid credentials', function () {
    $user = \App\Models\User::factory()->create([
        'email'    => 'admin@octabit.tech',
        'password' => bcrypt('password'),
    ]);

    $this->post(route('login'), [
        'email'    => 'admin@octabit.tech',
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    \App\Models\User::factory()->create([
        'email'    => 'user@octabit.tech',
        'password' => bcrypt('correct'),
    ]);

    $this->post(route('login'), [
        'email'    => 'user@octabit.tech',
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();

    $this->assertGuest();
});

it('logs out a user', function () {
    $this->actingAs(adminUser())
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

it('redirects authenticated users away from login page', function () {
    $this->actingAs(adminUser())
        ->get(route('login'))
        ->assertRedirect(route('dashboard'));
});
