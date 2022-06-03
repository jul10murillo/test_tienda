<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait OrderOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupOrderRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/order', [
            'as'        => $routeName.'.order',
            'uses'      => $controller.'@order',
            'operation' => 'order',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupOrderDefaults()
    {
        $this->crud->allowAccess('order');

        $this->crud->operation('order', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            // $this->crud->addButton('top', 'order', 'view', 'crud::buttons.order');
            // $this->crud->addButton('line', 'order', 'view', 'crud::buttons.order');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function order()
    {
        $this->crud->hasAccessOrFail('order');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'order '.$this->crud->entity_name;

        // load the view
        return view("crud::operations.order", $this->data);
    }
}
