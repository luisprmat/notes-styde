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
        return view('components.note-card', [
            'size' => $this->calculateSize($this->note->content),
        ]);
    }

    public function renderContent(): HtmlString
    {
        return new HtmlString(Str::markdown($this->note->content, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]));
    }

    private function calculateSize(string $content): string
    {
        preg_match_all('/```(.+?)```/s', $content, $matches);

        if ($matches[0] === 0) {
            return 'small';
        }

        $maxLength = collect($matches[1])
            ->flatMap(fn ($block) => explode(PHP_EOL, $block))
            ->map(fn ($line) => strlen($line))
            ->max();

        if ($maxLength > 40) {
            return 'big';
        }

        if ($maxLength > 30) {
            return 'medium';
        }

        return 'small';
    }
}
