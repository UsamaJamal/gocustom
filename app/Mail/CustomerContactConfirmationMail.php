<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $contactRef;
    public $supportEmail;
    public $fromAddress;
    public $fromName;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string|null $contactRef
     * @param string|null $supportEmail
     */
    public function __construct(array $data, ?string $contactRef = null, ?string $supportEmail = null)
    {
        $this->data = $data;
        $this->contactRef = $contactRef ?: ($data['contact_ref'] ?? 'GCB-C' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5)));
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
        $subject = 'Thank You for Contacting Us (' . $this->contactRef . ') - Go Custom Boxes - ✓ Message Received';

        return $this->subject($subject)
                    ->from($this->fromAddress, 'Go Custom Boxes Support')
                    ->replyTo($this->supportEmail, 'Go Custom Boxes Support')
                    ->view('emails.customer_contact', [
                        'data' => $this->data,
                        'contactRef' => $this->contactRef,
                        'supportEmail' => $this->supportEmail,
                    ]);
    }
}
