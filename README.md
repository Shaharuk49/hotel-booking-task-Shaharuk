# Hotel Booking System - Debugger Studio Task

A simple hotel booking system built with Laravel that handles room bookings with dynamic pricing, weekend surcharges, and availability management.

## 🎯 Features

- **3 Room Categories** with different pricing tiers
- **Weekend Pricing** - 20% surcharge on Friday & Saturday
- **Multi-night Discount** - 10% off for 3+ consecutive nights
- **Real-time Availability** - Maximum 3 rooms per category per day
- **Smart Calendar** - Disabled dates when fully booked
- **Email & Phone Validation** - Proper format checking
- **Booking Confirmation** - Detailed thank you page with pricing breakdown

## 📋 Room Categories & Base Pricing

| Category | Base Price (BDT) | Rooms Available |
|----------|------------------|-----------------|
| Premium Deluxe | 12,000 | 3 per day |
| Super Deluxe | 10,000 | 3 per day |
| Standard Deluxe | 8,000 | 3 per day |

## 💰 Pricing Rules

1. **Weekend Surcharge**: +20% on Friday & Saturday
2. **Multi-night Discount**: 10% off total price for 3+ nights
3. **Per-day Calculation**: Each day is calculated separately with appropriate rules

## 🛠️ Technology Stack

- **Framework**: Laravel 11.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Frontend**: Bootstrap 5.3, Blade Templates
- **CSS**: Custom styling with Bootstrap

## 📦 Installation Guide

### Prerequisites

Make sure you have the following installed:
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (optional, for assets)

### Step 1: Clone the Repository
```bash
