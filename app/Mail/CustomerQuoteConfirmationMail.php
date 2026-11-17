<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Branded "thank you" email that goes only to the customer, from the support mailbox.
 * The admin mailbox gets the table-style QuoteFormMail instead.
 */
class CustomerQuoteConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $quoteRef;
    public $supportEmail;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string|null $quoteRef
     * @param string|null $supportEmail
     */
    public function __construct(array $data, ?string $quoteRef = null, ?string $supportEmail = null)
    {
        $this->data = $data;
        $this->quoteRef = $quoteRef ?: ($data['quote_ref'] ?? 'GCB-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6)));
        $this->supportEmail = $supportEmail ?: config('mail.support.address');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank You for Your Quote Request (' . $this->quoteRef . ') - Custom Packaging | Go Custom Boxes - ✓ Quote Request Received';
        $supportName = config('mail.support.name', 'Go Custom Boxes Support');

        $mail = $this->subject($subject)
                     ->from($this->supportEmail, $supportName)
                     ->replyTo($this->supportEmail, $supportName)
                     ->view('emails.customer_quote', [
                         'data' => $this->data,
                         'quoteRef' => $this->quoteRef,
                         'supportEmail' => $this->supportEmail,
                     ]);

        if (!empty($this->data['quote_file_path'])) {
            $options = !empty($this->data['quote_file_name']) ? ['as' => $this->data['quote_file_name']] : [];
            $filePath = storage_path('app/' . $this->data['quote_file_path']);
            if (file_exists($filePath)) {
                $mail->attach($filePath, $options);
            }
        }

        return $mail;
    }
}
