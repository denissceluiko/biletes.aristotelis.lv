<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Notifications\DiscountIssued;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_generate_discounts(): void
    {
        Discount::generate(10);

        $this->assertDatabaseCount('discounts', 10);
    }

    /**
     * @test
     */
    public function it_can_issue_a_discount(): void
    {
        $email = 'aa12345@students.lu.lv';
        $discount = Discount::factory()->create();

        Discount::issue($email);

        $this->assertDatabaseHas('discounts', [
            'code' => $discount->code,
            'email' => 'aa12345',
        ]);
    }

    /**
     * @test
     */
    public function it_will_issue_only_one_discount_per_email(): void
    {
        $email = 'aa12345@students.lu.lv';
        Discount::factory()
            ->count(2)
            ->create();

        $d1 = Discount::issue($email);
        $d2 = Discount::issue($email);

        $this->assertTrue($d1->is($d2));
    }

    /**
     * @test
     */
    public function it_can_send_a_discount(): void
    {
        Notification::fake();

        $email = 'aa12345@students.lu.lv';
        
        Discount::factory()
            ->create();

        $discount = Discount::issue($email);
        $discount->send($email);

        Notification::assertSentOnDemand(DiscountIssued::class);
    }
}
