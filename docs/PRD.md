# Product Requirements Document (PRD)
Project: Smart Portal Management Information System for Theatre Production
Author: Obara Clinton
Date: YYYY-MM-DD

## Purpose
Provide a simple web-based system that allows theatre productions to manage performances and bookings and allows clients to register per production, add performance bookings to a basket, upload payment proof, and view booking status. One admin will manage multiple productions. Users register per production (Option B) — a user may hold separate accounts under different productions.

## Target users
- Theatre Production (single account per production)
- Client / Booker (registers within a production)
- Platform Admin (manages all productions)

## MVP Features (must have)
1. Production discovery and public portal pages (SEO-friendly slug)
2. User registration/login per production (Option B)
3. User profile: name, email, phone, residence, gender, avatar
4. Performance browsing and categories (high school, junior secondary, church, other)
5. Basket (store multiple selections before checkout)
6. Checkout → create booking; upload payment proof
7. Production calendar view and booking detail modal (click date -> see booking)
8. Basic Admin dashboard to manage productions and subscriptions

## Add-ons (post-MVP)
- Mpesa STK Push integration
- Automated email & WhatsApp notifications
- Vehicle live tracking
- Analytics & reports
- Role granularity inside a production

## Non-functional requirements
- Frontend: React + Tailwind CSS
- Backend: PHP + MySQL (simple MVC or plain PHP)
- Responsive UI: mobile & desktop
- Secure password storage (bcrypt or password_hash)
- Simple deployment to shared host or VPS

## Constraints & Assumptions
- Users register per production; the same personal details can be used for different productions.
- Payment proof will be manual upload for MVP.
- MVP targeted for a single production environment test in Kenya.

## Success metrics (how we measure done)
- A user can register under a production and create a booking with payment proof.
- A production can confirm a booking using the calendar UI.
- Admin can view, suspend or activate productions and see subscription dates.