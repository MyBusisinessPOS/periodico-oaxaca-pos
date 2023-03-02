<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignDocumentRequest;
use App\Http\Requests\UpdateSignDocumentRequest;
use App\Models\SignDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SignDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = SignDocument::orderBy('created_at', 'DESC')->paginate(10);
        return view('sign_documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sign_documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSignDocumentRequest $request)
    {
        $input = $request->all();

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $userID = auth()->user()->id;

        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $uuid = strtoupper(\Str::uuid()->toString());
                $fileName = $uuid . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/media/documents/{$userID}";
                $file->move($path, $fileName);
                $input['file'] = "media/documents/{$userID}/" . $fileName;
                $input['file_type'] = $file->getClientMimeType();
                $input['file_size'] = formatedSize(\File::size($path . "/" . $fileName));
                $input['file_name'] =  $file->getClientOriginalName();
                $input['file_uuid'] = $uuid;
            }

            DB::beginTransaction();
            $documents = SignDocument::create($input);
            DB::commit();

            return redirect()->route('sign-documents.index')->withSuccess('Archivo guardado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->withError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SignDocument  $signDocument
     * @return \Illuminate\Http\Response
     */
    public function show(SignDocument $signDocument)
    {
        $signDocument->load('signs');
        if($signDocument->is_signed) {
            return redirect()->route('sign-documents.index');
        }
        return view('sign_documents.show', compact('signDocument'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SignDocument  $signDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(SignDocument $signDocument)
    {
        return view('sign_documents.edit', compact('signDocument'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SignDocument  $signDocument
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSignDocumentRequest $request, SignDocument $signDocument)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $userID = auth()->user()->id;

        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $uuid = strtoupper(\Str::uuid()->toString());
                $fileName = $uuid . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/media/documents/{$userID}";
                $file->move($path, $fileName);
                $input['file'] = "media/documents/{$userID}/" . $fileName;
                $input['file_type'] = $file->getClientMimeType();
                $input['file_size'] = formatedSize(\File::size($path . "/" . $fileName));
                $input['file_name'] =  $file->getClientOriginalName();
                $input['file_uuid'] = $uuid;
                @unlink(public_path() . "/" . $signDocument->file);
            }

            DB::beginTransaction();
            $signDocument->update($input);
            DB::commit();
            return redirect()->route('sign-documents.index')->withSuccess('Archivo guardado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SignDocument  $signDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(SignDocument $signDocument)
    {
        try {
            DB::beginTransaction();
            $signDocument->delete();
            DB::commit();
            @unlink(public_path() . "/" . $signDocument->file);
            return redirect()->route('sign-documents.index')->withSuccess('Archivo eliminado con éxito');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
