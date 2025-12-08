# Feature checklist & Acceptance criteria

## 1. Production discovery & public portals
- Acceptance criteria:
  - GET /productions returns list of productions
  - GET /productions/{slug} returns public page with performances
  - Portal pages accessible via SEO-friendly slugs

## 2. User registration/login (per production)
- Acceptance criteria:
  - User can register for a specific production: name, email, phone, residence, gender, password
  - After registration user can log in to that production
  - Profile page shows the fields and allows editing (except email)

## 3. Basket
- Acceptance criteria:
  - User can add multiple performances from the same production to basket
  - Basket stores performance_id, audience_count, price_per_audience, timestamp
  - User can edit audience_count or remove items
  - Basket persists server-side while user is logged in

## 4. Checkout & Bookings
- Acceptance criteria:
  - User can checkout basket to create booking(s)
  - Total = sum(price_per_audience * audience_count)
  - Booking status initial: pending_payment
  - User can upload payment proof image; booking status changes to payment_uploaded

## 5. Production calendar & booking details
- Acceptance criteria:
  - Production can view month calendar with booked dates highlighted
  - Clicking a date shows bookings with user details, venue, performances, audience_count, payment_proof

## 6. Admin dashboard
- Acceptance criteria:
  - Admin can list productions, view subscription_end dates and toggle active/suspended