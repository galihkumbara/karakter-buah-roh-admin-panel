<?php

// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'proof_of_payment_url' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'member_id' => 'nullable|integer|exists:members,id',
        ]);

        $transaction = Transaction::create($request->all());

        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'proof_of_payment_url' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'member_id' => 'nullable|integer|exists:members,id',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(null, 204);
    }
}
