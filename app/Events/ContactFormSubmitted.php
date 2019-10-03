<?php

namespace App\Events;

use App\Models\ContactForm;

class ContactFormSubmitted
{
    /**
     * @var ContactForm
     */
    public $contactForm;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ContactForm $contactForm)
    {
        $this->contactForm = $contactForm;
    }
}
