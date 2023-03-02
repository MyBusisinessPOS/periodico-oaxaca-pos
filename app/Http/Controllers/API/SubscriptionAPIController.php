<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionAPIRequest;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class SubscriptionAPIController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])->get();
        return $this->sendResponse($subscriptions, 'Subscriptions retrievied successfully.');
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionAPIRequest $request)
    {
        try {
            DB::beginTransaction();
            $plan = Plan::where('slug', $request->plan)->firstOrFail();
            $user = User::find($request->user_id);

            if ($user->hasActiveSubscription()) {
                if (!$user->hasPaidSubscription()) {
                    return $this->sendError('Existe una suscripción por pagar.');
                } else {
                    $user->subscription()->update([
                        'active_until' => now()->addDays($plan->duration_in_days),
                        'plan_id' => $plan->id,
                        'is_paid' => 0,
                    ]);
                }
            } else {

                if (isset($user->subscription)) {
                    if (!$user->hasPaidSubscription()) {
                        return $this->sendError('Existe una suscripción por pagar.');
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

            $user->load('subscription.plan');
            $user->hasActiveSubscription = $user->hasActiveSubscription();
            $user->hasPaidSubscription = $user->hasPaidSubscription();

            return $this->sendResponse($user, "Gracias {$user->name}. Tu tienes una subscripcion {$plan->title}. 
            Para continuar con tu solicitud de suscripción le proporcionamos un correo electrónico para que nos envié su comprobante de pago para poder habilitar su plan y comenzar a usarla.
            Correo: documentooficial@oaxaca.com.mx");
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->sendError('No pudimos comprobar tu subscripción, intenta de nuevo!');
        }
    }
}
