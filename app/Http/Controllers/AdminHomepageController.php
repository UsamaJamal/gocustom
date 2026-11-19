<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminHomepageController extends Controller
{
    private function getSettingsPath(): string
    {
        return storage_path('app/homepage-settings.json');
    }

    public function loadSettings(): array
    {
        $defaults = [
            'meta_title' => 'Custom Printed Boxes & Packaging - Go-Custom-boxes',
            'meta_description' => 'Custom printed rigid packaging boxes at wholesale rates. Premium luxury boxes for retail, cosmetic, and gift packaging.',
            'meta_keywords' => '',
            'robots' => 'index,follow',
            'schema' => '',
            'hero_title' => 'Custom Printed Boxes & Packaging Manufacturer',
            'hero_description' => 'Get premium custom rigid boxes and packaging solutions designed for your brand.',
            'hero_image' => '',
            'popular_meta_title' => 'Popular Custom Packaging Products | Go Custom Boxes',
            'popular_meta_description' => 'Explore our popular custom packaging products and find the right box for your brand.',
            'popular_meta_keywords' => '',
            'popular_hero_title' => 'Popular Custom Packaging Products',
            'popular_hero_description' => 'Browse the packaging products selected by our team for their quality, presentation, and versatile custom options.',
            'popular_hero_image' => '',
            'popular_hero_primary_button_text' => 'Get Instant Quote',
            'popular_hero_primary_button_url' => '/request-quote/',
            'popular_content_section' => '',
            'popular_faqs' => [],
            'featured_categories' => [],
            'bestseller_products' => [],
            'content_section' => '<h2>Why Choose Go-Custom-boxes</h2><p>We craft high quality luxury packaging for all industries.</p>',
            'faqs' => [
                ['question' => 'What is the Minimum Order Quantity (MOQ)?', 'answer' => 'Our minimum order quantity starts from 100 units.'],
                ['question' => 'Do you provide free design support?', 'answer' => 'Yes, our expert design team provides 100% free design support.']
            ]
        ];

        // Homepage settings must never load footer/company/social settings.
        // Keeping the two sets separate prevents a homepage save from moving
        // footer records into the wrong section.
        try {
            $rows = DB::table('homepage_contents')
                ->whereIn('section', ['general', 'seo', 'hero', 'list', 'content'])
                ->whereIn('field_key', array_keys($defaults))
                ->get();
            if ($rows->count() > 0) {
                $settings = [];
                foreach ($rows as $row) {
                    $key = $row->field_key;
                    $val = $row->value;
                    $type = $row->value_type;

                    if ($type === 'json' || $type === 'array') {
                        $settings[$key] = json_decode($val, true) ?: [];
                    } else {
                        $settings[$key] = $val;
                    }
                }
                return $this->fixPopularHeroPath(array_merge($defaults, $settings));
            }
        } catch (\Exception $e) {
            // Fallback if table query fails
        }

        // 2. Fallback to storage file if DB is empty
        $path = $this->getSettingsPath();
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                return $this->fixPopularHeroPath(array_merge($defaults, array_intersect_key($data, $defaults)));
            }
        }

        return $defaults;
    }

    /**
     * Banners uploaded before the Popular Products fix sit in public/storage/uploads while their
     * saved path says "uploads/...", so the page couldn't find them. Point such a path at the
     * file's real place; the next save from the admin stores the corrected path.
     */
    private function fixPopularHeroPath(array $settings): array
    {
        $image = ltrim((string) ($settings['popular_hero_image'] ?? ''), '/');
        if (\Illuminate\Support\Str::startsWith($image, 'uploads/')
            && !is_file(public_path($image))
            && is_file(public_path('storage/' . $image))) {
            $settings['popular_hero_image'] = 'storage/' . $image;
        }

        return $settings;
    }

    public function edit()
    {
        $settings = $this->loadSettings();
        $categories = DB::table('admin_categories')->get()->map(fn($r) => (array)$r)->all();
        $products = DB::table('admin_products')->get()->map(fn($r) => (array)$r)->all();

        return view('admin.homepage_settings', compact('settings', 'categories', 'products'));
    }

    public function update(Request $request)
    {
        $schemaInput = trim((string) $request->input('schema', ''));
        $request->merge(['schema' => $schemaInput !== '' ? $schemaInput : null]);

        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'robots' => ['required', Rule::in(['index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow'])],
            // Accept both raw JSON-LD and a complete <script type="application/ld+json"> block.
            'schema' => 'nullable|string|max:50000',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:300',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'popular_meta_title' => 'nullable|string|max:255',
            'popular_meta_description' => 'nullable|string|max:1000',
            'popular_meta_keywords' => 'nullable|string|max:1000',
            'popular_hero_title' => 'nullable|string|max:255',
            'popular_hero_description' => 'nullable|string|max:300',
            'popular_hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'popular_hero_primary_button_text' => 'nullable|string|max:80',
            'popular_hero_primary_button_url' => 'nullable|string|max:255',
            'popular_faq_questions' => 'nullable|array',
            'popular_faq_answers' => 'nullable|array',
            'featured_categories' => 'nullable|array',
            'bestseller_products' => 'nullable|array',
            'content_section' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_answers' => 'nullable|array',
        ]);

        $settings = $this->loadSettings();

        $settings['meta_title'] = $request->input('meta_title');
        $settings['meta_description'] = $request->input('meta_description');
        $settings['meta_keywords'] = $request->input('meta_keywords');
        $settings['robots'] = $request->input('robots', 'index,follow');
        $settings['schema'] = $request->input('schema');
        $settings['hero_title'] = $request->input('hero_title');
        $settings['hero_description'] = $request->filled('hero_description') ? mb_substr(trim($request->input('hero_description')), 0, 300) : $request->input('hero_description');
        foreach (['popular_meta_title', 'popular_meta_description', 'popular_meta_keywords', 'popular_hero_title', 'popular_hero_description', 'popular_hero_primary_button_text', 'popular_hero_primary_button_url'] as $field) {
            if ($field === 'popular_hero_description' && $request->filled('popular_hero_description')) {
                $settings[$field] = mb_substr(trim($request->input($field)), 0, 300);
            } else {
                $settings[$field] = $request->input($field);
            }
        }

        if ($request->input('remove_hero_image') == '1') {
            $settings['hero_image'] = null;
        }
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $settings['hero_image'] = 'uploads/' . $fileName;
        }

        if ($request->input('remove_popular_hero_image') == '1') {
            $settings['popular_hero_image'] = null;
        }
        if ($request->hasFile('popular_hero_image')) {
            $file = $request->file('popular_hero_image');
            $fileName = 'popular-hero-' . \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $settings['popular_hero_image'] = 'uploads/' . $fileName;
        }

        $featuredCatIds = array_map('intval', (array) $request->input('featured_categories', []));
        $settings['featured_categories'] = $featuredCatIds;
        DB::table('admin_categories')->whereNotIn('id', $featuredCatIds)->update(['show_home' => 0]);
        if (!empty($featuredCatIds)) {
            DB::table('admin_categories')->whereIn('id', $featuredCatIds)->update(['show_home' => 1]);
        }
        $bestsellerProductIds = array_map('intval', (array) $request->input('bestseller_products', []));
        $settings['bestseller_products'] = $bestsellerProductIds;
        DB::table('admin_products')->whereNotIn('id', $bestsellerProductIds)->update(['show_home' => 0]);
        if (!empty($bestsellerProductIds)) {
            DB::table('admin_products')->whereIn('id', $bestsellerProductIds)->update(['show_home' => 1]);
        }
        $settings['content_section'] = $request->input('content_section');

        // Reconstruct FAQs array
        $faqs = [];
        $questions = (array) $request->input('faq_questions', []);
        $answers = (array) $request->input('faq_answers', []);

        foreach ($questions as $i => $q) {
            if (!empty(trim($q))) {
                $faqs[] = [
                    'question' => trim($q),
                    'answer' => trim($answers[$i] ?? '')
                ];
            }
        }
        $settings['faqs'] = $faqs;

        // Reconstruct Popular FAQs array
        $popularFaqs = [];
        $popularQuestions = (array) $request->input('popular_faq_questions', []);
        $popularAnswers = (array) $request->input('popular_faq_answers', []);

        foreach ($popularQuestions as $i => $q) {
            if (!empty(trim($q))) {
                $popularFaqs[] = [
                    'question' => trim($q),
                    'answer' => trim($popularAnswers[$i] ?? '')
                ];
            }
        }
        $settings['popular_faqs'] = $popularFaqs;

        // Save only homepage-specific fields. Footer settings are managed by
        // AdminFooterController and must remain untouched here.
        $homepageKeys = [
            'meta_title', 'meta_description', 'meta_keywords', 'robots', 'schema',
            'hero_title', 'hero_description', 'hero_image',
            'popular_meta_title', 'popular_meta_description', 'popular_meta_keywords',
            'popular_hero_title', 'popular_hero_description', 'popular_hero_image',
            'popular_hero_primary_button_text', 'popular_hero_primary_button_url',
            'popular_faqs',
            'featured_categories', 'bestseller_products', 'content_section', 'faqs',
        ];
        foreach ($settings as $key => $value) {
            if (!in_array($key, $homepageKeys, true)) {
                continue;
            }
            $valueType = 'text';
            $section = 'general';

            if (in_array($key, ['meta_title', 'meta_description', 'meta_keywords', 'robots', 'schema', 'popular_meta_title', 'popular_meta_description', 'popular_meta_keywords'])) {
                $section = 'seo';
            } elseif (in_array($key, ['hero_title', 'hero_description', 'hero_image', 'popular_hero_title', 'popular_hero_description', 'popular_hero_image', 'popular_hero_primary_button_text', 'popular_hero_primary_button_url'])) {
                $section = 'hero';
            } elseif (in_array($key, ['featured_categories', 'bestseller_products', 'faqs', 'popular_faqs'])) {
                $section = 'list';
                $valueType = 'json';
                $value = json_encode($value);
            } elseif ($key === 'content_section') {
                $section = 'content';
                $valueType = 'html';
            }

            DB::table('homepage_contents')->updateOrInsert(
                ['section' => $section, 'field_key' => $key],
                [
                    'section' => $section,
                    'value' => $value,
                    'value_type' => $valueType,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }

        // Also save to JSON file as backup
        file_put_contents($this->getSettingsPath(), json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('admin.homepage.edit')->with('success', 'Home Page Settings updated and saved to Database table successfully.');
    }
    public function popularProductsEdit()
    {
        $settings = $this->loadSettings();
        return view('admin.popular_products_settings', compact('settings'));
    }

    public function popularProductsUpdate(Request $request)
    {
        $settings = $this->loadSettings();

        // Validate
        $request->validate([
            'popular_meta_title' => 'nullable|string|max:255',
            'popular_meta_description' => 'nullable|string|max:1000',
            'popular_meta_keywords' => 'nullable|string|max:255',
            'popular_hero_title' => 'nullable|string|max:255',
            'popular_hero_description' => 'nullable|string|max:300',
            'popular_hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'popular_hero_primary_button_text' => 'nullable|string|max:80',
            'popular_hero_primary_button_url' => 'nullable|string|max:255',
            'popular_content_section' => 'nullable|string',
            'popular_faq_questions' => 'nullable|array',
            'popular_faq_answers' => 'nullable|array',
        ]);

        // Handle Image Removal. The file itself is kept: public/uploads is shared with other pages.
        if ($request->input('remove_popular_hero_image') == '1') {
            $settings['popular_hero_image'] = '';
        }

        // Handle Image Upload: into public/uploads, like the homepage banner, so the saved
        // "uploads/..." path is where the page looks for it. (It used to go to
        // public/storage/uploads, so the page never found it and showed the default banner.)
        if ($request->hasFile('popular_hero_image')) {
            $file = $request->file('popular_hero_image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            // Store directly without UUID
            $filename = $originalName . '.' . $extension;
            $file->move(public_path('uploads'), $filename);
            $settings['popular_hero_image'] = 'uploads/' . $filename;
        }

        // Text Fields
        foreach (['popular_meta_title', 'popular_meta_description', 'popular_meta_keywords', 'popular_hero_title', 'popular_hero_description', 'popular_hero_primary_button_text', 'popular_hero_primary_button_url', 'popular_content_section'] as $field) {
            if ($field === 'popular_hero_description' && $request->filled('popular_hero_description')) {
                $settings[$field] = mb_substr(trim($request->input($field)), 0, 300);
            } else {
                $settings[$field] = $request->input($field);
            }
        }

        // Reconstruct Popular FAQs array
        $popularFaqs = [];
        $popularQuestions = (array) $request->input('popular_faq_questions', []);
        $popularAnswers = (array) $request->input('popular_faq_answers', []);

        foreach ($popularQuestions as $i => $q) {
            if (!empty(trim($q))) {
                $popularFaqs[] = [
                    'question' => trim($q),
                    'answer' => trim($popularAnswers[$i] ?? '')
                ];
            }
        }
        $settings['popular_faqs'] = $popularFaqs;

        // Save popular settings to DB
        $popularKeys = [
            'popular_meta_title', 'popular_meta_description', 'popular_meta_keywords',
            'popular_hero_title', 'popular_hero_description', 'popular_hero_image',
            'popular_hero_primary_button_text', 'popular_hero_primary_button_url',
            'popular_content_section',
            'popular_faqs'
        ];
        foreach ($settings as $key => $value) {
            if (!in_array($key, $popularKeys)) continue;

            $section = 'seo';
            if (in_array($key, ['popular_hero_title', 'popular_hero_description', 'popular_hero_image', 'popular_hero_primary_button_text', 'popular_hero_primary_button_url'])) {
                $section = 'hero';
            } elseif ($key === 'popular_faqs') {
                $section = 'list';
            } elseif ($key === 'popular_content_section') {
                $section = 'content';
            }

            $valueType = is_array($value) ? 'json' : 'text';
            $dbValue = is_array($value) ? json_encode($value) : $value;

            DB::table('homepage_contents')->updateOrInsert(
                ['section' => $section, 'field_key' => $key],
                [
                    'section' => $section,
                    'value' => $dbValue ?? '',
                    'value_type' => $valueType,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }

        file_put_contents($this->getSettingsPath(), json_encode($settings, JSON_PRETTY_PRINT));
        return redirect()->route('admin.popularproducts.edit')->with('success', 'Popular Products Page Settings updated successfully!');
    }
}
