<?php

namespace App\Domain\Emails\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Emails extends Model
{
    use HasFactory;

    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function sendEmail($subject, $message)
    {
        Mail::send([], [], function ($message) {
            $message->to($this->email)
                ->subject($subject)
                ->setBody($message, 'text/html');
        });
    }
}
