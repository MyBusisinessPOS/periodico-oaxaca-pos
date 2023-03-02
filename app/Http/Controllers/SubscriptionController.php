<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Plan;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'unsubscribed']);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionRequest $request)
    {
        try {
            DB::beginTransaction();
            $plan = Plan::where('slug', $request->plan)->firstOrFail();
            $user = $request->user();
            if ($request->user()->hasActiveSubscription()) {
                if (!$request->user()->hasPaidSubscription()) {
                    throw new Exception('Existe una suscripción por pagar.');
                } else {
                    $user->subscription()->update([
                        'active_until' => now()->addDays($plan->duration_in_days),
                        'plan_id' => $plan->id,
                        'is_paid' => 0,
                    ]);
                }
            } else {

                if (isset($user->subscription)) {
                    if (!$request->user()->hasPaidSubscription()) {
                        throw new Exception('Existe una suscripción por pagar.');
                    } else {
                        $user->subscription()->update([
                            'active_until' => now()->addDays($plan->duration_in_days),
                            'plan_id' => $plan->id,
                            'is_paid' => 0,
                        ]);
                    }
                    
                } else {
                    Subscription::create([
                        'active_until' => now()->addDays($plan->duration_in_days),
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('home')->withSuccess("Gracias {$user->name}. Tu tienes una subscripcion {$plan->title}. 
            Para continuar con tu solicitud de suscripción le proporcionamos un correo electrónico para que nos envié su comprobante de pago para poder habilitar su plan y comenzar a usarla.
            Correo: documentooficial@oaxaca.com.mx");
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->route('subscribe.show')->withErrors('No pudimos comprobar tu subscripción, intenta de nuevo!');
        }
    }

    /**-
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('subscribe')->with([
            'plans' => Plan::all(),
            'plan_id' => auth()->user()->subscription->plan_id ?? null,
        ]);
    }
}
