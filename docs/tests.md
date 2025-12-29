# Minimal acceptance tests (manual)

Test 1: Public portal
- Visit /productions/liberty-theatre
- Expect to see performance list (title, category, price)

Test 2: Registration & login (production-specific)
- Register as a new user under Liberty Theatre: name, email, phone, residence, gender, password
- Login and visit profile page; confirm details saved

Test 3: Basket math
- Add performance with price 80, audience_count 50 -> basket total should be 4000

Test 4: Booking creation & payment proof
- Checkout basket -> booking saved with status pending_payment
- Upload payment proof image -> booking status moves to payment_uploaded

Test 5: Production calendar
- Production login -> calendar -> click date with booking -> see user details and payment proof