<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminFaqPageController extends Controller
{
    public function getSettings(): array
    {
        $defaults = [
            'faq_page_title' => 'Frequently Asked Questions',
            'faq_page_slug' => 'frequentlyAskedQuestions',
            'faq_page_sections' => []
        ];

        try {
            $rows = DB::table('homepage_contents')
                ->where('section', 'faq_page')
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
                return array_merge($defaults, $settings);
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return $defaults;
    }

    public function edit()
    {
        $settings = $this->getSettings();
        return view('admin.faq_page_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'faq_page_title' => 'required|string|max:255',
            'faq_page_slug' => 'required|string|max:255',
            'headings' => 'nullable|array',
            'questions' => 'nullable|array',
            'answers' => 'nullable|array',
        ]);

        $settings = $this->getSettings();
        $settings['faq_page_title'] = $request->input('faq_page_title');
        $settings['faq_page_slug'] = Str::slug($request->input('faq_page_slug'));

        // Reconstruct the sections JSON
        $sections = [];
        $headings = (array) $request->input('headings', []);
        $questionsInput = (array) $request->input('questions', []);
        $answersInput = (array) $request->input('answers', []);

        foreach ($headings as $index => $headingText) {
            $headingText = trim((string) $headingText);

            $faqs = [];
            $qs = $questionsInput[$index] ?? [];
            $as = $answersInput[$index] ?? [];

            foreach ($qs as $qIndex => $qText) {
                $qText = trim((string) $qText);
                $aText = trim((string) ($as[$qIndex] ?? ''));
                if ($qText !== '' && $aText !== '') {
                    $faqs[] = [
                        'question' => $qText,
                        'answer' => $aText
                    ];
                }
            }

            // Heading is optional: keep the section if it has a heading or at least one FAQ
            if ($headingText === '' && empty($faqs)) continue;

            $sections[] = [
                'heading' => $headingText,
                'faqs' => $faqs
            ];
        }

        $settings['faq_page_sections'] = $sections;

        foreach ($settings as $key => $value) {
            $isJson = is_array($value);
            $strValue = $isJson ? json_encode($value) : (string) $value;

            DB::table('homepage_contents')->updateOrInsert(
                ['section' => 'faq_page', 'field_key' => $key],
                [
                    'value' => $strValue,
                    'value_type' => $isJson ? 'json' : 'string',
                    'updated_at' => now()
                ]
            );
        }

        return redirect()->back()->with('success', 'FAQ Page Settings updated successfully!');
    }
}
