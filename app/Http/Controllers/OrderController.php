<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServiceCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['user', 'service.category'])->orderBy('created_at', 'DESC')
            ->where(function ($query) {
                if (auth()->user()->role_id === 2) {
                    $query->where('user_id', auth()->user()->id);
                }
            })
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServiceCategory::with('services')->get();
        Log::info($categories);
        return view('orders.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'service_id' => $request->id,
                'price' => $request->price,
                'quantity' => 1,
                'subtotal' => $request->price,
                'total' => $request->price,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'data' => $order, 'message' => 'Orden guardado con éxito']);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'data' => [], 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (empty($order)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Orden no encontrada']);
        }
        try {

            DB::beginTransaction();
            $order->update(['status' => 'Pagado']);
            DB::commit();
            return response()->json(['success' => true, 'data' => $order, 'message' => 'Orden marcada como pagado con éxito']);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'data' => [], 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
