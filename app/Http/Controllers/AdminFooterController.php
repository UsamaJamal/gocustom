<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFooterController extends Controller
{
    private function getSettingsPath(): string
    {
        return storage_path('app/site-settings.json');
    }

    public function getSettings(): array
    {
        $defaults = [
            'company_email' => 'support@gocustomboxes.com',
            'company_phone' => '1-773-945-5230',
            'company_address' => '4000 N Montrose Ave<br>550 Chicago, IL 60641',
            'footer_categories' => [],
            'footer_products' => [],
            'footer_quick_links' => [],
            'footer_policy_pages' => [],
            'footer_description' => 'The Rigid Boxes is a leading custom packaging manufacturer, delivering premium boxes and packaging solutions tailored to your brand. From design to delivery, we ensure unmatched quality, style, and customer service.',
            'social_facebook' => 'https://www.facebook.com/premiumboxesusa',
            'social_twitter' => '',
            'social_instagram' => 'https://www.instagram.com/premiumboxes.usa/',
            'social_pinterest' => 'https://www.pinterest.com/premiumboxesusa/',
            'social_linkedin' => 'https://www.linkedin.com/company/premium-boxes-usa/',
            'social_youtube' => ''
        ];

        // Start with the local backup, then let database values take priority.
        // This also keeps a complete footer available when an older database
        // contains only part of the footer settings.
        $settings = [];
        $path = $this->getSettingsPath();
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                $settings = $data;
            }
        }

        try {
            $rows = DB::table('homepage_contents')
                ->whereIn('section', ['footer', 'company_info', 'social_links'])
                ->get();
                
            if ($rows->count() > 0) {
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
                return array_merge($defaults, $settings);
            }
        } catch (\Exception $e) {
            // The backup loaded above is used when the database is unavailable.
        }

        return array_merge($defaults, $settings);
    }

    public function edit()
    {
        $settings = $this->getSettings();
        $categories = DB::table('admin_categories')->get()->map(fn($r) => (array)$r)->all();
        $pages = DB::table('admin_pages')->where('status', 'published')->orderBy('title')->get()->map(fn($r) => (array)$r)->all();
        $products = DB::table('admin_products')->where('status', 'published')->orderBy('title')->get()->map(fn($r) => (array)$r)->all();
        
        return view('admin.footer_settings', compact('settings', 'categories', 'pages', 'products'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:100',
            'company_address' => 'nullable|string',
            'footer_categories' => 'nullable|array',
            'footer_products' => 'nullable|array',
            'footer_policy_pages' => 'nullable|array',
            'footer_description' => 'nullable|string|max:2000',
            'footer_quick_links_names' => 'nullable|array',
            'footer_quick_links_urls' => 'nullable|array',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_pinterest' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        $settings = $this->getSettings();

        $settings['company_email'] = $request->input('company_email');
        $settings['company_phone'] = $request->input('company_phone');
        $settings['company_address'] = $request->input('company_address');
        $settings['social_facebook'] = $request->input('social_facebook');
        $settings['social_twitter'] = $request->input('social_twitter');
        $settings['social_instagram'] = $request->input('social_instagram');
        $settings['social_pinterest'] = $request->input('social_pinterest');
        $settings['social_linkedin'] = $request->input('social_linkedin');
        $settings['social_youtube'] = $request->input('social_youtube');
        $settings['footer_categories'] = array_values(array_map('intval', (array) $request->input('footer_categories', [])));
        $settings['footer_products'] = array_values(array_map('intval', (array) $request->input('footer_products', [])));
        $settings['footer_policy_pages'] = array_values(array_map('intval', (array) $request->input('footer_policy_pages', [])));
        $settings['footer_description'] = $request->input('footer_description');

        $quickLinks = [];
        $names = (array) $request->input('footer_quick_links_names', []);
        $urls = (array) $request->input('footer_quick_links_urls', []);

        foreach ($names as $i => $name) {
            if (!empty(trim($name))) {
                $quickLinks[] = [
                    'name' => trim($name),
                    'url' => trim($urls[$i] ?? '#')
                ];
            }
        }
        $settings['footer_quick_links'] = $quickLinks;

        foreach ($settings as $key => $value) {
            $valueType = 'text';
            $section = 'company_info';

            if (in_array($key, ['footer_categories', 'footer_products', 'footer_quick_links', 'footer_policy_pages'])) {
                $section = 'footer';
                $valueType = 'json';
                $value = json_encode($value);
            } elseif ($key === 'footer_description') {
                $section = 'footer';
            } elseif (str_starts_with($key, 'social_')) {
                $section = 'social_links';
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

        file_put_contents($this->getSettingsPath(), json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('admin.footer.edit')->with('success', 'Footer & Company settings updated successfully.');
    }
}
