<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationAdminController extends Controller
{
    public function updateStatus(Request $request, Reservation $reservation)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,dikembalikan',
        ]);

        // Update status
        $reservation->status = $request->status;
        $reservation->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diubah.');
    }
}
