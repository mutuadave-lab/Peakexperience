<?php

namespace Tests\Feature;

use App\Models\HomepageSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OurServicesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_page_uses_only_the_curated_services_and_uploaded_work_images(): void
    {
        HomepageSetting::query()->create([
            'key' => 'public_services_page',
            'value' => [
                'eyebrow' => 'Production support',
                'title' => 'Our Services',
                'description' => 'End-to-end event delivery.',
                'cards' => [
                    ['title' => 'Content Development', 'description' => 'Old service', 'image' => '', 'image_alt' => ''],
                    ['title' => 'Venue Sourcing', 'description' => 'Old service', 'image' => '', 'image_alt' => ''],
                ],
            ],
        ]);

        HomepageSetting::query()->create([
            'key' => 'pages',
            'value' => [
                [
                    'id' => 'post-1',
                    'slug' => 'uploaded-work',
                    'meta_title' => 'Uploaded Work',
                    'meta_description' => 'Uploaded work',
                    'title' => 'Uploaded Work',
                    'image' => 'homepage/pages/work-hero.jpg',
                    'image_alt' => 'Production stage',
                    'gallery_images' => [
                        'homepage/pages/gallery/work-one.jpg',
                        'homepage/pages/gallery/work-two.jpg',
                        'homepage/pages/gallery/work-three.jpg',
                        'homepage/pages/gallery/work-four.jpg',
                    ],
                    'event_date' => '',
                    'heading_two' => 'Brief',
                    'delivery_heading' => 'Delivery',
                    'delivery_description' => '',
                    'type' => 'Post',
                    'description' => '<p>Work description.</p>',
                    'created_at' => now()->toIso8601String(),
                    'updated_at' => now()->toIso8601String(),
                ],
            ],
        ]);

        $response = $this->get(route('our-services'));

        $response->assertOk();
        $response->assertSee('AV Production &amp; Set Build', false);
        $response->assertSee('Event Design &amp; Theming', false);
        $response->assertSee('Delegate Logistics');
        $response->assertSee('Streaming &amp; Virtual Events', false);
        $response->assertSee('Event Branding');
        $response->assertSee('Exhibition Booth Building');
        $response->assertSee('custom exhibition stands for conferences and trade shows');
        $response->assertSee(asset('images/services/exhibition-booth-building.jpg'), false);
        $response->assertSee('Translation Services');
        $response->assertSee('simultaneous interpretation equipment');
        $response->assertDontSee('Content Development');
        $response->assertDontSee('Venue Sourcing');
        $response->assertDontSee('Technical Production');
        $response->assertSee('homepage/pages/work-hero.jpg', false);
        $response->assertSee('homepage/pages/gallery/work-four.jpg', false);
        $response->assertSee('<dialog class="enquiry-modal" id="event-enquiry-dialog"', false);
        $response->assertSee('data-enquiry-open', false);
        $response->assertDontSee('class="enquiry-section"', false);
        $response->assertSee('action="' . route('contact.submit') . '"', false);
        $response->assertSee('<title>Event Production Services in Kenya | Peak Experience</title>', false);
        $response->assertSee('<link rel="canonical" href="' . route('our-services') . '">', false);
        $response->assertSee('"@type":"ItemList"', false);
        $this->assertSame(7, substr_count($response->getContent(), 'class="service-item"'));
    }
}
