<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ Auth;

class BookingController extends Controller
{
    public function showTrip($id)
    {
        $trip = Trip::with(['route', 'seats'])->findOrFail($id);

        return view('trip-detail', compact('trip'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'customer_name' => 'required|string',
            'phone' => 'required',
            'email' => 'nullable|email',
            'seat_code' => 'required',
            'amount' => 'required|numeric',
        ]);

        // Check if seat is already booked
        $seat = Seat::where('trip_id', $validated['trip_id'])
            ->where('seat_code', $validated['seat_code'])
            ->first();

        if (!$seat || $seat->is_booked) {
            return back()->withErrors(['seat_code' => 'Ghế này đã được đặt']);
        }

        // Create booking
        $booking = Booking::create([
            'trip_id' => $validated['trip_id'],
            'user_id' => Auth::id(),
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'seat_code' => $validated['seat_code'],
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return redirect()->route('booking.checkout', $booking->id);
    }

    public function checkout(Booking $booking)
    {
        return view('checkout', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'method' => 'required|in:credit_card,debit_card,bank_transfer,e_wallet',
            'card_number' => 'nullable|required_if:method,credit_card',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        // Create payment
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method' => $validated['method'],
            'amount' => $booking->amount,
            'status' => 'completed',
            'transaction_id' => 'TXN' . date('YmdHis') . rand(1000, 9999),
        ]);

        // Mark booking as confirmed
        $booking->update(['status' => 'confirmed']);

        // Mark seat as booked
        Seat::where('trip_id', $booking->trip_id)
            ->where('seat_code', $booking->seat_code)
            ->update(['is_booked' => true]);

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Thanh toán thành công! Vé của bạn đã được xác nhận.');
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['trip.route', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('my-bookings', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('booking-detail', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'confirmed') {
            return back()->withErrors(['error' => 'Chỉ có thể hủy vé đã xác nhận']);
        }

        // Mark booking as cancelled
        $booking->update(['status' => 'cancelled']);

        // Mark seat as available
        Seat::where('trip_id', $booking->trip_id)
            ->where('seat_code', $booking->seat_code)
            ->update(['is_booked' => false]);

        return back()->with('success', 'Vé đã được hủy. Tiền sẽ hoàn lại trong 3-5 ngày làm việc.');
    }
}
