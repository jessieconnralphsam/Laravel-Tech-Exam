<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogPosted extends Notification
{
    use Queueable;

    protected $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Blog Post Created')
            ->line('A new blog post has been created.')
            ->line('Title: ' . $this->blog->title)
            ->line('Content: ' . $this->blog->content)
            ->action('View Blog Post', url('/blogs/' . $this->blog->id));
    }
}
