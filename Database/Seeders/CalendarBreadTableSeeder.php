<?php

namespace Modules\Calendar\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
// use VoyagerBread\Traits\BreadSeeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\MenuItem;
use Modules\Calendar\Entities\Calendar;

class CalendarBreadTableSeeder extends Seeder
{
    //use BreadSeeder;

    public function bread()
    {
        return [
            // usually the name of the table
            'name'                  => 'calendars',
            'slug'                  => 'calendars',
            'display_name_singular' => 'Calendar',
            'display_name_plural'   => 'Calendars',
            'icon'                  => 'voyager-file-text',
            'model_name'            => Calendar::class,
            'controller'            => null,
            'generate_permissions'  => 1,
            'description'           => '',
            'details'               => [
                "order_column" => null,
                "order_display_column" => null
                ]
        ];
    }

    public function inputFields()
    {
        return [
            'id' => [
                'type'         => 'number',
                'display_name' => 'ID',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 1,
            ],
            'created_at' => [
                'type'         => 'timestamp',
                'display_name' => 'created_at',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 2,
            ],
            'updated_at' => [
                'type'         => 'timestamp',
                'display_name' => 'updated_at',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 3,
            ]
        ];
    }

    public function menuEntry()
    {
        return [
            'role'        => 'admin',
            'title'       => 'Calendar',
            'url'         => '',
            'route'       => 'voyager.calendars.index',
            'target'      => '_self',
            'icon_class'  => 'voyager-file-text',
            'color'       => null,
            'parent_id'   => null,
            'parameters' => null,
            'order'       => 10,
        ];
    }

    

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDataType();
        $this->createInputFields();
        $this->createMenuItem();
        $this->generatePermissions();

        // //Model::unguard();
        // Permission::generateFor('calendars');

        // $role = Role::where('name', 'admin')->firstOrFail();

        // $permissions = Permission::all();

        // $role->permissions()->sync(
        //     $permissions->pluck('id')->all()
        // );
        
    }

            /**
     * Create a new data-type for the current bread
     *
     * @return void
     */
    public function createDataType()
    {
        $dataType = $this->dataType('slug', $this->bread()['slug']);
        if (!$dataType->exists) {
            $dataType->fill($this->bread())->save();
        }
    }

    /**
     * Create all the input fields specified in the
     * bread() method
     *
     * @return [type] [description]
     */
    public function createInputFields()
    {
        $productDataType = DataType::where('slug', $this->bread()['slug'])->firstOrFail();

        collect($this->inputFields())->each(function ($field, $key) use ($productDataType) {
            $dataRow = $this->dataRow($productDataType, $key);
            if (!$dataRow->exists) {
                $dataRow->fill($field)->save();
            }
        });

    }

    /**
     * Create the new menu entry using the configuration
     * specified in the menuEntry() method. IF set to null
     * then no menu entry is going to be created
     *
     * @return [type] [description]
     */
    public function createMenuItem()
    {
        if (empty($this->menuEntry())) {
            return;
        }
        $menuEntry = collect($this->menuEntry());

        if (empty($menuEntry->menu_id)) {
            $menu = Menu::where('name', $menuEntry->get('role'))->firstOrFail();
            $menuEntry = $menuEntry->put('menu_id', $menu->id);
        }

        $menuItem = MenuItem::firstOrNew($menuEntry->only(['menu_id', 'title', 'url', 'route'])->toArray());
        if (!$menuItem->exists) {
            $menuItem->fill($menuEntry->only(['target', 'icon_class', 'color', 'parent_id', 'order'])->toArray())->save();
        }
    }

    /**
     * Generates admin permissions to the current
     * bread
     *
     * @return void
     */
    public function generatePermissions()
    {
        Permission::generateFor($this->bread()['name']);
    }

    /**
     * Find or create a new data-type
     *
     * @param  string $field Field name
     * @param  string $for   Bread name
     *
     * @return DataType::class
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    /**
     * Find or create a new data-row
     *
     * @param  string $type  Type name
     * @param  string $field Field name
     *
     * @return DataType::class
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
                'data_type_id' => $type->id,
                'field'        => $field,
            ]);
    }
}
