<?php

namespace App\View\Components;

use App\Models\Note;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class NoteCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Note $note)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.note-card');
    }

    public function renderContent(): HtmlString
    {
        return new HtmlString(Str::markdown($this->note->content, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]));
    }
}
