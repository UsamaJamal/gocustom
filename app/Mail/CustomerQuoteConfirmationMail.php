<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerQuoteConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $quoteRef;
    public $supportEmail;
    public $fromAddress;
    public $fromName;

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
        $this->supportEmail = $supportEmail ?: env('MAIL_SUPPORT_ADDRESS', 'support@gocustomboxes.com');
        $this->fromAddress = config('mail.from.address', 'info@gocustomboxes.com');
        $this->fromName = config('mail.from.name', 'Go Custom Boxes');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank You for Your Quote Request (' . $this->quoteRef . ') - Custom Packaging | Go Custom Boxes - ✓ Quote Request Received';

        $mail = $this->subject($subject)
                     ->from($this->fromAddress, 'Go Custom Boxes Support')
                     ->replyTo($this->supportEmail, 'Go Custom Boxes Support')
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
