<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Models\PublicationType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::with(['type', 'category', 'documentType'])->orderBy('created_at', 'DESC')->paginate(10);
        return view('publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = PublicationType::all();
        $categories = PublicationCategory::all();
        $documents = DocumentType::all();
        return view('publications.create', compact('types', 'categories', 'documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePublicationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $userID = auth()->user()->id;


        try {

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $uuid = strtoupper(\Str::uuid()->toString());
                $fileName =  $uuid . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/media/publications/{$userID}";
                $file->move($path, $fileName);
                $input['media'] = "media/publications/{$userID}/" . $fileName;
                $input['media_type'] = $file->getClientMimeType();
                $input['media_size'] = formatedSize(\File::size($path . "/" . $fileName));
                $input['media_name'] =  $file->getClientOriginalName();
                $input['media_uuid'] = $uuid;
            }

            DB::beginTransaction();
            Publication::create($input);
            DB::commit();

            return redirect()->route('publications.index')->withSuccess('Publicación guardado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->withError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        $types = PublicationType::all();
        $categories = PublicationCategory::all();
        $documents = DocumentType::all();
        return view('publications.edit', compact('publication', 'types', 'categories', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $userID = auth()->user()->id;

        try {

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $uuid = strtoupper(\Str::uuid()->toString());
                $fileName = $uuid . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/media/publications/{$userID}";
                $file->move($path, $fileName);
                $input['media'] = "media/publications/{$userID}/" . $fileName;
                $input['media_type'] = $file->getClientMimeType();
                $input['media_size'] = formatedSize(\File::size($path . "/" . $fileName));
                $input['media_name'] =  $file->getClientOriginalName();
                $input['media_uuid'] = $uuid;
                @unlink(public_path() . "/" . $publication->media);
            }

            DB::beginTransaction();
            $publication->update($input);
            DB::commit();
            return redirect()->route('publications.index')->withSuccess('Publicación guardado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        try {
            DB::beginTransaction();
            $publication->delete();
            DB::commit();
            @unlink(public_path() . "/" . $publication->media);
            return redirect()->route('publications.index')->withSuccess('Publicación eliminado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
