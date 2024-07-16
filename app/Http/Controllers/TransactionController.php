<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Helpers\ResponseHelper;
use Exception;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return ResponseHelper::success($transactions);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'user_id' => 'integer|exists:users,id',
                'member_id' => 'integer|exists:members,id',
                'proof_of_payment_url' => 'nullable|file|max:2048|mimes:jpeg,png,pdf',
                'module_id'=> 'required|integer|exists:modules,id'
            ]);

            if ($request->hasFile('proof_of_payment_url')) {
                $validatedData['proof_of_payment_url'] = $request->file('proof_of_payment_url')->store('proof_of_payment');
            }


            $transaction = Transaction::create($validatedData);
            $transaction->modules()->attach($validatedData['module_id']);

            
            return ResponseHelper::success($transaction, 'Transaction created successfully', 201);
        } catch (ValidationException $e) {
            return ResponseHelper::error($e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            return ResponseHelper::success($transaction);
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Transaction not found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'proof_of_payment_url' => 'nullable|file|max:2048|mimes:jpeg,png,pdf',
                'user_id' => 'nullable|integer|exists:users,id',
                'member_id' => 'nullable|integer|exists:members,id',
                'module_id'=> 'required|integer|exists:modules,id'
            ]);

            if ($request->hasFile('proof_of_payment_url')) {
                $validatedData['proof_of_payment_url'] = $request->file('proof_of_payment_url')->store('proof_of_payment');
            }

            $transaction = Transaction::findOrFail($id);
            $transaction->update($validatedData);
            $transaction->modules()->detach();
            $transaction->modules()->attach($validatedData['module_id']);

            return ResponseHelper::success($transaction, 'Transaction updated successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Transaction not found', 404);
        } catch (ValidationException $e) {
            return ResponseHelper::error($e->errors(), 422);
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return ResponseHelper::success(null, 'Transaction deleted successfully', 204);
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Transaction not found', 404);
        }
    }
}
