<?php

namespace App\Mail;

use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class SendStudentPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    public string $password;

    /**
     * Create a new mailable instance.
     *
     * @return void
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->markdown('emails.send-student-password');
    }
}
