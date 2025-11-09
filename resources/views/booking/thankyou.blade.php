<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Success Header -->
                <div class="text-center mb-4">
                    <div class="success-icon">✓</div>
                    <h1 class="text-success">Booking Confirmed!</h1>
                    <p class="text-muted">Thank you for choosing our hotel</p>
                </div>

                <!-- Booking Details Card -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">📋 Booking Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Booking ID -->
                        <div class="booking-id mb-4">
                            <span>Booking ID:</span>
                            <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                        </div>

                        <!-- Guest Information -->
                        <h6 class="section-title">👤 Guest Information</h6>
                        <table class="table table-borderless info-table mb-4">
                            <tr>
                                <td width="150"><strong>Name:</strong></td>
                                <td>{{ $booking->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $booking->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $booking->phone }}</td>
                            </tr>
                        </table>

                        <hr>

                        <!-- Room & Stay Details -->
                        <h6 class="section-title">🛏️ Room & Stay Details</h6>
                        <table class="table table-borderless info-table mb-4">
                            <tr>
                                <td width="150"><strong>Room Category:</strong></td>
                                <td>{{ $booking->roomCategory->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Check-in:</strong></td>
                                <td>{{ date('d M Y (l)', strtotime($booking->from_date)) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Check-out:</strong></td>
                                <td>{{ date('d M Y (l)', strtotime($booking->to_date)) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Nights:</strong></td>
                                <td>{{ $booking->nights }} {{ $booking->nights > 1 ? 'nights' : 'night' }}</td>
                            </tr>
                        </table>

                        <hr>

                        <!-- Pricing Breakdown -->
                        <h6 class="section-title">💰 Pricing Breakdown</h6>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Base Price ({{ $booking->nights }} × {{ number_format($booking->roomCategory->base_price, 0) }} BDT)</td>
                                    <td class="text-end">{{ number_format($booking->base_price, 2) }} BDT</td>
                                </tr>
                                
                                @if($booking->weekend_surcharge > 0)
                                <tr class="text-warning">
                                    <td>
                                        <span class="badge bg-warning text-dark">Weekend</span>
                                        Weekend Surcharge (+20%)
                                    </td>
                                    <td class="text-end">+ {{ number_format($booking->weekend_surcharge, 2) }} BDT</td>
                                </tr>
                                @endif

                                @if($booking->discount > 0)
                                <tr class="text-success">
                                    <td>
                                        <span class="badge bg-success">Discount</span>
                                        Multi-night Discount (-10%)
                                    </td>
                                    <td class="text-end">- {{ number_format($booking->discount, 2) }} BDT</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <td><strong>FINAL PRICE</strong></td>
                                    <td class="text-end"><strong>{{ number_format($booking->final_price, 2) }} BDT</strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <hr>

                        <!-- Next Steps -->
                        <div class="alert alert-info mb-0">
                            <h6><strong>📌 Next Steps:</strong></h6>
                            <ol class="mb-0">
                                <li>A confirmation email has been sent to <strong>{{ $booking->email }}</strong></li>
                                <li>Check-in time: <strong>2:00 PM</strong> onwards</li>
                                <li>Check-out time: <strong>11:00 AM</strong></li>
                                <li>Please bring a valid <strong>ID proof</strong> at check-in</li>
                                <li>For queries, call us at: <strong>+880 1234-567890</strong></li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="/" class="btn btn-primary btn-lg me-2">
                        🏠 Book Another Room
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-secondary btn-lg">
                        🖨️ Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>