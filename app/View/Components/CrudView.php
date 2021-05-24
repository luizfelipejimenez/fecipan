<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrudView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $permissoes;
    public $a;
    public $route;
    public $model;
    
    public function __construct($permissoes, $route, $a, $model)
    {
        $this->permissoes = $permissoes;
        $this->route = $route;
        $this->a = $a;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.crud-view');
    }
}
