<?php

namespace App\Events;

use App\Models\WorkflowComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(WorkflowComment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new Channel('workflow.' . $this->comment->workflow_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->comment->id,
            'user' => $this->comment->user->name,
            'user_id' => $this->comment->user_id,
            'text' => $this->comment->comment,
            'created_at' => $this->comment->created_at->format('H:i d.m.Y'),
        ];
    }
}
