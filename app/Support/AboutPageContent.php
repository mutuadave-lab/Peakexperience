<?php

namespace App\Support;

class AboutPageContent
{
    /**
     * @return array<int, array{slug:string,title:string}>
     */
    public static function navigation(): array
    {
        return array_values(array_map(
            fn (array $page): array => ['slug' => $page['slug'], 'title' => $page['title']],
            self::pages()
        ));
    }

    public static function findBySlug(string $slug): ?array
    {
        foreach (self::pages() as $page) {
            if ($page['slug'] === $slug) {
                return $page;
            }
        }

        return null;
    }

    /**
     * Curated, Kenya-specific company pages presented through the public page layout.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function pages(): array
    {
        $now = now()->toIso8601String();

        return [
            [
                'id' => 'about-careers',
                'slug' => 'careers',
                'meta_title' => 'Event Production Careers in Kenya | Peak Experience',
                'meta_description' => 'Explore careers and freelance opportunities in event planning, AV production, logistics, staging, and live event delivery with Peak Experience in Kenya.',
                'title' => 'Careers',
                'image' => asset('images/pages/careers/careers-hero-1600.webp'),
                'image_srcset' => asset('images/pages/careers/careers-hero-800.webp') . ' 800w, ' . asset('images/pages/careers/careers-hero-1600.webp') . ' 1600w',
                'image_alt' => 'Peak Experience event production team in Kenya',
                'intro_image' => asset('images/pages/careers/careers-intro-1600.webp'),
                'intro_image_srcset' => asset('images/pages/careers/careers-intro-800.webp') . ' 800w, ' . asset('images/pages/careers/careers-intro-1600.webp') . ' 1600w',
                'gallery_images' => [
                    asset('images/pages/careers/careers-team-1600.webp'),
                    asset('images/pages/careers/careers-event-crew-1600.webp'),
                    asset('images/pages/careers/careers-production-1600.webp'),
                ],
                'gallery_image_srcsets' => [
                    asset('images/pages/careers/careers-team-800.webp') . ' 800w, ' . asset('images/pages/careers/careers-team-1600.webp') . ' 1600w',
                    asset('images/pages/careers/careers-event-crew-800.webp') . ' 800w, ' . asset('images/pages/careers/careers-event-crew-1600.webp') . ' 1600w',
                    asset('images/pages/careers/careers-production-800.webp') . ' 800w, ' . asset('images/pages/careers/careers-production-1600.webp') . ' 1600w',
                ],
                'event_date' => '',
                'heading_two' => 'Build memorable events with us',
                'delivery_heading' => 'Working at Peak Experience',
                'delivery_description' => '',
                'type' => 'Page',
                'description' => '<p>Peak Experience brings together planners, producers, technicians, designers, logistics specialists, and trusted event crew to deliver conferences, exhibitions, and brand experiences across Kenya.</p><p>We value practical problem-solving, calm delivery, attention to detail, and respect for every client, guest, supplier, and teammate. Opportunities may include permanent roles, project contracts, internships, and freelance event assignments based in Kenya.</p><h2>How to express interest</h2><p>Send a concise introduction, your CV or portfolio, and the area of event production you specialise in to <a href="mailto:info@peakexperience.co.ke">info@peakexperience.co.ke</a>. When a suitable local opportunity becomes available, our team will be in touch.</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 'about-inclusion',
                'slug' => 'equality-diversity-inclusion',
                'meta_title' => 'Equality, Diversity and Inclusion | Peak Experience Kenya',
                'meta_description' => 'Learn how Peak Experience supports inclusive event planning, accessible guest experiences, and fair collaboration across Kenya’s diverse communities.',
                'title' => 'Equality, Diversity & Inclusion',
                'image' => asset('images/pages/inclusion/inclusion-hero-1600.webp'),
                'image_srcset' => asset('images/pages/inclusion/inclusion-hero-800.webp') . ' 800w, ' . asset('images/pages/inclusion/inclusion-hero-1600.webp') . ' 1600w',
                'image_alt' => 'A diverse audience attending the Africa Fintech Forum in Nairobi, Kenya',
                'intro_image' => asset('images/pages/inclusion/inclusion-intro-1600.webp'),
                'intro_image_srcset' => asset('images/pages/inclusion/inclusion-intro-800.webp') . ' 800w, ' . asset('images/pages/inclusion/inclusion-intro-1600.webp') . ' 1600w',
                'gallery_images' => [
                    asset('images/pages/conferences/conference-strategy-1400.webp'),
                    asset('images/pages/brand-experiences/audience-engagement-1400.webp'),
                    asset('images/pages/inclusion/inclusion-conference-1600.webp'),
                ],
                'gallery_image_srcsets' => [
                    asset('images/pages/conferences/conference-strategy-800.webp') . ' 800w, ' . asset('images/pages/conferences/conference-strategy-1400.webp') . ' 1400w',
                    asset('images/pages/brand-experiences/audience-engagement-800.webp') . ' 800w, ' . asset('images/pages/brand-experiences/audience-engagement-1400.webp') . ' 1400w',
                    asset('images/pages/inclusion/inclusion-conference-800.webp') . ' 800w, ' . asset('images/pages/inclusion/inclusion-conference-1600.webp') . ' 1600w',
                ],
                'event_date' => '',
                'heading_two' => 'Events designed to welcome everyone',
                'delivery_heading' => 'Inclusive event delivery',
                'delivery_description' => '',
                'type' => 'Page',
                'description' => '<p>Kenya is home to many cultures, languages, abilities, and lived experiences. Our role is to create event environments where people can participate with dignity, confidence, and a genuine sense of belonging.</p><p>We consider accessible venues, clear wayfinding, inclusive registration, interpretation requirements, dietary needs, respectful programming, and practical guest support from the earliest planning stage. We also work to create fair opportunities for Kenyan suppliers, freelancers, and production partners.</p><h2>Our approach</h2><p>Every brief is different, so we listen first. We collaborate with clients and venues to identify barriers, plan appropriate support, and communicate clearly with delegates before and during the event.</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 'about-sustainability',
                'slug' => 'sustainability',
                'meta_title' => 'Sustainable Event Production in Kenya | Peak Experience',
                'meta_description' => 'Discover Peak Experience’s practical approach to sustainable events in Kenya, including reusable production assets, local sourcing, efficient logistics, and waste reduction.',
                'title' => 'Sustainability',
                'image' => asset('images/pages/sustainability/sustainability-hero.webp'),
                'image_alt' => 'Peak Experience team members at an outdoor event in Kenya',
                'gallery_images' => [],
                'event_date' => '',
                'heading_two' => 'Practical progress for events in Kenya',
                'delivery_heading' => 'Lower-impact production choices',
                'delivery_description' => '',
                'type' => 'Page',
                'description' => '<p>We help clients make thoughtful production decisions that reduce avoidable waste while protecting the quality, safety, and impact of their event. Our approach is grounded in what is practical for venues, suppliers, and audiences in Kenya.</p><p>Where the brief allows, we prioritise reusable staging and furniture, modular exhibition structures, efficient LED technology, digital communication, responsible material quantities, and consolidated transport schedules. Working with Kenyan suppliers also helps shorten supply chains and strengthens local event-industry capability.</p><h2>Planning with purpose</h2><p>Sustainability works best when it is considered early. We discuss priorities during pre-production, identify realistic improvements, and help clients balance environmental goals with budget, venue, and technical requirements.</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 'about-faqs',
                'slug' => 'faqs',
                'meta_title' => 'Event Planning FAQs Kenya | Peak Experience',
                'meta_description' => 'Answers to common questions about hiring Peak Experience for conferences, exhibitions, brand experiences, AV production, and corporate events across Kenya.',
                'title' => 'FAQs',
                'image' => asset('images/pages/conferences/conference-planning-1400.webp'),
                'image_alt' => 'Conference stage planned and produced by Peak Experience in Nairobi, Kenya',
                'intro_image' => asset('images/pages/faqs/event-planning.webp'),
                'gallery_images' => [],
                'event_date' => '',
                'heading_two' => 'Planning an event with Peak Experience',
                'delivery_heading' => 'Frequently asked questions',
                'delivery_description' => '',
                'type' => 'Page',
                'description' => '<h2>Where do you operate?</h2><p>We plan and produce events locally within Kenya, including Nairobi and other Kenyan destinations supported by our supplier and venue network.</p><h2>What types of events do you deliver?</h2><p>Our work includes conferences, exhibitions, brand experiences, launches, corporate events, hybrid productions, and selected outdoor builds.</p><h2>Can you manage the full event?</h2><p>Yes. We can coordinate the complete journey from creative planning and venue preparation to AV, staging, branding, delegate logistics, registration, show calling, and on-site delivery.</p><h2>Can you support one part of an event?</h2><p>Yes. Clients can engage us for focused services such as AV production, set construction, event branding, streaming, interpretation equipment, or exhibition stand building.</p><h2>How early should we contact you?</h2><p>Contacting us early gives more choice around venues, equipment, suppliers, and production schedules. We can also assess shorter lead-time briefs based on scope and availability.</p><h2>How do we request a quotation?</h2><p>Send your date, location, expected guest numbers, event type, objectives, and estimated budget through our enquiry form. We will review the brief and recommend the next planning step.</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
