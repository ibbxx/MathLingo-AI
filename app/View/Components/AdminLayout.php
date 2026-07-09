<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public function __construct(public string $title = 'Admin Panel') {}

    public function render(): View
    {
        return view('admin.layouts.app');
    }
}