<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminContentController extends Controller
{
    private function modules(): array
    {
        return [
            'products' => ['title' => 'Products', 'singular' => 'Product'],
            'categories' => ['title' => 'Categories', 'singular' => 'Category'],
            'blogs' => ['title' => 'Blog Posts', 'singular' => 'Blog Post'],
            'pages' => ['title' => 'Dynamic Pages', 'singular' => 'Page'],
            'authors' => ['title' => 'Authors', 'singular' => 'Author'],
        ];
    }

    private function data(): array
    {
        return ['products' => DB::table('admin_products')->get()->map(fn($r)=>(array)$r)->all(), 'categories' => DB::table('admin_categories')->get()->map(fn($r)=>(array)$r)->all(), 'blogs' => DB::table('admin_blogs')->get()->map(fn($r)=>(array)$r)->all(), 'pages' => DB::table('admin_pages')->get()->map(fn($r)=>(array)$r)->all(), 'authors' => DB::table('admin_authors')->get()->map(fn($r)=>(array)$r)->all()];
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['data' => $this->data(), 'modules' => $this->modules()]);
    }

    public function index(string $module)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        return view('admin.index', ['module' => $module, 'meta' => $this->modules()[$module], 'items' => $this->data()[$module]]);
    }

    public function create(string $module)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        return view("admin.forms.{$module}", $this->formData($module, null));
    }

    public function edit(string $module, string $id)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        $item = collect($this->data()[$module])->firstWhere('id', $id);
        abort_unless($item, 404);
        return view("admin.forms.{$module}", $this->formData($module, $item));
    }

    private function formData(string $module, ?array $item): array
    {
        $data = $this->data();
        $formData = compact('module', 'item') + [
            'meta' => $this->modules()[$module],
            'categories' => $data['categories'],
            'products' => $data['products'],
            'blogs' => $data['blogs'],
            'authors' => $data['authors'],
        ];

        if ($module === 'categories' && !empty($item['id'])) {
            $formData['categoryFaqs'] = DB::table('admin_category_faqs')
                ->where('category_id', $item['id'])
                ->orderBy('id')
                ->get()
                ->map(fn($faq) => (array) $faq)
                ->all();
        } else {
            $formData['categoryFaqs'] = [];
        }

        if ($module === 'products' && !empty($item['id'])) {
            $formData['productFaqs'] = DB::table('admin_product_faqs')
                ->where('product_id', $item['id'])
                ->orderBy('id')
                ->get()
                ->map(fn($faq) => (array) $faq)
                ->all();
        } else {
            $formData['productFaqs'] = [];
        }

        if ($module === 'blogs' && !empty($item['faqs'])) {
            $formData['blogFaqs'] = is_string($item['faqs']) ? (json_decode($item['faqs'], true) ?: []) : (array) $item['faqs'];
        } else {
            $formData['blogFaqs'] = [];
        }

        return $formData;
    }

    public function store(Request $request, string $module)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        return $this->persist($request, $module, (string) Str::uuid());
    }

    public function update(Request $request, string $module, string $id)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        return $this->persist($request, $module, $id);
    }

    public function uploadTinyMceMedia(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:51200',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm,video/ogg',
            ],
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('admin/tinymce', $file->getClientOriginalName(), 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
    }

    private function persist(Request $request, string $module, string $id)
    {
        $table = ['products'=>'admin_products','categories'=>'admin_categories','blogs'=>'admin_blogs','pages'=>'admin_pages','authors'=>'admin_authors'][$module];
        $columns = [
            'products' => ['title','slug','status','show_home','show_as_custom_box','image','nav_image','images','description','long_description','alt_text','box_style','material','printing','finishing','dimensions','moq','turnaround','meta_title','meta_description','meta_keywords','robots','rating_value','review_count','price','schema','related'],
            'categories' => ['title','slug','status','parent_id','is_nav_group','show_in_nav','show_home','image','icon','hero_image','banner_image','hero_title','hero_badge','hero_description','description','products_heading','products_description','feature_title','why_choose_title','why_choose_description','feature_sections','meta_title','meta_description','meta_keywords','robots','rating_value','review_count','price','schema'],
            'blogs' => ['title','slug','status','show_home','set_home','image','author_id','author_name','publish_date','blog_category','tags','excerpt','key_takeaways','content','toc_title','author_description','author_bio','alt_text','meta_title','meta_description','meta_keywords','robots','schema','faqs','related'],
            'pages' => ['title','slug','status','show_home','image','heading','content','position','appearance','alt_text','meta_title','meta_description','meta_keywords','robots','schema'],
            'authors' => ['title','slug','status','designation','bio','toc_title','description','image','facebook','twitter','linkedin'],
        ][$module];
        $existing = ctype_digit((string)$id) ? DB::table($table)->where('id',(int)$id)->first() : null;

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'rating_value' => 'nullable|string|max:255',
            'review_count' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'schema' => 'nullable|string|max:50000',
            'hero_description' => 'nullable|string',
        ];

        if ($module === 'blogs') {
            if (!$existing || empty($existing->image) || $request->input('remove_image') == '1') {
                $rules['image'] = 'required|file|image';
            } else {
                $rules['image'] = 'nullable|file|image';
            }
        }

        $request->validate($rules);
        $fields = $columns;
        $payload = collect($request->except(['_token','_method','images','existing_images','image','nav_image','hero_image','banner_image','icon','categories','related','faq_question','faq_answer']))->only($fields)->all();
        \Log::info('AdminContentController payload for ' . $module, $payload);
        $payload['title'] = $request->title; $payload['slug'] = Str::slug($request->slug ?: $request->title); $payload['updated_at'] = now();

        if (isset($payload['hero_description']) && is_string($payload['hero_description'])) {
            $payload['hero_description'] = trim($payload['hero_description']);
        }

        if (isset($payload['publish_date']) && !empty(trim($payload['publish_date']))) {
            $payload['publish_date'] = date('Y-m-d', strtotime(trim($payload['publish_date'])));
        }

        // The position column is NOT NULL, but the number input can be cleared in the form.
        if (array_key_exists('position', $payload) && $payload['position'] === null) {
            $payload['position'] = 0;
        }

        foreach (['show_home', 'set_home', 'show_in_nav', 'show_as_custom_box', 'is_nav_group'] as $checkboxField) {
            if (in_array($checkboxField, $fields, true)) {
                $payload[$checkboxField] = $request->boolean($checkboxField) ? 1 : 0;
            }
        }

        if ($module === 'products' || $module === 'blogs') {
            // `related` is excluded above with other array inputs, so explicitly persist it as JSON below.
            $payload['related'] = array_map('intval', (array) $request->input('related', []));
        }

        if ($module === 'blogs') {
            $faqs = [];
            $faqQuestions = (array) $request->input('faq_question', []);
            $faqAnswers = (array) $request->input('faq_answer', []);
            foreach ($faqQuestions as $i => $q) {
                $q = trim((string) $q);
                $a = trim((string) ($faqAnswers[$i] ?? ''));
                if ($q !== '' || $a !== '') {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
            $payload['faqs'] = json_encode($faqs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if ($module === 'categories') {
            $payload['parent_id'] = $request->filled('parent_id') ? $request->input('parent_id') : null;

            $featureSections = [];
            $featureTitles = (array) $request->input('feature_section_title', []);
            $featureDescriptions = (array) $request->input('feature_section_description', []);
            $existingFeatureImages = (array) $request->input('feature_section_existing_image', []);
            $featureImageUploads = (array) $request->file('feature_section_image', []);
            $featureCategoryKey = preg_replace('/[^A-Za-z0-9_-]/', '-', (string) $id);
            $featureUploadRelativePath = 'uploads';
            $uploadPath = public_path($featureUploadRelativePath);

            foreach ($featureTitles as $index => $featureTitle) {
                $featureTitle = trim((string) $featureTitle);
                $featureDescription = trim((string) ($featureDescriptions[$index] ?? ''));
                $featureImage = $existingFeatureImages[$index] ?? null;

                $file = $featureImageUploads[$index] ?? null;
                if ($file && $file->isValid()) {
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }
                    $fileName = $file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $featureImage = 'uploads/' . $fileName;
                }

                if ($featureTitle !== '' || $featureDescription !== '' || !empty($featureImage)) {
                    $featureSections[] = [
                        'title' => $featureTitle,
                        'description' => $featureDescription,
                        'image' => $featureImage,
                    ];
                }
            }

            $payload['feature_sections'] = json_encode($featureSections);
        }

        foreach (['image', 'nav_image', 'hero_image', 'banner_image', 'icon'] as $field) {
            if (in_array($field, $fields) && $request->input('remove_' . $field) == '1') {
                $payload[$field] = null;
            }
            if ($request->hasFile($field)) {
                if (in_array($field, $fields)) {
                    $file = $request->file($field);
                    $fileName = $file->getClientOriginalName();
                    $uploadPath = public_path('uploads');
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }
                    $file->move($uploadPath, $fileName);
                    $payload[$field] = 'uploads/' . $fileName;
                }
            }
        }
        if (in_array('images', $fields, true)) {
            $existingImages = json_decode((string) $request->input('existing_images', '[]'), true) ?: [];
            
            $galleryFiles = array_filter((array) $request->file('images'), function ($file) {
                return $file && $file->isValid();
            });

            $newImages = [];
            if ($galleryFiles) {
                $uploadPath = public_path('uploads');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }
                $newImages = collect($galleryFiles)
                    ->map(function ($file) use ($uploadPath) {
                        $fileName = $file->getClientOriginalName();
                        $file->move($uploadPath, $fileName);
                        return 'uploads/' . $fileName;
                    })
                    ->values()
                    ->all();
            }
            
            $payload['images'] = json_encode(array_values(array_merge($existingImages, $newImages)));
        }
        foreach (['images','related'] as $jsonField) if (array_key_exists($jsonField,$payload) && is_array($payload[$jsonField])) $payload[$jsonField] = json_encode($payload[$jsonField]);
        if ($existing) {
            DB::table($table)->where('id', $existing->id)->update($payload);
            $targetId = $existing->id;
        } else {
            $payload['created_at'] = now();
            $targetId = DB::table($table)->insertGetId($payload);
        }

        if ($module === 'products') {
            DB::table('admin_category_product')->where('product_id', $targetId)->delete();
            foreach ((array) $request->input('categories', []) as $cat) {
                if ($cat) {
                    DB::table('admin_category_product')->insert(['product_id' => $targetId, 'category_id' => $cat]);
                }
            }
            DB::table('admin_product_faqs')->where('product_id', $targetId)->delete();
            $faqQuestions = (array) $request->input('faq_question', []);
            $faqAnswers = (array) $request->input('faq_answer', []);
            foreach ($faqQuestions as $i => $q) {
                $q = trim((string) $q);
                $a = trim((string) ($faqAnswers[$i] ?? ''));
                if ($q !== '' || $a !== '') {
                    DB::table('admin_product_faqs')->insert([
                        'product_id' => $targetId,
                        'question' => $q,
                        'answer' => $a,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        if ($module === 'categories') {
            $currentFeatured = DB::table('homepage_contents')->where('field_key', 'featured_categories')->value('value');
            $featuredIds = $currentFeatured ? (json_decode($currentFeatured, true) ?: []) : [];
            $featuredIds = array_map('intval', (array) $featuredIds);
            $targetIntId = (int) $targetId;

            if (!empty($payload['show_home'])) {
                if (!in_array($targetIntId, $featuredIds, true)) {
                    $featuredIds[] = $targetIntId;
                }
            } else {
                $featuredIds = array_values(array_filter($featuredIds, fn($id) => $id !== $targetIntId));
            }

            DB::table('homepage_contents')->updateOrInsert(
                ['section' => 'list', 'field_key' => 'featured_categories'],
                [
                    'section' => 'list',
                    'value' => json_encode($featuredIds),
                    'value_type' => 'json',
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );

            DB::table('admin_category_faqs')->where('category_id', $targetId)->delete();
            $faqQuestions = (array) $request->input('faq_question', []);
            $faqAnswers = (array) $request->input('faq_answer', []);
            foreach ($faqQuestions as $i => $q) {
                $q = trim((string) $q);
                $a = trim((string) ($faqAnswers[$i] ?? ''));
                if ($q !== '' || $a !== '') {
                    DB::table('admin_category_faqs')->insert([
                        'category_id' => $targetId,
                        'question' => $q,
                        'answer' => $a,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        if ($module === 'pages') { 
            $faqs = []; 
            $faqQuestions = (array) $request->input('faq_question', []);
            $faqAnswers = (array) $request->input('faq_answer', []);
            foreach ($faqQuestions as $i => $q) { 
                $q = trim((string) $q);
                $a = trim((string) ($faqAnswers[$i] ?? ''));
                if ($q !== '' && $a !== '') { 
                    $faqs[] = ['question' => $q, 'answer' => $a]; 
                } 
            } 
            DB::table('admin_pages')->where('id', $targetId)->update(['faqs' => json_encode($faqs)]); 
        }
        if ($module === 'blogs') { 
            $faqs = []; 
            $faqQuestions = (array) $request->input('faq_question', []);
            $faqAnswers = (array) $request->input('faq_answer', []);
            foreach ($faqQuestions as $i => $q) { 
                $q = trim((string) $q);
                $a = trim((string) ($faqAnswers[$i] ?? ''));
                if ($q !== '' || $a !== '') { 
                    $faqs[] = ['question' => $q, 'answer' => $a]; 
                } 
            } 
            DB::table('admin_blogs')->where('id', $targetId)->update(['faqs' => json_encode($faqs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]); 
        }
        return redirect()->route('admin.module.index', $module)->with('success', $this->modules()[$module]['singular'].' saved successfully.');
    }

    public function destroy(string $module, string $id)
    {
        abort_unless(isset($this->modules()[$module]), 404);
        if ($module === 'products') {
            DB::table('admin_product_faqs')->where('product_id', $id)->delete();
            DB::table('admin_category_product')->where('product_id', $id)->delete();
        }
        if ($module === 'categories') {
            $currentFeatured = DB::table('homepage_contents')->where('field_key', 'featured_categories')->value('value');
            if ($currentFeatured) {
                $featuredIds = array_map('intval', (array) (json_decode($currentFeatured, true) ?: []));
                $featuredIds = array_values(array_filter($featuredIds, fn($catId) => $catId != (int) $id));
                DB::table('homepage_contents')->where('field_key', 'featured_categories')->update([
                    'value' => json_encode($featuredIds),
                    'updated_at' => now()
                ]);
            }
        }
        $table = ['products'=>'admin_products','categories'=>'admin_categories','blogs'=>'admin_blogs','pages'=>'admin_pages','authors'=>'admin_authors'][$module];
        DB::table($table)->where('id', $id)->delete();
        return back()->with('success', 'Item deleted successfully.');
    }
}
