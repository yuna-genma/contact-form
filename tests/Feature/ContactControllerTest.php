<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_index_can_get(): void
    {
        $response = $this->get(route('contact.index'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    /** @test */
    public function test_can_create_post()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => '09000000000',
            'content' => 'これはテストです',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertViewHas('post', fn($post) => $post->name === 'テストユーザー');
    }

    /** @test */
    public function test_thanks_can_post()
    {
        $post = Contact::factory()->create();

        $response = $this->post(route('contact.thanks'));

        $response->assertStatus(200);
        $response->assertViewIs('thanks');
    }

    /** @test */
    public function test_create_post_requires_name()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => '',
            'email' => 'test@example.com',
            'tel' => '09000000000',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_create_post_requires_email()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => '',
            'tel' => '09000000000',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_create_post_requires_tel()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => '',
        ]);

        $response->assertSessionHasErrors('tel');
    }

    /** @test */
    public function test_name_max_255_characters()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => str_repeat('あ', 255),
            'email' => 'test@example.com',
            'tel' => '09000000000',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertViewHas('post', fn($post) => $post->name === str_repeat('あ', 255));
    }

    /** @test */
    public function test_name_must_be_within_255()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => str_repeat('あ', 256),
            'email' => 'test@example.com',
            'tel' => '09000000000',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_email_max_255_characters()
    {
        $email = str_repeat('a', 243) . '@example.com';
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => $email,
            'tel' => '09000000000',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertViewHas('post', function ($post) use ($email) {
            return $post->email === $email;
        });
    }

    /** @test */
    public function test_email_must_be_within_255()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => str_repeat('a', 255),
            'tel' => '09000000000',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_tel_10_characters()
    {
        $tel10 = str_repeat('0', 10);

        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => $tel10,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertViewHas('post', fn($post) => $post->tel === $tel10);
    }

    /** @test */
    public function test_tel_11_characters()
    {
        $tel11 = str_repeat('0', 11);

        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => $tel11,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertViewHas('post', fn($post) => $post->tel === $tel11);
    }

    /** @test */
    public function test_tel_must_be_10_characters_or_more()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => str_repeat('0', 9),
        ]);

        $response->assertSessionHasErrors('tel');
    }

    /** @test */
    public function test_tel_must_be_11_characters_or_less()
    {
        $response = $this->post(route('contact.confirm'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => str_repeat('0', 12),
        ]);

        $response->assertSessionHasErrors('tel');
    }
}