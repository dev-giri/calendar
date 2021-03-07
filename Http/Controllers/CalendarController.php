<?php

namespace Modules\Calendar\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Calendar\Entities\Calendar;
use Modules\Calendar\Entities\CalendarType;
// use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\DataType;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Auth;

class CalendarController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{
    // use BreadRelationshipParser;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        //dd('hi');
        $pageConfigs = ['pageHeader' => false];
        return view('calendar::index', ['pageConfigs' => $pageConfigs]);
    }

    public function events(Request $request)
    {
        // $dataType = Datatype::where('slug', '=', 'calendars')->first();
        $dataType = Voyager::model('DataType')->where('slug', '=', 'calendars')->first();

        

        $authorized = auth()->user()->can('browse', app($dataType->model_name));

        if(!$authorized){
            abort(403, 'Unauthorized');
        }

        

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $start = $request->start;
            $end = $request->end;
            $user = Auth::user();

            $model = app($dataType->model_name);
            $query = $model::select('*')
                            ->whereDate('start','>=',$start)
                            ->whereDate('end','<=',$end);

            $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), 'get']);

            foreach($dataTypeContent as $data){
                foreach($dataType->browseRows as $row){
                    if($row->type == 'relationship'){
                        $options = $row->details;
                        if(isset($options->model) && isset($options->type)){
                            if(class_exists($options->model)){
                                $relationshipField = $row->field;
                                if($options->type == 'belongsTo'){
                                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                                    $modelRelation = app($options->model);
                                    $query = $modelRelation::where($options->key,$relationshipData->{$options->column})->first();
                                    if(isset($query)){
                                        $data->{$relationshipField} = $query->{$options->label};
                                        unset($data->{$row->details->column});
                                    }
                                }
                            }
                        }
                        
                    }
                }
            }

        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        return response()->json($dataTypeContent);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    // public function create()
    // {
    //     return view('calendar::create');
    // }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $slug = 'calendars';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));
        $extendedProps = $request->all()['extendedProps'];
        $calendarType = '';
        if(isset($extendedProps['calendar'])){
            $calendarType = CalendarType::where('display',$extendedProps['calendar'])->first();
        }
        
        $requestData['host_id'] = Auth::user()->id;
        $requestData['title'] = $request->title;
        $requestData['start'] = Carbon::parse($request->start);
        $requestData['end'] = Carbon::parse($request->end);
        $requestData['url'] = '';
        $requestData['lable'] = isset($calendarType->id)?$calendarType->id:1;
        $requestData['description'] = isset($extendedProps['description'])?$extendedProps['description']:'';

        

        // $request->host_id = $requestData['host_id'];
        // $request->title = $requestData['title'];
        // $request->start = $requestData['start'];
        // $request->end = $requestData['end'];
        // $request->lable = $requestData['lable'];
        // $request->description = $requestData['description'];

        $data = Calendar::create($requestData);
       // dd($request->all(),$requestData);

        // Validate fields with ajax
        // $val = $this->validateBread($requestData, $dataType->addRows)->validate();
        // $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        // event(new BreadDataAdded($dataType, $data));

        return response()->json(['success' => true]);

        // if (!$request->has('_tagging')) {
        //     if (auth()->user()->can('browse', $data)) {
        //         $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        //     } else {
        //         $redirect = redirect()->back();
        //     }

        //     return $redirect->with([
        //         'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
        //         'alert-type' => 'success',
        //     ]);
        // } else {
        //     return response()->json(['success' => true, 'data' => $data]);
        // }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    // public function show($id)
    // {
    //     return view('calendar::show');
    // }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    // public function edit($id)
    // {
    //     return view('calendar::edit');
    // }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $slug = 'calendars';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));
        $extendedProps = $request->all()['extendedProps'];
        $calendar = Calendar::find($id);
        $calendarType = '';
        if(isset($extendedProps['calendar'])){
            $calendarType = CalendarType::where('display',$extendedProps['calendar'])->first();
        }
        
        //$requestData['host_id'] = Auth::user()->id;
        $requestData['title'] = $request->title;
        $requestData['start'] = Carbon::parse($request->start);
        $requestData['end'] = Carbon::parse($request->end);
        $requestData['url'] = '';
        $requestData['lable'] = isset($calendarType->id)?$calendarType->id:1;
        $requestData['description'] = isset($extendedProps['description'])?$extendedProps['description']:'';

        $calendar->update($requestData);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $slug = 'calendars';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));
        $calendar = Calendar::find($id);

        $calendar->delete();

        return response()->json(['success' => true]);
    }
}
