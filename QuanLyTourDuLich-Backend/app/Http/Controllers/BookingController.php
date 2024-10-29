<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function BookTour(Request $request) {
        try {
            $validatedData = $request->validate([
                'tour_id' => 'required',
                'customer_id' => 'required',
                'booking_date' => 'required',
                'number_of_people' => 'required',
                'user_id' => 'required',
                'tour_guide_id' => 'required',
            ], [
                'tour_id.unique' => 'co roi',
                'tour_id.required' => 'Account name is required.',
            ]);
        } catch(error) {

        }
    }
}
