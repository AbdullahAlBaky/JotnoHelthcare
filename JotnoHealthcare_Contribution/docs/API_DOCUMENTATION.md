# JotnoHealthcare API Reference

**Base URL (local):** `http://127.0.0.1:8000/api`  
**Format:** JSON  
**Authentication:** Laravel Sanctum bearer token for protected endpoints.

For protected requests, send:

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
Content-Type: application/json
```

## Endpoints

| Method | Endpoint | Auth required | Purpose |
|---|---|---:|---|
| GET | `/test` | No | Check API availability |
| POST | `/register` | No | Create an account |
| POST | `/login` | No | Authenticate and receive token |
| POST | `/logout` | Yes | Revoke current access token |
| GET | `/user` | Yes | Return authenticated user |
| GET | `/medical-histories` | Yes | List current user's records |
| POST | `/medical-histories` | Yes | Create a medical history record |
| PUT | `/medical-histories/{id}` | Yes | Update an owned record |
| DELETE | `/medical-histories/{id}` | Yes | Delete an owned record |

## 1. Health check

`GET /test`

Successful response:

```json
{
  "success": true,
  "message": "JotnoHealthcare API is working!"
}
```

## 2. Register

`POST /register`

Request body:

```json
{
  "name": "Demo Patient",
  "email": "patient@example.com",
  "phone": "01700000000",
  "role": "patient",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Validation: name required (max 255); email required, valid and unique; phone required (max 20); role must be `patient` or `caregiver`; password required (minimum 8 characters) and must match `password_confirmation`.

Success: HTTP `201`, with `success`, `message`, `user`, and `token` fields. Store the token securely for authenticated API requests.

## 3. Login

`POST /login`

Request body:

```json
{
  "email": "patient@example.com",
  "password": "password123"
}
```

Success: HTTP `200`, with `success`, `message`, `user`, and `token`. Invalid credentials return HTTP `401` with an error message.

## 4. Current user

`GET /user` (authenticated)

Returns the authenticated user's model data. Password and remember token are hidden by the User model.

## 5. Logout

`POST /logout` (authenticated)

Revokes the current Sanctum access token. Successful response is HTTP `200` with `success` and `message`.

## 6. List medical histories

`GET /medical-histories` (authenticated)

Returns HTTP `200` with `success` and `medical_histories`. Results are scoped to the authenticated user and ordered newest first.

## 7. Create medical history

`POST /medical-histories` (authenticated)

All fields below are nullable strings; `blood_group` has a maximum length of 10.

```json
{
  "blood_group": "A+",
  "previous_diseases": "Asthma",
  "allergies": "Dust",
  "current_medications": "None",
  "past_surgeries": "None",
  "family_medical_history": "Diabetes in family",
  "additional_notes": "Demo data only"
}
```

Success: HTTP `201`, with `success`, `message`, and `medical_history`.

## 8. Update medical history

`PUT /medical-histories/{id}` (authenticated)

Send the same fields as create. The controller searches through the authenticated user's `medicalHistories()` relationship, so a user cannot update another user's record through this endpoint. Success: HTTP `200`.

## 9. Delete medical history

`DELETE /medical-histories/{id}` (authenticated)

The controller only finds records belonging to the authenticated user. Success: HTTP `200` with `success` and `message`.

## Common response codes

| Status | Meaning |
|---:|---|
| 200 | Request completed |
| 201 | Resource/account created |
| 401 | Missing/invalid authentication or invalid login credentials |
| 404 | Requested record not found within the current user's records |
| 422 | Validation failed |

Laravel's validation error response includes a `message` and an `errors` object. Exact error details depend on the submitted data.

## Implementation notes / items to verify

- The frontend currently sets its Axios base URL directly to `http://127.0.0.1:8000/api` in `frontend/src/services/api.ts`.
- Registration and login issue Sanctum tokens. Logout deletes the current token.
- The frontend stores authentication data in browser local/session storage. For a production deployment, review token storage and HTTPS/security requirements.
- This document describes the routes and controller code present in the supplied project snapshot; update it if routes or response formats change.
