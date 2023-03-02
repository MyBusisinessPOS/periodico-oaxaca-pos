<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::with(['type', 'category', 'documentType'])->get();
        return view('calendars.index', compact('publications'));
    }

    public function getEvents(Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        $publications = Publication::with(['type', 'category', 'documentType'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('updated_at', [$start, $end]);
            })
            ->get()->map(function ($item) use ($start, $end) {
                $icon = null;
                $color = null;
                switch ($item->document_type_id) {
                    case 1:
                        $icon = asset('img/fontawesome/pdf1.png');
                        $color = "#FF080B";
                        break;
                    case 2:
                        $icon = asset('img/fontawesome/pdf2.png');
                        $color = "#848484";
                        
                        break;
                    case 3:
                        $icon = asset('img/fontawesome/pdf3.png');                        
                        $color = "#6E9000";
                        break;
                    
                }
                $eventData = [
                    'id' => $item->id,
                    'title' => "Titulo: " . $item->summary . " \nDesc." . $item->description . "\n Autor: " . $item->author,
                    'description' => $item->description,
                    'author' => $item->author,
                    'file' => asset($item->media),
                    'icon' => $icon,
                    'start' => Carbon::parse($item->updated_at)->format('Y-m-d'),
                    'end' => Carbon::parse($item->updated_at)->format('Y-m-d'),
                    'allDay' => false,
                    'type_id' => $item->document_type_id,
                    'color' => $color,
                ];
                return $eventData;
            });
        Log::info($publications);
        return $publications;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
