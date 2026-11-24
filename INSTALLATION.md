# Installation and local startup

## Prerequisites
- PHP 8.2+ with PDO SQLite, OpenSSL, Mbstring, Tokenizer, XML, Ctype and JSON extensions
- Composer 2
- Node.js 20+ and npm
- Python 3.12 (the supplied model was serialized with scikit-learn 1.6.1)

## Windows quick setup
Open PowerShell in the extracted `JotnoHealthcare` project folder. Keep each service running in its own terminal.

### 1. Set up the Flask ML service
Run the included setup script from the project root. It creates the virtual environment at `ml-service\.venv` (not in the project root) and redirects temporary files and pip cache to the project drive.

```powershell
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
.\SETUP-ML-WINDOWS.ps1
```

Start Flask in a terminal from the project root:

```powershell
.\ml-service\.venv\Scripts\python.exe .\ml-service\app.py
```

Health check: `http://127.0.0.1:5001/health`.

### 2. Set up Laravel backend

`migrate:fresh --seed` is for a fresh academic demo setup and resets the local SQLite database if run again.
Open another terminal:

```powershell
cd backend
composer install
if (!(Test-Path .env)) { Copy-Item .env.example .env }
New-Item -ItemType Directory -Force -Path bootstrap\cache, storage\framework\cache\data, storage\framework\sessions, storage\framework\views, storage\framework\testing, storage\logs | Out-Null
if (!(Test-Path database\database.sqlite)) { New-Item -ItemType File -Path database\database.sqlite | Out-Null }
php artisan key:generate
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8000
```

Backend health check: `http://127.0.0.1:8000/up` (the API root `/` may return 404 because this is an API backend).

### 3. Set up Vue frontend
Open a third terminal:

```powershell
cd frontend
if (!(Test-Path .env)) { Copy-Item .env.example .env }
npm install
npm run dev
```

Open the Vite URL, normally `http://localhost:5173`.

## macOS/Linux notes
Create the Python environment from the project root with `python3 -m venv ml-service/.venv`, then run `ml-service/.venv/bin/python -m pip install -r ml-service/requirements.txt` and `ml-service/.venv/bin/python ml-service/app.py`. Follow the Laravel and frontend commands using the appropriate shell equivalents.

## Demo accounts
The seeder creates `admin@jotno.test`, `doctor@jotno.test`, `specialist@jotno.test`, `patient@jotno.test`, and `caregiver@jotno.test`; password: `password`. These are synthetic demo accounts. Change credentials before sharing or deployment.

## Important limitations
This is an academic prototype, not a medical device. Model output is a dataset-based preliminary suggestion only; it is not a diagnosis, triage, or treatment recommendation. A qualified clinician must review all information. Do not use this prototype for real patient care or emergencies.

A real embedded video consultation provider still requires provider credentials and configuration.
