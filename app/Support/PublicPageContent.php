<?php

namespace App\Support;

use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Schema;

class PublicPageContent
{
    public static function ourWork(): array
    {
        return self::setting('public_our_work_page', self::ourWorkDefaults());
    }

    public static function saveOurWork(array $content): void
    {
        self::saveSetting('public_our_work_page', self::normalizePage($content, self::ourWorkDefaults()));
    }

    public static function services(): array
    {
        $content = self::setting('public_services_page', self::servicesDefaults());
        $defaults = self::servicesDefaults();
        $legacyDescription = 'We provide seamless, end-to-end event planning, handling every detail from concept to completion. From venue sourcing and event design to AV production, logistics, and virtual streaming, we ensure flawless execution.';

        if ($content['eyebrow'] === 'Tools to create any experience') {
            $content['eyebrow'] = $defaults['eyebrow'];
        }
        if ($content['description'] === $legacyDescription) {
            $content['description'] = $defaults['description'];
        }
        $content['cards'] = self::curatedServiceCards($content['cards'] ?? []);

        return $content;
    }

    public static function saveServices(array $content): void
    {
        $defaults = self::servicesDefaults();
        $normalized = self::normalizePage($content, $defaults);
        $normalized['cards'] = self::curatedServiceCards(array_values(array_map(
            fn (array $card): array => self::normalizeCard($card),
            array_filter($content['cards'] ?? [], 'is_array')
        )));

        self::saveSetting('public_services_page', $normalized);
    }

    private static function setting(string $key, array $defaults): array
    {
        if (! Schema::hasTable('homepage_settings')) {
            return $defaults;
        }

        $setting = HomepageSetting::query()->where('key', $key)->first();
        if (! is_array($setting?->value)) {
            return $defaults;
        }

        $value = self::normalizePage($setting->value, $defaults);
        if (isset($defaults['cards'])) {
            $value['cards'] = array_values(array_map(
                fn (array $card): array => self::normalizeCard($card),
                array_filter($setting->value['cards'] ?? [], 'is_array')
            ));

            if ($value['cards'] === []) {
                $value['cards'] = $defaults['cards'];
            }
        }

        return $value;
    }

    private static function saveSetting(string $key, array $value): void
    {
        HomepageSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    private static function normalizePage(array $content, array $defaults): array
    {
        return array_merge($defaults, [
            'eyebrow' => trim((string) ($content['eyebrow'] ?? $defaults['eyebrow'])),
            'title' => trim((string) ($content['title'] ?? $defaults['title'])),
            'description' => trim((string) ($content['description'] ?? $defaults['description'])),
        ]);
    }

    private static function normalizeCard(array $card): array
    {
        return [
            'title' => trim((string) ($card['title'] ?? '')),
            'description' => trim((string) ($card['description'] ?? '')),
            'image' => trim((string) ($card['image'] ?? '')),
            'image_alt' => trim((string) ($card['image_alt'] ?? '')),
        ];
    }

    /**
     * Keep the public services list fixed while preserving an uploaded image
     * already assigned to the matching service in the admin.
     *
     * @param  array<int, array<string, mixed>>  $cards
     * @return array<int, array{title:string,description:string,image:string,image_alt:string}>
     */
    private static function curatedServiceCards(array $cards): array
    {
        $savedCards = [];
        foreach ($cards as $card) {
            $normalized = self::normalizeCard($card);
            $savedCards[strtolower($normalized['title'])] = $normalized;
        }

        return array_values(array_map(function (array $definition) use ($savedCards): array {
            $saved = $savedCards[strtolower($definition['title'])] ?? [];

            return array_merge($definition, [
                'image' => trim((string) ($saved['image'] ?? $definition['image'])),
                'image_alt' => trim((string) ($saved['image_alt'] ?? '')) ?: $definition['image_alt'],
            ]);
        }, self::servicesDefaults()['cards']));
    }

    private static function ourWorkDefaults(): array
    {
        return [
            'eyebrow' => 'Peak Experience Case Studies',
            'title' => 'Our Work',
            'description' => 'Explore the live moments Peak Experience has shaped for conferences, exhibitions, brand experiences, and corporate events across Kenya.',
        ];
    }

    private static function servicesDefaults(): array
    {
        return [
            'eyebrow' => 'End-to-end event production in Kenya',
            'title' => 'Our Services',
            'description' => 'Peak Experience delivers professional event production services in Nairobi and across Kenya. From AV production, set construction, event design, delegate logistics, live streaming, event branding, and custom exhibition booth building to simultaneous interpretation, our team coordinates every technical and creative detail for conferences, corporate events, exhibitions, launches, and hybrid experiences.',
            'cards' => [
                [
                    'title' => 'AV Production & Set Build',
                    'description' => 'Sound, lighting, LED screens, staging, scenic construction, and show control are designed as one dependable production system.',
                    'image' => '',
                    'image_alt' => 'Live event AV production and stage lighting',
                ],
                [
                    'title' => 'Event Design & Theming',
                    'description' => 'We turn your brief into a coherent environment through spatial design, décor, furniture, lighting, and thoughtful guest touchpoints.',
                    'image' => '',
                    'image_alt' => 'A themed event environment designed for guests',
                ],
                [
                    'title' => 'Delegate Logistics',
                    'description' => 'Registration, travel, accommodation, accreditation, schedules, transport, and on-site movement are coordinated around a smooth delegate journey.',
                    'image' => '',
                    'image_alt' => 'Delegates arriving at a professionally managed event',
                ],
                [
                    'title' => 'Streaming & Virtual Events',
                    'description' => 'Broadcast production, remote speakers, live streaming, recording, and audience interaction connect the room with viewers everywhere.',
                    'image' => '',
                    'image_alt' => 'Live event streaming and virtual production setup',
                ],
                [
                    'title' => 'Event Branding',
                    'description' => 'From stage graphics and digital screens to wayfinding, print, and branded installations, every surface reinforces one clear identity.',
                    'image' => '',
                    'image_alt' => 'Branded stage and event environment',
                ],
                [
                    'title' => 'Exhibition Booth Building',
                    'description' => 'We design and build custom exhibition stands for conferences and trade shows, translating your brand guidelines into engaging, functional booths with branded graphics, displays, lighting, furniture, and visitor-ready meeting spaces.',
                    'image' => 'images/services/exhibition-booth-building.jpg',
                    'image_alt' => 'Custom Incode exhibition booth built to match brand guidelines at a conference',
                ],
                [
                    'title' => 'Translation Services',
                    'description' => 'We hire out simultaneous interpretation equipment and coordinate professional translators so multilingual audiences can follow conferences, meetings, and live events clearly in real time.',
                    'image' => '',
                    'image_alt' => 'Simultaneous interpretation equipment and professional conference translators',
                ],
            ],
        ];
    }
}
