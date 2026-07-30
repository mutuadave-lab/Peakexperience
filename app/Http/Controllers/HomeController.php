<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryMail;
use App\Support\AboutPageContent;
use App\Support\CaseStudyContent;
use App\Support\HomepageContent;
use App\Support\PageContent;
use App\Support\PublicPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class HomeController extends Controller
{
    public function index(): View
    {
        $content = HomepageContent::load();

        return view('home', [
            'logo' => $content['logo'],
            'sectionImages' => $content['section_images'],
            'heroVideo' => $content['hero_video'],
            'whatWeDo' => HomepageContent::services($content['what_we_do']),
            'ourProcess' => $content['our_process'],
            'navPages' => PageContent::load(),
        ] + $this->contactData($content));
    }

    public function service(string $service): View
    {
        $content = HomepageContent::load();
        $services = HomepageContent::services($content['what_we_do']);

        $serviceItem = null;
        foreach ($services as $item) {
            if (($item['slug'] ?? '') === $service) {
                $serviceItem = $item;
                break;
            }
        }

        abort_unless(is_array($serviceItem), 404);

        return view('service', [
            'logo' => $content['logo'],
            'service' => $serviceItem,
            'navPages' => PageContent::load(),
        ] + $this->contactData($content));
    }

    public function ourWork(): View
    {
        $content = HomepageContent::load();

        return view('our-work', [
            'logo' => $content['logo'],
            'posts' => PageContent::posts(),
            'pageContent' => PublicPageContent::ourWork(),
            'navPages' => PageContent::load(),
        ] + $this->contactData($content));
    }

    public function ourServices(): View
    {
        $content = HomepageContent::load();

        return view('our-services', [
            'logo' => $content['logo'],
            'pageContent' => PublicPageContent::services(),
            'workImages' => $this->serviceWorkImages($content),
            'navPages' => PageContent::load(),
        ] + $this->contactData($content));
    }

    public function page(string $page): View
    {
        $content = HomepageContent::load();
        $pageItem = AboutPageContent::findBySlug($page) ?? PageContent::findBySlug($page);

        abort_unless(is_array($pageItem), 404);

        return view('page', [
            'logo' => $content['logo'],
            'sectionImages' => $content['section_images'],
            'page' => $pageItem,
            'navPages' => PageContent::load(),
        ] + $this->contactData($content));
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'organization' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'date_of_event' => ['required', 'date'],
            'venue' => ['required', 'string', 'max:180'],
            'guest_count' => ['nullable', 'string', 'max:80'],
            'event_type' => ['required', 'string', 'max:120'],
            'budget' => [$request->input('source') === 'services' ? 'required' : 'nullable', 'string', 'max:120'],
            'referral_source' => ['nullable', 'string', 'max:120'],
            'additional_info' => ['nullable', 'string', 'max:3000'],
            'consent' => ['accepted'],
            'source' => ['nullable', 'in:home,services'],
        ], [
            'first_name.required' => 'Please enter the client first name.',
            'last_name.required' => 'Please enter the client last name.',
            'organization.required' => 'Please enter your organization name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'date_of_event.required' => 'Please enter the event date.',
            'venue.required' => 'Please enter the venue or location.',
            'event_type.required' => 'Please select the event type.',
            'budget.required' => 'Please enter an estimated budget.',
            'consent.accepted' => 'Please confirm that we may contact you about this enquiry.',
        ], [
            'date_of_event' => 'event date',
            'guest_count' => 'number of guests',
            'event_type' => 'event type',
            'referral_source' => 'how you heard about us',
            'additional_info' => 'additional information',
        ]);

        $enquiry = [
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'organization' => $validated['organization'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'date_of_event' => $validated['date_of_event'],
            'venue' => $validated['venue'],
            'guest_count' => trim((string) ($validated['guest_count'] ?? '')),
            'event_type' => $validated['event_type'],
            'budget' => trim((string) ($validated['budget'] ?? '')),
            'referral_source' => trim((string) ($validated['referral_source'] ?? '')),
            'additional_info' => trim((string) ($validated['additional_info'] ?? '')),
        ];

        $contactEmail = (string) data_get($this->contactData(), 'contactEmail', '');
        $returnUrl = ($validated['source'] ?? '') === 'services'
            ? route('our-services') . '#event-enquiry-dialog'
            : url('/#contact');

        try {
            Mail::mailer((string) config('mail.contact_mailer', 'sendmail'))
                ->to($contactEmail)
                ->send(new ContactInquiryMail($enquiry));
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->to($returnUrl)
                ->withInput()
                ->with('contact_error', 'We could not send your enquiry right now. Please call or email us directly.');
        }

        return redirect()
            ->to($returnUrl)
            ->with('contact_status', 'Thank you. Your enquiry has been sent to Peak Experience.');
    }

    /**
     * Build a reusable image pool from work already uploaded through the admin.
     *
     * @return array<int, string>
     */
    private function serviceWorkImages(array $content): array
    {
        $images = [];
        $postGalleries = [];

        foreach (PageContent::posts() as $post) {
            $images[] = (string) ($post['image'] ?? '');
            $postGalleries[] = is_array($post['gallery_images'] ?? null) ? $post['gallery_images'] : [];
        }

        foreach (CaseStudyContent::published() as $caseStudy) {
            $images[] = (string) ($caseStudy['image'] ?? '');
        }

        foreach ($content['what_we_do'] ?? [] as $service) {
            $images[] = (string) ($service['image'] ?? '');
        }

        foreach ($content['section_images'] ?? [] as $sectionImage) {
            if (is_array($sectionImage)) {
                $images[] = (string) ($sectionImage['path'] ?? '');
            }
        }

        $maxGalleryImages = max(array_map('count', $postGalleries) ?: [0]);
        for ($imageIndex = 0; $imageIndex < $maxGalleryImages; $imageIndex++) {
            foreach ($postGalleries as $gallery) {
                if (isset($gallery[$imageIndex])) {
                    $images[] = (string) $gallery[$imageIndex];
                }
            }
        }

        return array_values(array_unique(array_filter(array_map(
            fn ($image): string => trim((string) $image),
            $images
        ))));
    }

    public function asset(string $path): BinaryFileResponse
    {
        $path = HomepageContent::storedPath($path);
        abort_unless($path !== '' && str_starts_with($path, 'homepage/'), 404);
        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path));
    }

    /**
     * @return array{
     *   contactEmail: string,
     *   contactPhones: array<int, array{display:string,dial:string}>,
     *   socialLinks: array<int, array{label:string,url:string}>,
     *   whatsappPhone: string,
     *   whatsappUrl: string,
     *   paymentUrl: string,
     *   paymentLabel: string
     * }
     */
    private function contactData(?array $content = null): array
    {
        $content ??= HomepageContent::load();
        $contactPhones = [
            ['display' => '+254 119857961', 'dial' => '+254119857961'],
            ['display' => '+254 792243400', 'dial' => '+254792243400'],
        ];
        $whatsappPhone = trim((string) data_get($content, 'contact.whatsapp_phone', ''));
        if ($whatsappPhone === '') {
            $whatsappPhone = (string) data_get($contactPhones, '0.dial', '+254119857961');
        }

        return [
            'contactEmail' => 'info@peakexperience.co.ke',
            'contactPhones' => $contactPhones,
            'socialLinks' => [
                ['label' => 'TikTok', 'url' => 'https://www.tiktok.com/@peak_audio_systems'],
                ['label' => 'Instagram', 'url' => 'https://www.instagram.com/peak_audio_systems/'],
                ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/peak-audio/'],
            ],
            'whatsappPhone' => $whatsappPhone,
            'whatsappUrl' => HomepageContent::whatsappUrl(
                $whatsappPhone,
                'Hello Peak Experience, I would like to enquire about your event services.'
            ),
            'paymentUrl' => trim((string) config('services.payment.url', '')),
            'paymentLabel' => trim((string) config('services.payment.label', 'Make Payment')),
        ];
    }
}
