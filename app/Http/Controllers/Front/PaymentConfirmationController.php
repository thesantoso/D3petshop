<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentConfirmation;
use App\Models\Order;
use App\Models\BankAccount;

class PaymentConfirmationController extends Controller
{
    public function form(Request $request)
    {
        $bank_accounts = BankAccount::all();
        return view('front.pages.payment-confirmation.form', [
            'bank_accounts' => $bank_accounts
        ]);
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|exists:orders,code',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg',
            'bank_account_id' => 'required|exists:bank_accounts,bank_account_id'
        ]);

        $order = Order::where('code', $request->get('code'))->first();

        $payment_proof = $request->file("payment_proof");
        $payment_proof_filename = $order->code.'-'.date('ymdhis').'.'.$payment_proof->extension();
        $payment_proof->storeAs('payment-confirmations', $payment_proof_filename, 'uploads');

        $confirmation = new PaymentConfirmation;
        $confirmation->order_id = $order->order_id;
        $confirmation->payment_proof = $payment_proof_filename;
        $confirmation->bank_account_id = $request->get('bank_account_id');
        $confirmation->save();

        return redirect()
            ->route('front::payment-confirmation.success')
            ->with('confirmation_id', $confirmation->getKey());
    }

    public function success(Request $request)
    {
        $confirmation_id = session('confirmation_id');
        if (!$confirmation_id) {
            return abort(400, "Invalid request");
        }

        return view('front.pages.payment-confirmation.success');
    }
}
