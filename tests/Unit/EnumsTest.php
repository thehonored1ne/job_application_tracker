<?php

namespace Tests\Unit;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Enums\SalaryPeriod;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    public function test_application_status_enum_implements_filament_contracts_and_helpers(): void
    {
        $this->assertEquals('Applied', ApplicationStatus::Applied->getLabel());
        $this->assertEquals('info', ApplicationStatus::Applied->getColor());
        $this->assertNotNull(ApplicationStatus::Applied->getIcon());

        $this->assertTrue(ApplicationStatus::TechnicalInterview->isInterviewStage());
        $this->assertFalse(ApplicationStatus::Applied->isInterviewStage());

        $this->assertTrue(ApplicationStatus::Applied->isActive());
        $this->assertTrue(ApplicationStatus::OfferReceived->isActive());
        $this->assertFalse(ApplicationStatus::Rejected->isActive());

        $this->assertTrue(ApplicationStatus::Rejected->isClosed());
        $this->assertTrue(ApplicationStatus::Accepted->isClosed());
        $this->assertFalse(ApplicationStatus::Wishlist->isClosed());
    }

    public function test_employment_type_enum(): void
    {
        $this->assertEquals('Full-time', EmploymentType::FullTime->getLabel());
        $this->assertEquals('primary', EmploymentType::FullTime->getColor());
        $this->assertNotNull(EmploymentType::FullTime->getIcon());
    }

    public function test_location_type_enum(): void
    {
        $this->assertEquals('Remote', LocationType::Remote->getLabel());
        $this->assertEquals('success', LocationType::Remote->getColor());
        $this->assertNotNull(LocationType::Remote->getIcon());
    }

    public function test_salary_period_enum(): void
    {
        $this->assertEquals('Yearly', SalaryPeriod::Yearly->getLabel());
        $this->assertEquals('Monthly', SalaryPeriod::Monthly->getLabel());
        $this->assertEquals('Hourly', SalaryPeriod::Hourly->getLabel());
    }

    public function test_round_type_enum(): void
    {
        $this->assertEquals('Technical Interview', RoundType::Technical->getLabel());
        $this->assertEquals('purple', RoundType::Technical->getColor());
        $this->assertNotNull(RoundType::Technical->getIcon());
    }

    public function test_round_status_enum(): void
    {
        $this->assertEquals('Scheduled', RoundStatus::Scheduled->getLabel());
        $this->assertEquals('warning', RoundStatus::Scheduled->getColor());
        $this->assertNotNull(RoundStatus::Scheduled->getIcon());
    }
}
