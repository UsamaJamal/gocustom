<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Add Laravel 9+ Blade directives (@selected, @checked, @disabled) for Laravel 8
        Blade::directive('selected', function ($condition) {
            return "<?php if ({$condition}): echo 'selected'; endif; ?>";
        });
        Blade::directive('checked', function ($condition) {
            return "<?php if ({$condition}): echo 'checked'; endif; ?>";
        });
        Blade::directive('disabled', function ($condition) {
            return "<?php if ({$condition}): echo 'disabled'; endif; ?>";
        });

        // Shared hosts sometimes point APP_URL at "/public". Keep generated
        // links, assets, canonicals and schemas on the clean domain instead.
        $configuredUrl = rtrim((string) config('app.url'), '/');
        $cleanUrl = preg_replace('#/public$#i', '', $configuredUrl);
        if ($cleanUrl && $cleanUrl !== $configuredUrl) {
            URL::forceRootUrl($cleanUrl);
        }

        // Share all categories with every view so the header nav dropdown works dynamically
        View::composer('*', function ($view) {
            try {
                $allCats = DB::table('admin_categories')
                    ->select('id', 'title', 'slug', 'parent_id', 'icon', 'image')
                    ->where('show_in_nav', 1)
                    // Draft/inactive categories stay out of the menu. Nav groups (Industries,
                    // Box By Material, Box by Style) have no page, so their status doesn't hide them.
                    ->where(function ($q) {
                        $q->where('status', 'published')->orWhere('is_nav_group', 1);
                    })
                    ->get()
                    ->map(fn($r) => (array) $r)
                    ->all();
                $view->with('navCategories', $allCats);

                // Load Global Settings for Header/Footer
                $defaults = [
                    'company_email' => 'example@gmail.com',
                    'company_phone' => '1800-315-8441',
                    'company_address' => '4000 N Montrose Ave<br>550 Chicago, IL 60641',
                    'footer_categories' => [],
                    'footer_products' => [],
                    'footer_quick_links' => [],
                    'footer_policy_pages' => [],
                    'footer_description' => 'Go Custom Boxes is a leading custom packaging manufacturer, delivering premium boxes and packaging solutions tailored to your brand. From design to delivery, we ensure unmatched quality, style, and customer service.'
                ];

                $settingsFile = storage_path('app/site-settings.json');
                if (file_exists($settingsFile)) {
                    $json = json_decode(file_get_contents($settingsFile), true);
                    if (is_array($json)) {
                        $defaults = array_merge($defaults, $json);
                    }
                }
                
                $rows = DB::table('homepage_contents')
                    ->whereIn('section', ['footer', 'company_info', 'social_links'])
                    ->get();
                    
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
                
                $siteSettings = array_merge($defaults, $settings);
                $view->with('siteSettings', $siteSettings);
            } catch (\Exception $e) {
                $view->with('navCategories', []);
                $view->with('siteSettings', [
                    'company_email' => 'example@gmail.com',
                    'company_phone' => '1800-315-8441',
                    'company_address' => '4000 N Montrose Ave<br>550 Chicago, IL 60641',
                    'footer_categories' => [],
                    'footer_products' => [],
                    'footer_quick_links' => [],
                    'footer_policy_pages' => [],
                    'footer_description' => 'Go Custom Boxes is a leading custom packaging manufacturer, delivering premium boxes and packaging solutions tailored to your brand. From design to delivery, we ensure unmatched quality, style, and customer service.'
                ]);
            }
        });
    }
}
