# JotnoHealthcare Manual Testing Checklist

Use fictional test data only. Mark a case as passed only after running it against your local application.

| ID | Module | Test | Expected result | Status |
|---|---|---|---|---|
| TC-01 | API | Open `GET /api/test` | HTTP 200 and API working message | Not run |
| TC-02 | Register | Register with valid patient details | HTTP 201; user and token returned | Not run |
| TC-03 | Register | Register with an email already in use | Validation error; no duplicate account | Not run |
| TC-04 | Register | Password and confirmation differ | Validation error | Not run |
| TC-05 | Register | Submit unsupported role | Validation error | Not run |
| TC-06 | Login | Login with correct credentials | HTTP 200; user and token returned | Not run |
| TC-07 | Login | Login with wrong password | HTTP 401 | Not run |
| TC-08 | Auth | Request `GET /api/user` without token | Request rejected as unauthenticated | Not run |
| TC-09 | Auth | Request `GET /api/user` with valid token | Authenticated user returned | Not run |
| TC-10 | Logout | Call logout with valid token | HTTP 200; current token revoked | Not run |
| TC-11 | Medical history | List records without token | Request rejected as unauthenticated | Not run |
| TC-12 | Medical history | Create a record with valid token | HTTP 201; record saved for current user | Not run |
| TC-13 | Medical history | List after creating a record | Newly created record appears | Not run |
| TC-14 | Medical history | Update an owned record | HTTP 200; values updated | Not run |
| TC-15 | Medical history | Delete an owned record | HTTP 200; record no longer appears | Not run |
| TC-16 | Ownership | Try to update/delete another user's record | Record is not accessible (normally 404) | Not run |
| TC-17 | Frontend | Open dashboard without login | Redirect to login | Not run |
| TC-18 | Frontend | Login and open dashboard/profile/history | Authenticated pages load | Not run |
| TC-19 | Frontend | Save/edit/delete medical history in UI | UI reflects server changes | Not run |
| TC-20 | Frontend | Logout and revisit protected page | User is redirected to login | Not run |

## Suggested execution order

1. Start the backend and frontend using the root README instructions.
2. Import `postman/JotnoHealthcare.postman_collection.json` into Postman.
3. Run API health check, register, login, then the authenticated requests.
4. Test the same user journey in the browser.
5. Record actual results, date, tester, and any bug details before submitting the checklist.

## Test evidence template

For each failed case, record: test ID, date/time, steps, input used (fictional only), expected result, actual result, screenshot or response, and issue status.

> This is a test plan, not a claim that all tests have already passed. The supplied project snapshot contains only Laravel example tests; execute the checklist and record real outcomes.
