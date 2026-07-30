@php
    $contactEmail = trim((string) ($contactEmail ?? ''));
    $hasContactEmail = filled($contactEmail);
    $contactPhones = is_array($contactPhones ?? null) ? $contactPhones : [];
    $socialLinks = is_array($socialLinks ?? null) ? $socialLinks : [];
    $whatsappUrl = trim((string) ($whatsappUrl ?? ''));
    $hasWhatsapp = filled($whatsappUrl);
    $navPages = [
        ['slug' => 'conferences', 'title' => 'Conferences'],
        ['slug' => 'brand-experiences', 'title' => 'Brand Experience'],
        ['slug' => 'exhibitions', 'title' => 'Exhibitions'],
    ];
    $aboutPages = \App\Support\AboutPageContent::navigation();
    $logoUrl = \App\Support\HomepageContent::assetUrl(
        (string) data_get($logo ?? [], 'path', data_get($logo ?? [], 'url', ''))
    );
    $hasLogo = filled($logoUrl);
    $pageContent = is_array($pageContent ?? null) ? $pageContent : [];
    $workImages = array_values(array_filter(array_map(
        fn ($image) => \App\Support\HomepageContent::assetUrl((string) $image),
        is_array($workImages ?? null) ? $workImages : []
    )));
    $eventTypeOptions = ['Conference', 'Brand Launch', 'Exhibition', 'Awards', 'Hybrid / Virtual Event', 'Corporate Event', 'Other'];
    $referralOptions = ['Google / Search', 'Social Media', 'Referral', 'Previous Event', 'Returning Client', 'Other'];
    $ctaImage = count($workImages) > 0 ? $workImages[count($workImages) - 1] : '';
    $seoTitle = 'Event Production Services in Kenya | Peak Experience';
    $seoDescription = 'Professional event production services in Kenya, including AV, set build, event design, logistics, streaming, branding, custom exhibition booths, and interpretation.';
    $serviceSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Peak Experience Event Production Services',
        'description' => $seoDescription,
        'url' => route('our-services'),
        'itemListElement' => array_values(array_map(
            fn (array $card, int $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Service',
                    'name' => $card['title'],
                    'description' => $card['description'],
                    'areaServed' => ['@type' => 'Country', 'name' => 'Kenya'],
                    'provider' => ['@type' => 'Organization', 'name' => 'Peak Experience'],
                ],
            ],
            $pageContent['cards'] ?? [],
            array_keys($pageContent['cards'] ?? [])
        )),
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.page-transition-head')
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ route('our-services') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ route('our-services') }}">
    @if (count($workImages) > 0)
        <meta property="og:image" content="{{ $workImages[0] }}">
    @endif
    <script type="application/ld+json">{!! json_encode($serviceSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('story-home.css') }}">
    <style>
        @font-face{font-family:"GT Walsheim";src:url("https://www.storyevents.co.uk/wp-content/themes/primary-theme/assets/fonts/gt-walsheim/GT-Walsheim-Light.woff2") format("woff2");font-weight:300;font-style:normal;font-display:swap}
        @font-face{font-family:"GT Walsheim";src:url("https://www.storyevents.co.uk/wp-content/themes/primary-theme/assets/fonts/gt-walsheim/GT-Walsheim-Regular.woff2") format("woff2");font-weight:400;font-style:normal;font-display:swap}
        @font-face{font-family:"GT Walsheim";src:url("https://www.storyevents.co.uk/wp-content/themes/primary-theme/assets/fonts/gt-walsheim/GT-Walsheim-Medium.woff2") format("woff2");font-weight:500;font-style:normal;font-display:swap}
        .services-page{background:#fff;color:#686264;font-family:"GT Walsheim",Helvetica,Arial,sans-serif}
        .services-hero{padding:clamp(86px,10vw,150px) 0 clamp(72px,9vw,128px)}
        .services-hero .wrap{width:min(1280px,calc(100% - 140px))}
        .services-eyebrow{display:block;margin:0 0 34px;color:#7a7e81;font-size:18px;font-weight:500;letter-spacing:.02em;text-transform:uppercase}
        .services-hero h1{margin:0;color:#686264;font-size:clamp(52px,5.4vw,96px);font-weight:300;line-height:.92;letter-spacing:0;text-transform:uppercase}
        .services-hero p{max-width:980px;margin:34px 0 0;color:#686264;font-size:clamp(24px,1.85vw,34px);font-weight:300;line-height:1.32}
        .services-grid-section{padding:0 0 clamp(90px,10vw,150px)}
        .services-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:clamp(64px,6vw,92px) clamp(26px,2.7vw,44px)}
        .service-item{display:grid;grid-template-rows:auto 1fr;gap:28px;align-content:start}
        .service-item-media{overflow:hidden;border-radius:9px;aspect-ratio:1.5;background:linear-gradient(135deg,#10808f,#273243)}
        .service-item-media img{display:block;width:100%;height:100%;object-fit:cover}
        .service-item-copy{display:grid;align-content:start;gap:18px}
        .service-item h2{margin:0;color:#686264;font-size:clamp(25px,2.1vw,36px);font-weight:500;line-height:1.05;text-transform:uppercase}
        .service-item p{margin:0;color:#686264;font-size:clamp(18px,1.25vw,23px);font-weight:300;line-height:1.48}
        .services-cta{padding:0 clamp(16px,2.1vw,38px) clamp(80px,9vw,136px)}
        .services-cta-card{position:relative;overflow:hidden;min-height:clamp(520px,63vw,760px);border-radius:22px;background:#17252c;color:#fff}
        .services-cta-media,.services-cta-overlay{position:absolute;inset:0}
        .services-cta-media img{width:100%;height:100%;object-fit:cover}
        .services-cta-overlay{background:linear-gradient(90deg,rgba(7,19,24,.86) 0%,rgba(7,19,24,.62) 48%,rgba(7,19,24,.2) 100%)}
        .services-cta-content{position:relative;z-index:1;display:flex;min-height:inherit;flex-direction:column;justify-content:center;width:min(1180px,calc(100% - 96px));margin:0 auto;padding:70px 0}
        .services-cta-content h2{max-width:850px;margin:0;color:#fff;font-size:clamp(48px,5.1vw,86px);font-weight:300;line-height:.98;text-transform:uppercase}
        .services-cta-content p{max-width:650px;margin:34px 0;color:#fff;font-size:clamp(22px,1.8vw,31px);font-weight:300;line-height:1.42}
        .services-cta-button{display:inline-flex;align-items:center;justify-content:space-between;width:272px;min-height:86px;border:0;border-radius:10px;padding:0 34px;background:#fff;color:#747678;font:600 16px/1 inherit;letter-spacing:.03em;text-decoration:none;text-transform:uppercase;cursor:pointer}
        .services-cta-button::after{content:"\2192";font-size:28px;font-weight:300}
        .services-cta-button:hover,.services-cta-button:focus-visible{background:#10808f;color:#fff}
        .enquiry-modal{inset:0 0 0 auto;width:min(720px,50vw);max-width:none;height:100dvh;max-height:none;margin:0;border:1px solid rgba(95,89,91,.22);border-right-color:rgba(95,89,91,.12);border-radius:22px 0 0 22px;padding:0;background:#fff;color:#5f595b;overflow:hidden;box-shadow:-18px 0 55px rgba(0,0,0,.14),inset 0 0 0 1px rgba(255,255,255,.7);transform:translateX(100%);transition:transform .6s cubic-bezier(.83,0,.17,1)}
        .enquiry-modal.is-visible{transform:translateX(0)}
        .enquiry-modal::backdrop{background:rgba(255,255,255,.72);backdrop-filter:blur(2px)}
        .enquiry-card{position:relative;width:100%;height:100%;margin:0;border:0;border-radius:21px 0 0 21px;padding:clamp(28px,3.4vw,48px);background:#fff;overflow-y:auto}
        .enquiry-close{position:absolute;top:24px;right:24px;display:grid;width:48px;height:48px;border:0;border-radius:50%;place-items:center;background:#edf0f1;color:#5f595b;font:300 38px/1 Arial,sans-serif;cursor:pointer}
        .enquiry-close:hover,.enquiry-close:focus-visible{background:#10808f;color:#fff;outline:0}
        .enquiry-header{display:flex;justify-content:space-between;gap:32px;margin-bottom:28px;padding-right:48px}
        .enquiry-header h2{margin:0 0 8px;color:#5f595b;font-size:clamp(34px,3vw,48px);font-weight:400;line-height:1}
        .enquiry-header p{margin:0;color:#6a6365;font-size:16px;line-height:1.5}
        .enquiry-header a{color:inherit}
        .form-alert{margin:0 0 28px;border-radius:8px;padding:16px 18px;font-size:16px}
        .form-alert--success{background:#e4f4ee;color:#175c48}.form-alert--error{background:#fff0ed;color:#8a2f24}
        .enquiry-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
        .enquiry-field{display:grid;gap:8px}.enquiry-field--full{grid-column:1/-1}
        .enquiry-field label{color:#767a7d;font-size:15px;font-weight:600;letter-spacing:.03em;text-transform:uppercase}
        .enquiry-field input,.enquiry-field select,.enquiry-field textarea{width:100%;border:1px solid #d8dcde;border-radius:10px;padding:0 18px;background:#fff;color:#4f4a4c;font:18px/1.3 inherit}
        .enquiry-field input,.enquiry-field select{height:48px}.enquiry-field textarea{min-height:112px;padding-top:14px;resize:vertical}
        .enquiry-field input:focus,.enquiry-field select:focus,.enquiry-field textarea:focus{border-color:#10808f;outline:3px solid rgba(16,128,143,.14)}
        .enquiry-field .is-invalid{border-color:#b84f42}.field-error{margin:0;color:#a33d32;font-size:14px}
        .enquiry-consent{margin:20px 0}.enquiry-consent label{display:flex;align-items:flex-start;gap:13px;color:#686264;font-size:15px;line-height:1.5}
        .enquiry-consent input{flex:0 0 auto;width:22px;height:22px;margin-top:2px;accent-color:#10808f}
        .enquiry-submit{min-width:226px;min-height:66px;border:0;border-radius:9px;padding:0 30px;background:#10808f;color:#fff;text-transform:uppercase;font:600 15px/1 inherit;letter-spacing:.05em;cursor:pointer}
        .enquiry-submit:hover,.enquiry-submit:focus-visible{background:#273243}
        .services-page .se-footer-brand{background:#10808f;color:#fff}
        .site-nav a[aria-current="page"]{background:rgba(32,38,51,.06);border-radius:8px}
        @media(max-width:980px){.services-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.services-hero .wrap{width:min(1180px,calc(100% - 48px))}.services-cta-content{width:calc(100% - 64px)}}
        @media(max-width:760px){.services-hero{padding:64px 0 58px}.services-hero .wrap{width:min(1180px,calc(100% - 32px))}.services-hero h1{font-size:48px}.services-hero p{font-size:22px}.services-grid{grid-template-columns:1fr;gap:58px}.service-item h2{font-size:32px}.service-item p{font-size:20px}.service-item-media{border-radius:9px;aspect-ratio:1.35}.services-cta{padding-left:12px;padding-right:12px}.services-cta-card{min-height:600px;border-radius:14px}.services-cta-content{width:calc(100% - 40px);padding:54px 0}.services-cta-content h2{font-size:42px}.services-cta-button{width:100%}.enquiry-modal{width:100%;border-radius:0}.enquiry-card{border-radius:0;padding:72px 20px 28px}.enquiry-close{top:14px;right:14px}.enquiry-form-grid{grid-template-columns:1fr}.enquiry-field--full{grid-column:auto}.enquiry-header{display:block;padding-right:36px}.enquiry-header h2{font-size:40px}}
    </style>
</head>
<body id="top">
    @include('partials.page-transition')
    <div class="page-shell services-page">
        <header class="site-header">
            <div class="wrap header-row">
                <a class="brand" href="{{ route('home') }}" aria-label="Peak Experience home">
                    @if ($hasLogo)
                        <img class="brand-logo" src="{{ $logoUrl }}" alt="Peak Experience">
                    @else
                        <span class="brand-copy">
                            <strong>Peak Experience</strong>
                            <span class="brand-dots" aria-hidden="true"><i></i><i></i><i></i></span>
                        </span>
                    @endif
                </a>

                <nav class="site-nav" aria-label="Primary">
                    <ul>
                        <li><a class="nav-link--home" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item--dropdown">
                            <a class="nav-link--caret" href="{{ route('home') }}#services">What We Do</a>
                            <ul class="nav-dropdown" aria-label="What We Do pages">
                                @foreach ($navPages as $navPage)
                                    <li><a href="{{ route('pages.show', ['page' => $navPage['slug']]) }}">{{ $navPage['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('our-work') }}">Our Work</a></li>
                        <li><a href="{{ route('our-services') }}" aria-current="page">Our Services</a></li>
                        <li class="nav-item--dropdown">
                            <a class="nav-link--caret" href="{{ route('home') }}#intro">About Us</a>
                            <ul class="nav-dropdown" aria-label="About Us pages">
                                @foreach ($aboutPages as $aboutPage)
                                    <li><a href="{{ route('pages.show', ['page' => $aboutPage['slug']]) }}">{{ $aboutPage['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </nav>

                <div class="header-utility">
                    <button class="button button-nav-cta" type="button" data-enquiry-open>Contact Us</button>
                </div>

                <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" data-nav-toggle>
                    <span class="nav-toggle-box" aria-hidden="true"><span></span><span></span><span></span></span>
                </button>
            </div>

            <div class="wrap">
                <div class="nav-panel" id="mobile-nav" data-nav-panel>
                    <nav aria-label="Mobile">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <a href="{{ route('home') }}#services">What We Do</a>
                                <ul class="nav-mobile-children" aria-label="What We Do pages">
                                    @foreach ($navPages as $navPage)
                                        <li><a href="{{ route('pages.show', ['page' => $navPage['slug']]) }}">{{ $navPage['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('our-work') }}">Our Work</a></li>
                            <li><a href="{{ route('our-services') }}" aria-current="page">Our Services</a></li>
                            <li>
                                <a href="{{ route('home') }}#intro">About Us</a>
                                <ul class="nav-mobile-children" aria-label="About Us pages">
                                    @foreach ($aboutPages as $aboutPage)
                                        <li><a href="{{ route('pages.show', ['page' => $aboutPage['slug']]) }}">{{ $aboutPage['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="#event-enquiry-dialog" data-enquiry-open>Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <section class="services-hero">
                <div class="wrap">
                    <span class="services-eyebrow">{{ $pageContent['eyebrow'] }}</span>
                    <h1>{{ $pageContent['title'] }}</h1>
                    <p>{{ $pageContent['description'] }}</p>
                </div>
            </section>

            <section class="services-grid-section" aria-label="Services">
                <div class="wrap">
                    <div class="services-grid">
                        @foreach ($pageContent['cards'] as $index => $card)
                            @php
                                $cardImage = trim((string) ($card['image'] ?? ''));
                                $imageUrl = str_starts_with($cardImage, 'images/')
                                    ? asset($cardImage)
                                    : \App\Support\HomepageContent::assetUrl($cardImage);
                                if ($imageUrl === '' && count($workImages) > 0) {
                                    $imageUrl = $workImages[$index % count($workImages)];
                                }
                            @endphp
                            <article class="service-item">
                                <figure class="service-item-media">
                                    @if ($imageUrl !== '')
                                        <img src="{{ $imageUrl }}" alt="{{ $card['image_alt'] !== '' ? $card['image_alt'] : $card['title'] }}">
                                    @endif
                                </figure>
                                <div class="service-item-copy">
                                    <h2>{{ $card['title'] }}</h2>
                                    <p>{{ $card['description'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="services-cta" aria-labelledby="services-cta-title">
                <div class="services-cta-card">
                    @if ($ctaImage !== '')
                        <div class="services-cta-media" aria-hidden="true">
                            <img src="{{ $ctaImage }}" alt="">
                        </div>
                    @endif
                    <div class="services-cta-overlay" aria-hidden="true"></div>
                    <div class="services-cta-content">
                        <h2 id="services-cta-title">Explore Our Services</h2>
                        <p>Tell us what you are planning and where you need support. We will shape the production, design, logistics, streaming, and branding around your event.</p>
                        <button class="services-cta-button" type="button" data-enquiry-open>Enquire Now</button>
                    </div>
                </div>
            </section>

            <dialog class="enquiry-modal" id="event-enquiry-dialog" aria-labelledby="event-enquiry-title">
                <div class="enquiry-card">
                    <button class="enquiry-close" type="button" data-enquiry-close aria-label="Close event enquiry form">&times;</button>
                    <header class="enquiry-header">
                        <div>
                            <h2 id="event-enquiry-title">Event Enquiry</h2>
                            <p>Alternatively, email <a href="mailto:info@peakexperience.co.ke">info@peakexperience.co.ke</a>.</p>
                        </div>
                    </header>

                    @if (session('contact_status'))
                        <div class="form-alert form-alert--success">{{ session('contact_status') }}</div>
                    @endif

                    @if (session('contact_error'))
                        <div class="form-alert form-alert--error">{{ session('contact_error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="form-alert form-alert--error">Please review the highlighted fields and submit the enquiry again.</div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                        @csrf
                        <input type="hidden" name="source" value="services">

                        <div class="enquiry-form-grid">
                            <div class="enquiry-field">
                                <label for="services-first-name">First Name *</label>
                                <input id="services-first-name" class="@error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required>
                                @error('first_name')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-last-name">Last Name *</label>
                                <input id="services-last-name" class="@error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required>
                                @error('last_name')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-company">Company *</label>
                                <input id="services-company" class="@error('organization') is-invalid @enderror" type="text" name="organization" value="{{ old('organization') }}" autocomplete="organization" required>
                                @error('organization')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-phone">Phone Number *</label>
                                <input id="services-phone" class="@error('phone') is-invalid @enderror" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
                                @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-email">Email *</label>
                                <input id="services-email" class="@error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                                @error('email')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-date">Date of Event *</label>
                                <input id="services-date" class="@error('date_of_event') is-invalid @enderror" type="date" name="date_of_event" value="{{ old('date_of_event') }}" required>
                                @error('date_of_event')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-guests">Number of Guests</label>
                                <input id="services-guests" class="@error('guest_count') is-invalid @enderror" type="text" name="guest_count" value="{{ old('guest_count') }}" inputmode="numeric">
                                @error('guest_count')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-event-type">Type of Event *</label>
                                <select id="services-event-type" class="@error('event_type') is-invalid @enderror" name="event_type" required>
                                    <option value="">Please select</option>
                                    @foreach ($eventTypeOptions as $option)
                                        <option value="{{ $option }}" @selected(old('event_type') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('event_type')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-budget">Budget (KES) *</label>
                                <input id="services-budget" class="@error('budget') is-invalid @enderror" type="text" name="budget" value="{{ old('budget') }}" inputmode="decimal" required>
                                @error('budget')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field">
                                <label for="services-referral">How Did You Hear About Us?</label>
                                <select id="services-referral" class="@error('referral_source') is-invalid @enderror" name="referral_source">
                                    <option value="">Please select</option>
                                    @foreach ($referralOptions as $option)
                                        <option value="{{ $option }}" @selected(old('referral_source') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('referral_source')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field enquiry-field--full">
                                <label for="services-venue">Venue / Location *</label>
                                <input id="services-venue" class="@error('venue') is-invalid @enderror" type="text" name="venue" value="{{ old('venue') }}" required>
                                @error('venue')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="enquiry-field enquiry-field--full">
                                <label for="services-additional-info">Additional Info</label>
                                <textarea id="services-additional-info" class="@error('additional_info') is-invalid @enderror" name="additional_info">{{ old('additional_info') }}</textarea>
                                @error('additional_info')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="enquiry-consent">
                            <label>
                                <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                                <span>I agree to be contacted by Peak Experience about this enquiry and understand that my details will be used to prepare a response.</span>
                            </label>
                            @error('consent')<p class="field-error">{{ $message }}</p>@enderror
                        </div>

                        <button class="enquiry-submit" type="submit">Submit</button>
                    </form>
                </div>
            </dialog>
        </main>

        <footer class="se-footer-brand block block--colored">
            <div class="se-block-padding">
                <div class="se-footer-inner">
                    <div class="se-footer-logo">
                        @if ($hasLogo)
                            <img src="{{ $logoUrl }}" alt="Peak Experience logo">
                        @else
                            <strong>Peak Experience</strong>
                        @endif
                    </div>

                    <nav class="se-footer-social" aria-label="Social links">
                        @foreach ($socialLinks as $socialLink)
                            <a href="{{ $socialLink['url'] }}" target="_blank" rel="noreferrer">{{ $socialLink['label'] }}</a>
                        @endforeach
                        @if ($hasWhatsapp)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer">WhatsApp</a>
                        @endif
                    </nav>

                    <div class="se-footer-contact">
                        @if ($hasContactEmail)
                            <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                        @endif
                        @foreach ($contactPhones as $phone)
                            <a href="tel:{{ $phone['dial'] }}">{{ $phone['display'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </footer>

        <footer class="se-footer-group block block--light">
            <div class="se-block-padding">
                <div class="se-footer-columns">
                    <div>
                        <h3>What We Do</h3>
                        <a href="{{ route('home') }}#services">Event Production</a>
                        <a href="{{ route('home') }}#services">Audio Systems</a>
                        <a href="{{ route('home') }}#services">Media</a>
                    </div>
                    <div>
                        <h3>Company</h3>
                        <a href="{{ route('home') }}#intro">About Us</a>
                        <a href="{{ route('our-work') }}">Our Work</a>
                        <a href="{{ route('home') }}#contact">Contact</a>
                    </div>
                    <div>
                        <h3>Enquiries</h3>
                        <a href="{{ route('home') }}#contact">Start a Brief</a>
                        @if ($hasContactEmail)
                            <a href="mailto:{{ $contactEmail }}">Email Us</a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @if ($hasWhatsapp)
        <div class="whatsapp-widget" aria-label="WhatsApp chat widget">
            <span class="whatsapp-widget-label">WhatsApp Peak Experience</span>
            <a class="whatsapp-widget-button" href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" aria-label="Chat with Peak Experience on WhatsApp">
                <svg class="whatsapp-widget-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M19.11 17.36c-.26-.13-1.53-.76-1.77-.85-.24-.09-.41-.13-.58.13-.17.26-.67.85-.82 1.02-.15.17-.3.2-.56.07-.26-.13-1.09-.4-2.08-1.27-.77-.68-1.29-1.51-1.44-1.77-.15-.26-.02-.4.11-.53.12-.12.26-.3.39-.45.13-.15.17-.26.26-.43.09-.17.04-.33-.02-.46-.07-.13-.58-1.4-.8-1.92-.21-.5-.42-.43-.58-.44h-.5c-.17 0-.45.07-.69.33-.24.26-.91.89-.91 2.16 0 1.27.93 2.5 1.06 2.67.13.17 1.83 2.79 4.43 3.92.62.27 1.11.43 1.49.55.63.2 1.21.17 1.66.1.51-.08 1.53-.63 1.75-1.24.22-.61.22-1.13.15-1.24-.07-.11-.24-.17-.5-.3Z"/>
                    <path fill="currentColor" d="M27.29 15.22c0 6.23-5.06 11.29-11.29 11.29-1.98 0-3.92-.52-5.63-1.5L4.71 26.5l1.53-5.49a11.2 11.2 0 0 1-1.53-5.79C4.71 9 9.77 3.94 16 3.94s11.29 5.06 11.29 11.28Zm-11.29-9.39c-5.18 0-9.39 4.21-9.39 9.39 0 1.82.52 3.59 1.5 5.11l.21.32-.91 3.25 3.33-.88.31.18a9.36 9.36 0 0 0 4.95 1.41c5.18 0 9.39-4.21 9.39-9.39 0-5.18-4.21-9.39-9.39-9.39Z"/>
                </svg>
            </a>
        </div>
    @endif

    <script src="{{ asset('story-home.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const dialog = document.getElementById('event-enquiry-dialog');
            let closeTimer;
            const openDialog = () => {
                if (dialog && !dialog.open) {
                    window.clearTimeout(closeTimer);
                    dialog.showModal();
                    window.requestAnimationFrame(() => {
                        window.requestAnimationFrame(() => dialog.classList.add('is-visible'));
                    });
                }
            };
            const closeDialog = () => {
                if (!dialog?.open) {
                    return;
                }

                dialog.classList.remove('is-visible');
                closeTimer = window.setTimeout(() => dialog.close(), 600);
            };

            document.querySelectorAll('[data-enquiry-open]').forEach((button) => {
                button.addEventListener('click', openDialog);
            });

            dialog?.querySelector('[data-enquiry-close]')?.addEventListener('click', closeDialog);
            dialog?.addEventListener('click', (event) => {
                if (event.target === dialog) {
                    closeDialog();
                }
            });
            dialog?.addEventListener('cancel', (event) => {
                event.preventDefault();
                closeDialog();
            });

            if (window.location.hash === '#event-enquiry-dialog') {
                openDialog();
            }

            @if ($errors->any() || session('contact_status') || session('contact_error'))
                openDialog();
            @endif
        });
    </script>
</body>
</html>
