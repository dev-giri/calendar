<?php

namespace Modules\Calendar\Database\Seeders;

use Carbon\Carbon;
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
use Modules\Calendar\Entities\CalendarType;
use App\User;

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
            'icon'                  => 'voyager-calendar',
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
            'host_id' => [
                'type'         => 'number',
                'display_name' => 'Host ID',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 2,
            ],
            'title' => [
                'type'         => 'text',
                'display_name' => 'Title',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 3,
            ],
            'lable' => [
                'type'         => 'number',
                'display_name' => 'lable_id',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 4,
            ],
            'start' => [
                'type'         => 'date_time',
                'display_name' => 'Start',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'format'=>'M d, Y g:i A'
                ],
                'order'        => 5,
            ],
            'end' => [
                'type'         => 'date_time',
                'display_name' => 'End',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'format'=>'M d, Y g:i A'
                ],
                'order'        => 6,
            ],
            'allDay' => [
                'type'         => 'checkbox',
                'display_name' => 'All Day',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    "true" => "True",
                    "false" => "False",
                    "checked" => false
                ],
                'order'        => 7,
            ],
            'url' => [
                'type'         => 'text',
                'display_name' => 'URL',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 8,
            ],
            'location' => [
                'type'         => 'text',
                'display_name' => 'Location',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 9,
            ],
            'description' => [
                'type'         => 'text',
                'display_name' => 'Description',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 10,
            ],
            'calendar_belongsto_calendar_type_relationship' => [
                'type'         => 'relationship',
                'display_name' => 'Lable',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'model' => CalendarType::class,
                    'table' => 'calendar_types',
                    'type' => 'belongsTo',
                    'column' => 'lable',
                    'key' => 'id',
                    'label' => 'display',
                    'pivot_table' => '',
                    'pivot' => '0',
                    'taggable' => '',
                ],
                'order'        => 11,
            ],
            'calendar_belongsto_user_relationship' => [
                'type'         => 'relationship',
                'display_name' => 'Hosted',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'model' => User::class,
                    'table' => 'users',
                    'type' => 'belongsTo',
                    'column' => 'host_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => '',
                    'pivot' => '0',
                    'taggable' => '',
                ],
                'order'        => 12,
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
                'order'        => 13,
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
                'order'        => 14,
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
            'icon_class'  => 'voyager-calendar',
            'color'       => null,
            'parent_id'   => null,
            'parameters' => null,
            'order'       => 14,
        ];
    }

    public function createAdditional()
    {
        $dataType = CalendarType::firstOrNew(['slug' => 'personal']);
        if (! $dataType->exists) {
            $dataType->fill([
                'slug'                  => 'personal',
                'display'           => 'Personal',
                'color'           => 'danger',
            ])->save();
        }

        $dataType = CalendarType::firstOrNew(['slug' => 'business']);
        if (! $dataType->exists) {
            $dataType->fill([
                'slug'                  => 'business',
                'display'           => 'Business',
                'color'           => 'primary',
            ])->save();
        }

        $dataType = CalendarType::firstOrNew(['slug' => 'family']);
        if (! $dataType->exists) {
            $dataType->fill([
                'slug'                  => 'family',
                'display'           => 'Family',
                'color'           => 'warning',
            ])->save();
        }

        $dataType = CalendarType::firstOrNew(['slug' => 'holiday']);
        if (! $dataType->exists) {
            $dataType->fill([
                'slug'                  => 'holiday',
                'display'           => 'Holiday',
                'color'           => 'success',
            ])->save();
        }

        $dataType = CalendarType::firstOrNew(['slug' => 'etc']);
        if (! $dataType->exists) {
            $dataType->fill([
                'slug'                  => 'etc',
                'display'           => 'ETC',
                'color'           => 'info',
            ])->save();
        }
    }    

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdditional();
        $this->createDataType();
        $this->createInputFields();
        $this->createMenuItem();
        
        
        //dummy data
        $this->createDummyData();

        $this->generatePermissions();
    }

    public function createDummyData()
    {
        $date = Carbon::now();
        // $today = Carbon::today();
        // $nextDay = Carbon::tomorrow()->timestamp;
        // $nextMonth = $date->addMonth()->timestamp;
        // $prevMonth = $date->subMonth()->timestamp;

        $dataType = Calendar::firstOrNew(['title' => 'Design Review']);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => 'Design Review',
                'lable'           => 2,
                'url'             => '',
                'start'           => Carbon::today(),
                'end'             => Carbon::tomorrow(),
                'allDay'          => false,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => 'Meeting With Client']);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => 'Meeting With Client',
                'lable'           => 2,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 10, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 11, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => 'Family Trip']);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => 'Family Trip',
                'lable'           => 4,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 7, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 9, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Doctor's Appointment"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Doctor's Appointment",
                'lable'           => 1,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 10, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 11, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Dart Game?"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Dart Game?",
                'lable'           => 5,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 12, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 13, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Meditation"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Meditation",
                'lable'           => 1,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 15, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 16, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Dinner"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Dinner",
                'lable'           => 3,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 18, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 19, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Product Review"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Product Review",
                'lable'           => 2,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month, 20, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month, 21, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Monthly Meeting"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Monthly Meeting",
                'lable'           => 2,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month+1, 1, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month+1, 1, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }

        $dataType = Calendar::firstOrNew(['title' => "Monthly Checkup"]);
        if (! $dataType->exists) {
            $dataType->fill([
                'host_id'         => 1,
                'title'           => "Monthly Checkup",
                'lable'           => 1,
                'url'             => '',
                'start'           => Carbon::create($date->year, $date->month-1, 1, 0, 0, 0),
                'end'             => Carbon::create($date->year, $date->month-1, 1, 0, 0, 0),
                'allDay'          => true,
            ])->save();
        }
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
