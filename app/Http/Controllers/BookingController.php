<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Show booking form
    public function index()
    {
        $categories = RoomCategory::all();
        $disabledDates = $this->getFullyBookedDates();
        
       return view('booking.index', compact('categories', 'disabledDates'));

    }

    // Store new booking
    public function store(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^01[0-9]{9}$/',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after:from_date',
            'room_category_id' => 'required|exists:room_categories,id'
        ], [
            'phone.regex' => 'Phone must be 11 digits starting with 01 (e.g., 01712345678)',
            'from_date.after_or_equal' => 'Check-in date cannot be in the past',
            'to_date.after' => 'Check-out date must be after check-in date'
        ]);

        // Parse dates
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $nights = $fromDate->diffInDays($toDate);

        // Get selected room category
        $category = RoomCategory::findOrFail($request->room_category_id);

        // Check availability (3 rooms per category per day)
        if (!$this->checkAvailability($request->room_category_id, $fromDate, $toDate)) {
            return back()
                ->with('error', 'No rooms available for selected dates in this category.')
                ->withInput();
        }

        // Calculate base price
        $basePrice = $category->base_price * $nights;

        // Calculate weekend surcharge (20% on Friday and Saturday)
        $weekendSurcharge = $this->calculateWeekendSurcharge($category->base_price, $fromDate, $toDate);

        // Calculate subtotal
        $subtotal = $basePrice + $weekendSurcharge;

        // Apply 10% discount for 3+ nights
        $discount = 0;
        if ($nights >= 3) {
            $discount = $subtotal * 0.10;
        }

        // Calculate final price
        $finalPrice = $subtotal - $discount;

        // Create booking record
        $booking = Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'room_category_id' => $request->room_category_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'nights' => $nights,
            'base_price' => $basePrice,
            'weekend_surcharge' => $weekendSurcharge,
            'discount' => $discount,
            'final_price' => $finalPrice
        ]);

        // Redirect to thank you page
        return redirect()->route('thankyou', $booking->id);
    }

    // Show thank you page
    public function thankyou($id)
    {
        $booking = Booking::with('roomCategory')->findOrFail($id);
        return view('booking.thankyou', compact('booking'));
    }

    // Check if rooms are available for selected dates
    private function checkAvailability($categoryId, $fromDate, $toDate)
    {
        $current = $fromDate->copy();

        // Check each day in the date range
        while ($current->lt($toDate)) {
            $bookedCount = Booking::where('room_category_id', $categoryId)
                ->where('from_date', '<=', $current->toDateString())
                ->where('to_date', '>', $current->toDateString())
                ->count();

            // If 3 or more rooms are booked, no availability
            if ($bookedCount >= 3) {
                return false;
            }

            $current->addDay();
        }

        return true;
    }

    // Calculate weekend surcharge (20% extra on Friday and Saturday)
    private function calculateWeekendSurcharge($basePrice, $fromDate, $toDate)
    {
        $surcharge = 0;
        $current = $fromDate->copy();

        while ($current->lt($toDate)) {
            // Carbon: Friday = 5, Saturday = 6
            if ($current->dayOfWeek == 5 || $current->dayOfWeek == 6) {
                $surcharge += $basePrice * 0.20;
            }
            $current->addDay();
        }

        return $surcharge;
    }

    // Get fully booked dates for next 90 days
    private function getFullyBookedDates()
    {
        $fullyBooked = [];
        $categories = RoomCategory::all();
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(90);

        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $allCategoriesBooked = true;

            // Check if all categories are fully booked on this date
            foreach ($categories as $category) {
                $bookedCount = Booking::where('room_category_id', $category->id)
                    ->where('from_date', '<=', $current->toDateString())
                    ->where('to_date', '>', $current->toDateString())
                    ->count();

                if ($bookedCount < 3) {
                    $allCategoriesBooked = false;
                    break;
                }
            }

            if ($allCategoriesBooked) {
                $fullyBooked[] = $current->toDateString();
            }

            $current->addDay();
        }

        return $fullyBooked;
    }
    
}