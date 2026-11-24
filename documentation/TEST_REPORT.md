# Test report — Academic MVP Foundation

## Checks completed in the build environment
- PHP syntax lint: all backend PHP files checked after the MVP updates.
- ZIP archive integrity: checked after packaging.
- Project structure: backend, frontend, ML service, model artifact and documentation are present.
- The existing PKL model artifact is included unchanged.

## Not executed in this environment
- Full Composer dependency installation / Laravel HTTP integration tests (Composer is unavailable in the build container).
- Vue/Vite production build (npm dependency installation did not complete in the build container).
- Flask runtime prediction endpoint against the serialized model in the target Windows environment.
- End-to-end browser workflow with all five demo accounts.

## Required local verification
1. Follow `INSTALLATION.md` and run migrations plus seeding.
2. Confirm Laravel `/up` returns `{"status":"ok"}`.
3. Confirm Flask `/health` returns model metadata.
4. Sign in with each demo role and verify role-specific navigation and access restrictions.
5. Test patient admission, doctor review, caregiver access request/approval, observations, AI prediction/review, care plans, referrals, report upload and consultation scheduling.

A successful PHP syntax check is not a substitute for full application runtime testing.
