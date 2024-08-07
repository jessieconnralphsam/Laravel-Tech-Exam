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

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $blog
     * @return void
     */
    public function __construct($blog)
    {
        $this->blog = $blog;  // Store the blog instance
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];  // Specify that the notification will be sent via email
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
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
