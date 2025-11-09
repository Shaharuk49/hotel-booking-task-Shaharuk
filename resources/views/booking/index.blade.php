<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h2>🏨 Hotel Booking System</h2>
                    <p class="text-muted">Book your perfect stay with us</p>
                </div>

                <!-- Error Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Booking Form Card -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf

                            <!-- Personal Information -->
                            <h5 class="mb-3">📝 Personal Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ old('name') }}" required 
                                       placeholder="Enter your full name">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ old('email') }}" required 
                                           placeholder="your@email.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="text" name="phone" class="form-control" 
                                           value="{{ old('phone') }}" required 
                                           placeholder="01XXXXXXXXX" 
                                           pattern="01[0-9]{9}" 
                                           maxlength="11">
                                    <small class="text-muted">Format: 01XXXXXXXXX (11 digits)</small>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Booking Dates -->
                            <h5 class="mb-3">📅 Select Dates</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in Date *</label>
                                    <input type="date" name="from_date" class="form-control" 
                                           value="{{ old('from_date') }}" 
                                           min="{{ date('Y-m-d') }}" 
                                           required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-out Date *</label>
                                    <input type="date" name="to_date" class="form-control" 
                                           value="{{ old('to_date') }}" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                           required>
                                </div>
                            </div>

                            @if(count($disabledDates) > 0)
                            <div class="alert alert-warning mb-3">
                                <strong>⚠️ Fully Booked Dates:</strong><br>
                                <small>
                                    @foreach(array_slice($disabledDates, 0, 5) as $date)
                                        {{ date('d M Y', strtotime($date)) }}@if(!$loop->last), @endif
                                    @endforeach
                                    @if(count($disabledDates) > 5)
                                        and {{ count($disabledDates) - 5 }} more...
                                    @endif
                                </small>
                            </div>
                            @endif

                            <hr class="my-4">

                            <!-- Room Selection -->
<!-- Room Selection -->
<!-- Room Selection -->
<h5 class="mb-3">🛏️ Select Room Category</h5>

<div class="mb-3">
    <label class="form-label">Choose Room Type *</label>
    <select name="room_category_id" class="form-select" required>
        <option value="">-- Select a room category --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                    {{ old('room_category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }} - {{ number_format($category->base_price, 0) }} BDT/night
            </option>
        @endforeach
    </select>
</div>



                            <!-- Pricing Info -->
                            <div class="alert alert-info mt-4">
                                <strong>💰 Pricing Information:</strong><br>
                                <small>
                                    ✓ Weekend surcharge: +20% on Friday & Saturday<br>
                                    ✓ Book 3+ nights: Get 10% discount on total price<br>
                                    ✓ Only 3 rooms available per category per day
                                </small>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                                ✓ Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Room Info Card -->
                <div class="card shadow mt-4">
                    <div class="card-body">
                        <h6 class="card-title">ℹ️ About Our Rooms</h6>
                        <div class="row text-center mt-3">
                            <div class="col-md-4">
                                <div class="info-box">
                                    <strong>Premium Deluxe</strong>
                                    <p class="mb-0">12,000 BDT</p>
                                    <small class="text-muted">Luxury suite</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <strong>Super Deluxe</strong>
                                    <p class="mb-0">10,000 BDT</p>
                                    <small class="text-muted">Comfort room</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <strong>Standard Deluxe</strong>
                                    <p class="mb-0">8,000 BDT</p>
                                    <small class="text-muted">Budget friendly</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>