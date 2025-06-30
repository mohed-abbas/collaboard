<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Models\User;

class MemberNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public Project $project;
    public User $user;
    public User $actor;
    public string $action;
    public string $projectName;
    public string $actorName;
    public int $projectId;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        Project $project,
        User $user,
        User $actor,
        string $action = 'added' // Default action is 'added'
    ) {
        $this->project = $project;
        $this->user = $user;
        $this->actor = $actor;
        $this->action = $action;
        $this->projectName = $project->name; // Store project name as string
        $this->actorName = $actor->name; // Store actor name as string
        $this->projectId = $project->id; // Store project ID
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $projectName = $this->projectName; // Use stored project name
        $actorName = $this->actorName; // Use stored actor name


        $subject = $this->action === 'added'
            ? "Vous avez été ajouté au projet {$projectName}"
            : "Vous avez été retiré du projet {$projectName}";

        $line = $this->action === 'added'
            ? "{$actorName} vient de vous accorder l'accès à « {$projectName} »."
            : "{$actorName} a révoqué votre accès à « {$projectName} ».";


        return (new MailMessage)
            ->subject($subject)
            ->greeting("Bonjour {$notifiable->name},")
            ->line($line)
            ->action('Voir le projet', url(route('project.board', $this->projectId)))
            ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}