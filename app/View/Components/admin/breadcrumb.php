<?php

namespace App\View\Components\admin;

use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class breadcrumb extends Component
{
    public $urls;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->urls = explode('/', URL::current());
      $this->urls = array_splice($this->urls, 3);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.breadcrumb',
        [
          'urls' => $this->urls
        ]);
    }
}
