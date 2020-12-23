<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminWellcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Admin $admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin)
    {
        //
        $this->$admin=$admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('suport@bs.com')
            ->subject('WellCome in Bank System')
            ->markdown('email.admin_wellcome_email');
    }
}
