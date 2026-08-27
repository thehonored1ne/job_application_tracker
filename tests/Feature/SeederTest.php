<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Contact;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_executes_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
        ]);

        $this->assertGreaterThan(0, Company::count());
        $this->assertGreaterThan(0, Contact::count());
        $this->assertGreaterThan(0, JobApplication::count());
        $this->assertGreaterThan(0, InterviewRound::count());
    }
}
