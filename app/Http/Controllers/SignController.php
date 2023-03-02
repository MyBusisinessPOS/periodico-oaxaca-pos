<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignRequest;
use App\Models\Sign;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\Watermarks\TextWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;
use setasign\Fpdi\Fpdi;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreSignRequest $request)
    {
        $input = $request->all();
        $userID = auth()->user()->id;
        // if (!empty($input['signature'])) {
        //     $input['type'] = "text";
        // }

        if (empty($input['signature']) && !$request->hasFile('media')) {
            return redirect()->back();
        }

        if ($request->hasFile('media')) {
            $input['type'] = "media";
            $id = $input['sign_document_id'];
            $file = $request->file('media');
            $uuid = strtoupper(\Str::uuid()->toString());
            $fileName =  $uuid . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/media/signs/{$userID}/{$id}";
            $file->move($path, $fileName);
            $input['media'] = "media/signs/{$userID}/{$id}/" . $fileName;
            $input['media_type'] = $file->getClientMimeType();
            $input['media_size'] = formatedSize(\File::size($path . "/" . $fileName));
            $input['media_name'] =  $file->getClientOriginalName();
            $input['media_uuid'] = $uuid;
            Sign::create($input);
        }

        if (!empty($input['signature'])) {
            $input['type'] = "text";
            Sign::create($input);
        }
        
        return redirect()->back(); //route('sign-documents.show', ['id' => $input['sign_document_id']]);
    }

    public function signDocument(Request $request)
    {
        $sign = Sign::with('document')
            ->where('sign_document_id', $request->sign_document_id)
            ->whereIn('type', ['media', 'text'])
            ->orderBy('created_at', 'DESC')
            ->get();

        if (empty($sign)) {
            return redirect()->back()->withError("No se encontro el documento a firmar.");
        }

        if($sign[0]->document->is_signed) {
            return redirect()->route('sign-documents.index');
        }

        try {

            $signMedia = $sign->filter(function ($sign) {
                return $sign->type === 'media';
            })->first();

            $signText =  $sign->filter(function ($sign) {
                return $sign->type === 'text';
            })->first();

            if (!empty($signText)) {
                $filePath = public_path($sign[0]->document->file);
                $outputFilePath = public_path($sign[0]->document->file);
                $this->fillPDFFile($filePath, $outputFilePath, $signText->signature, $signMedia->media);
            }

            $sign[0]->document->update([
                'is_signed' => true
            ]);

            return response()->file($sign[0]->document->file);
        } catch (Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fillPDFFile($file, $outputFilePath, $text, $media = null)
    {
        $fpdi = new FPDI;

        $count = $fpdi->setSourceFile($file);
        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("Times", "IB", 15);
            // $fpdi->SetTextColor(153, 0, 153);

            $left = 10;
            $top = 10;
            $text = $text;
            $fpdi->Text($left, $top, $text);
            $fpdi->Image(public_path($media), 190, 3, 16, 16,);
        }
        return $fpdi->Output($outputFilePath, 'F');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function show(Sign $sign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function edit(Sign $sign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sign $sign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sign $sign)
    {
        //
    }
}
