<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Branded "thank you" email that goes only to the customer, from the support mailbox.
 * The admin mailbox gets the table-style ContactFormMail instead.
 */
class CustomerContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $contactRef;
    public $supportEmail;

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
        $this->supportEmail = $supportEmail ?: config('mail.support.address');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank You for Contacting Us (' . $this->contactRef . ') - Go Custom Boxes - ✓ Message Received';
        $supportName = config('mail.support.name', 'Go Custom Boxes Support');

        return $this->subject($subject)
                    ->from($this->supportEmail, $supportName)
                    ->replyTo($this->supportEmail, $supportName)
                    ->view('emails.customer_contact', [
                        'data' => $this->data,
                        'contactRef' => $this->contactRef,
                        'supportEmail' => $this->supportEmail,
                    ]);
    }
}
