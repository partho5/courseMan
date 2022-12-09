<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoticeMailing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $noticeData;

    public function __construct($noticeData)
    {
        $this->noticeData = $noticeData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->noticeData);
        return $this->from('choriyedao@gmail.com', 'CourseMan')
            ->subject($this->noticeData['title'])
            ->view('notification/mail/notice_published');
    }
}
