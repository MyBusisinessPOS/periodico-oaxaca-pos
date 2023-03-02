<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::orderBy('active_until', 'ASC')->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
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
        $subscription = Subscription::find($id);

        if(empty($subscription)) {
            if($request->wantsJson()) {
                return response()->json(['success' => false, 'data' => [], 'message' => '¡Suscripción no encontrada.!']);
            }
            return redirect()->back()->withError('¡Suscripción no encontrada.!');
        }

        $subscription->update([
            'is_paid' => true,
            'active_until' => now()->addDays($subscription->plan->duration_in_days),
        ]);

        if($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $subscription, 'message' => '¡Suscripción marcada como pagada y activo para el cliente.!']);
        }

        return redirect()->route('admin-subscriptions.index')->withSuccess('Suscripción marcada como pagada y activo para el cliente.!');

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
