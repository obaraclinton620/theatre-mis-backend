\# Theatre MIS API



\## Base URL



Local development:

http://localhost:8000/api



Production (later):

https://yourdomain.com/api



\## Authentication



This API uses Laravel Sanctum token authentication.



\### Register

POST /auth/register



\### Login

POST /auth/login



Response:

{

&nbsp; "user": { ... },

&nbsp; "token": "1|abc123..."

}



\### Using the token

For all protected endpoints, send header:



Authorization: Bearer {token}

Accept: application/json





\## Error Format



Validation error example (422):



{

&nbsp; "message": "The given data was invalid.",

&nbsp; "errors": {

&nbsp;   "email": \["The email field is required."]

&nbsp; }

}



Unauthorized (401):



{

&nbsp; "message": "Unauthenticated."

}



Forbidden (403):



{

&nbsp; "message": "This action is unauthorized."

}





\### Register user

POST /auth/register



Body (JSON):

{

&nbsp; "production\_id": 1,

&nbsp; "full\_name": "Test User",

&nbsp; "email": "test@example.com",

&nbsp; "password": "secret123",

&nbsp; "password\_confirmation": "secret123"

}



\### Login

POST /auth/login



Body:

{

&nbsp; "email": "test@example.com",

&nbsp; "password": "secret123"

}





\### List productions

GET /productions





\### Single production

GET /productions/{slug}





\### Add to basket

POST /basket

Headers:

Authorization: Bearer {token}



Body:

{

&nbsp; "performance\_id": 5,

&nbsp; "audience\_count": 2

}





\### Create booking

POST /bookings

Headers:

Authorization: Bearer {token}



Body:

{

&nbsp; "production\_id": 1,

&nbsp; "notes": "Test booking"

}





\### Upload payment proof

POST /bookings/{id}/upload-proof

Headers:

Authorization: Bearer {token}

Content-Type: multipart/form-data



Form-data:

payment\_proof: image file



{

&nbsp; "booking": {

&nbsp;   "status": "payment\_uploaded",

&nbsp;   "payment\_proof\_url": "/storage/payment\_proofs/xxx.jpg"

&nbsp; }

}





\### Production calendar

GET /productions/{id}/calendar?month=2025-12



{

&nbsp; "month": "2025-12",

&nbsp; "dates": {

&nbsp;   "2025-12-10": "booked",

&nbsp;   "2025-12-11": "available"

&nbsp; }

}



