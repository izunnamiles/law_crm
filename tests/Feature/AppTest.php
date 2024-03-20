<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Counsel;
use App\Notifications\PassportReminderNotification;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AppTest extends TestCase
{
    public function test_create_cases_and_profile_client_without_passport(): void
    {
        Notification::fake();
        $payload = [
            'client_type' => 'new',
            'first_name' => 'Ndu',
            'last_name' => 'Tagbo',
            'email' => 'sample2@example.com',
            'date_of_birth' => '2000-06-06',
            'date_profiled' => '2024-03-10',
            'counsel' => $this->counsel(),
            'case_details' => 'sample case details',
        ];
        $response = $this->postJson(route('create'), $payload);
        $this->assertDatabaseHas('clients', [
            'email' => 'sample2@example.com',
        ]);
        $this->assertDatabaseHas('cases', [
            'case_details' => 'sample case details',
        ]);
        Notification::assertSentOnDemand(WelcomeNotification::class);
        $response->assertStatus(200);
    }

    public function test_create_cases_and_profile_client_with_passport(): void
    {
        Notification::fake();
        Storage::fake('public');
        $payload = [
            'client_type' => 'new',
            'first_name' => 'Ndu',
            'last_name' => 'Tagbo',
            'email' => 'sample2@example.com',
            'date_of_birth' => '2000-06-06',
            'date_profiled' => '2024-03-10',
            'passport' => UploadedFile::fake()->image('photo1.jpg'),
            'counsel' => $this->counsel(),
            'case_details' => 'sample case details',
        ];
        $response = $this->postJson(route('create'), $payload);
        $photo = 'photo1_' . time() . '.jpg';
        $this->assertDatabaseHas('clients', [
            'email' => 'sample2@example.com',
            'passport' => $photo
        ]);
        Storage::disk('public')->assertExists('/passport/' . $photo);
        $this->assertDatabaseHas('cases', [
            'case_details' => 'sample case details',
        ]);
        Notification::assertSentOnDemand(WelcomeNotification::class);
        $response->assertStatus(200);
    }

    public function test_create_cases_fail(): void
    {
        Notification::fake();
        $payload = [
            'client_type' => 'new',
            'case_details' => 'sample case details',
        ];
        $response = $this->postJson(route('create'), $payload);
        $response->assertStatus(422);
    }

    public function test_create_cases_with_existing_client(): void
    {
        Notification::fake();
        $payload = [
            'client_type' => 'existing',
            'client_id' => $this->clientExisting(),
            'counsel' => $this->counsel(),
            'case_details' => 'sample case details',
        ];
        $response = $this->postJson(route('create'), $payload);
        $this->assertDatabaseHas('cases', [
            'case_details' => 'sample case details',
        ]);
        Notification::assertNothingSent();
        $response->assertStatus(200);
    }

    public function test_create_cases_with_existing_client_validation(): void
    {
        Notification::fake();
        $payload = [
            'client_type' => 'existing'
        ];
        $response = $this->postJson(route('create'), $payload);
        $response->assertStatus(422);
    }

    public function test_passport_reminder_notification_sent()
    {
        Notification::fake();
        Client::create([
            'first_name' => 'Ndu',
            'last_name' => 'Tagbo',
            'email' => 'sample2@example.com',
            'date_of_birth' => '2000-06-06',
            'date_profiled' => '2024-03-10',
            'case_details' => 'sample case details',
            'created_at' => now()->subDay(3)
        ]);

        $this->artisan('reminder:passport')->assertSuccessful();
        Notification::assertSentOnDemand(PassportReminderNotification::class);
    }

    public function test_passport_reminder_notification_not_sent()
    {
        Notification::fake();
        Client::create([
            'first_name' => 'Ndu',
            'last_name' => 'Tagbo',
            'email' => 'sample2@example.com',
            'date_of_birth' => '2000-06-06',
            'date_profiled' => '2024-03-10',
            'case_details' => 'sample case details',
            'created_at' => now()->subDay(2)
        ]);

        $this->artisan('reminder:passport')->assertSuccessful();
        Notification::assertNothingSent();
    }

    private function counsel()
    {
        return Counsel::create(['name' => 'John Smith'])->id;
    }

    private function clientExisting()
    {
        return Client::create([
            'first_name' => 'Ndu',
            'last_name' => 'Tagbo',
            'email' => 'sample2@example.com',
            'date_of_birth' => '2000-06-06',
            'date_profiled' => '2024-03-10',
            'case_details' => 'sample case details',
        ])->id;
    }
}
