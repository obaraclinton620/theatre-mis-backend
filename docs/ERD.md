# ERD (text sketch) - Simple data model

Tables:

productions
- id (int, PK)
- name (varchar)
- slug (varchar, unique)
- contact_email (varchar)
- whatsapp (varchar)
- subscription_end (date)
- active (tinyint)

users
- id (int, PK)
- production_id (int, FK -> productions.id)
- full_name (varchar)
- email (varchar)
- phone (varchar)
- residence (varchar)
- gender (varchar)
- password_hash (varchar)
- avatar_url (varchar)

performances
- id (int, PK)
- production_id (int, FK)
- title (varchar)
- category (varchar)
- price_per_audience (decimal)
- active (tinyint)

basket_items
- id (int, PK)
- user_id (int, FK -> users.id)
- production_id (int, FK -> productions.id)
- performance_id (int, FK -> performances.id)
- audience_count (int)
- created_at (timestamp)

bookings
- id (int, PK)
- user_id (int, FK)
- production_id (int, FK)
- performance_id (int, FK)
- venue (varchar)
- date (date)
- audience_count (int)
- total_amount (decimal)
- status (varchar) -- pending_payment, payment_uploaded, confirmed, completed, canceled
- payment_proof_url (varchar)
- created_at (timestamp)

admin
- id (int, PK)
- email (varchar)
- password_hash (varchar)