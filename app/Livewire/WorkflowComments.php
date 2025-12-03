<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkflowComment;

class WorkflowComments extends Component
{
    public $workflow;
    public $comments;
    public $commentText = '';

    public function mount($workflow)
    {
        $this->workflow = $workflow;
        $this->comments = $workflow->comments()->with('user')->oldest()->get();
    }

    public function submitComment()
    {
        $this->validate(['commentText' => 'required|string|max:2000']);

        $comment = $this->workflow->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $this->commentText,
        ]);

        $this->commentText = '';
        $this->comments->push($comment->load('user'));

        $this->dispatchBrowserEvent('scroll-comments-bottom');
    }


    public function render()
    {
        return view('livewire.workflow-comments');
    }
}
