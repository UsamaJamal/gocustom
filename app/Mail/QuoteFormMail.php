<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $isProduct = (!empty($this->data['form_source']) && $this->data['form_source'] === 'product');
        $subject = $isProduct ? 'Product Request a Quote' : 'Request a Quote';

        $mail = $this->subject($subject)
                     ->view('emails.quote');
                     
        if (!empty($this->data['quote_file_path'])) {
            $options = !empty($this->data['quote_file_name']) ? ['as' => $this->data['quote_file_name']] : [];
            $mail->attach(storage_path('app/' . $this->data['quote_file_path']), $options);
        }
        
        return $mail;
    }
}
