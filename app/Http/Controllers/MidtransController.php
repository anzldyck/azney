<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionSuccess;
use App\Transaction;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;



class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // set konfigurasi Midtrans
        config::$serverKey      = config('midtrans.serverKey');
        config::$isProduction   = config('midtrans.isProduction');
        config::$isSanitized    = config('midtrans.isSanitized');
        config::$is3ds          = config('midtrans.is3ds');

        // buat instance midtrans notification
        $notification = new Notification();

        // pecah order ID agar di terima di Database
        $order = explode('-', $notification->order_id);

        // Assign ke variable untuk memudahkan config
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $order[1];

        // cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);

        // handle notification status midtrans
        if($status == 'capture') {
            if($type == 'credit_card') {
                if($fraud == 'challenge') {
                    $transaction->transaction_status = 'CHALLENGE';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        } else if($status == 'settlement') {
            $transaction->transaction_status = 'SUCCESS';
        }
        else if($status == 'pending') {
            $transaction->transaction_status = 'PENDING';
        }
        else if($status == 'deny') {
            $transaction->transaction_status = 'FAILED';
        }
        else if($status == 'expire') {
            $transaction->transaction_status = 'EXPIRED';
        }
        else if($status == 'cancel') {
            $transaction->transaction_status = 'FAILED';
        }

        // simpan Transaksi
       $transaction->save();

        // Kirim Email
        if($transaction)
        {
            if($status == 'capture' && $fraud == 'accept')
            {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            }
             else if($status == 'settlement')
            {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            }
             else if($status == 'success')
            {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            }
             else if($status == 'capture' && $fraud == 'challenge')
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            }
             else 
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Not Settelement'
                    ]
                ]);
            }

             return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Notification Success'
                    ]
            ]);
        }
    }

    public function finishRedirect(Request $request)
    {
        return view('pages.success');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('pages.unfinish');
    }

    public function errorRedirect(Request $request)
    {
        return view('pages.failed');
    }
}
