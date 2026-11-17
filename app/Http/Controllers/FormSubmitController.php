<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\QuoteFormMail;
use App\Mail\NewsletterMail;
use App\Mail\CustomerContactConfirmationMail;
use App\Mail\CustomerQuoteConfirmationMail;
use Illuminate\Support\Facades\Storage;

class FormSubmitController extends Controller
{
    private $adminEmail;
    private $supportEmail;

    public function __construct()
    {
        $this->adminEmail = config('mail.admin.address');
        $this->supportEmail = config('mail.support.address');
    }

    /**
     * Every quote/contact submission sends two different emails:
     *  1. the table-style notification to the admin (Hostinger) inbox, from the site's main address;
     *  2. the branded "thank you" confirmation to the customer only, from the support address.
     * Each send has its own try/catch, so one failing never stops the other.
     */
    private function sendFormEmails(Mailable $adminMail, ?string $customerEmail, Mailable $customerMail, string $label)
    {
        $adminEmail = $this->adminEmail;

        try {
            Mail::to($adminEmail)->send($adminMail);
        } catch (\Exception $e) {
            Log::error("Admin {$label} mail error: " . $e->getMessage());
        }

        // The branded confirmation is for the customer only, never for the admin inbox.
        if (empty($customerEmail) || strcasecmp(trim($customerEmail), trim((string) $adminEmail)) === 0) {
            return;
        }

        try {
            Mail::mailer(config('mail.support.mailer'))->to($customerEmail)->send($customerMail);
        } catch (\Exception $e) {
            Log::error("Customer {$label} confirmation mail error: " . $e->getMessage());
        }
    }

    // Strip surrounding whitespace (incl. non-breaking spaces) so "   " fails the required rule.
    private function trimFields(Request $request, array $fields)
    {
        foreach ($fields as $field) {
            if (is_string($request->input($field))) {
                $request->merge([$field => preg_replace('/^[\s\x{00A0}\x{200B}]+|[\s\x{00A0}\x{200B}]+$/u', '', $request->input($field))]);
            }
        }
    }

    public function submitContact(Request $request)
    {
        $this->trimFields($request, ['name', 'email', 'phone', 'message']);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string'
        ]);

        $contactRef = 'GCB-C' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 5));
        $validated['contact_ref'] = $contactRef;

        dispatch(function () use ($validated, $contactRef) {
            $this->sendFormEmails(
                new ContactFormMail($validated),
                $validated['email'] ?? null,
                new CustomerContactConfirmationMail($validated, $contactRef, $this->supportEmail),
                'contact'
            );
        })->afterResponse();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Thank you for contacting us! Your message has been sent successfully.']);
        }
        return back()->with('success', 'Thank you for contacting us! Your message has been sent successfully.');
    }

    public function submitQuote(Request $request)
    {
        $this->trimFields($request, ['name', 'email', 'phone', 'company_name', 'website', 'physical_address', 'message']);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            // Address is only asked for (and required) on the product page sample-kit form.
            'physical_address' => 'nullable|required_if:source_form,Product Page - Bottom Form|string|max:255',
            'width' => 'required|string|max:255',
            'length' => 'required|string|max:255',
            'depth' => 'required|string|max:255',
            'units' => 'required|string|max:255',
            'box_style' => 'required|string|max:255',
            'material' => 'nullable|string|max:255',
            'paper_stock' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'paper_coating' => 'nullable|string|max:255',
            'cad_sample' => 'nullable|string|max:255',
            'turn_around_time' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'quote_file' => 'nullable|file|max:10240', // 10MB max
            'message' => 'nullable|string',
            'form_source' => 'nullable|string|max:50',
            'source_form' => 'nullable|string|max:100',
            'source_page' => 'nullable|string|max:500'
        ], [
            'box_style.required' => 'Please select a Box Style.',
            'physical_address.required_if' => 'The physical address field is required.',
            'quote_file.max' => 'The uploaded file must be 10 MB or smaller.',
            'quote_file.uploaded' => 'The file could not be uploaded. Please use a file of 10 MB or smaller.',
        ]);

        foreach (['paper_stock', 'paper_coating', 'color'] as $field) {
            if (empty($validated[$field])) {
                $validated[$field] = 'Not Sure';
            }
        }
        if (empty($validated['cad_sample'])) {
            $validated['cad_sample'] = 'No';
        }
        if (empty($validated['source_page'])) {
            $validated['source_page'] = $request->headers->get('referer');
        }

        if (empty($validated['form_source'])) {
            $referer = $request->headers->get('referer', '');
            if (str_contains($referer, '/product/') || $request->is('product/*')) {
                $validated['form_source'] = 'product';
            } else {
                $validated['form_source'] = 'quote';
            }
        }

        unset($validated['quote_file']);
        if ($request->hasFile('quote_file')) {
            // Private disk (storage/app/quotes): the file is only emailed, never served on the website,
            // so an uploaded script can't be opened through a public URL.
            $file = $request->file('quote_file');
            $validated['quote_file_path'] = $file->store('quotes', 'local');
            $validated['quote_file_name'] = $file->getClientOriginalName();
        }

        $quoteRef = 'GCB-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 6));
        $validated['quote_ref'] = $quoteRef;

        dispatch(function () use ($validated, $quoteRef) {
            $this->sendFormEmails(
                new QuoteFormMail($validated),
                $validated['email'] ?? null,
                new CustomerQuoteConfirmationMail($validated, $quoteRef, $this->supportEmail),
                'quote'
            );
        })->afterResponse();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Quote submitted successfully!']);
        }
        return back()->with('success', 'Quote submitted successfully!');
    }

    public function submitNewsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        dispatch(function () use ($validated) {
            try {
                Mail::to($this->adminEmail)->send(new NewsletterMail($validated['email']));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail error: ' . $e->getMessage());
            }
        })->afterResponse();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Thank you for subscribing to our newsletter!']);
        }
        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
