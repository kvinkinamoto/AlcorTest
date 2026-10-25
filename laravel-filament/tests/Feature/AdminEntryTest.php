<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminEntryTest extends TestCase
{
    public function test_landing_page_and_dashboard_link_lead_to_the_admin(): void
    {
        $this->get('/')->assertRedirect('/admin');
        $this->get('/dashboard')->assertRedirect('/admin');
    }
}
