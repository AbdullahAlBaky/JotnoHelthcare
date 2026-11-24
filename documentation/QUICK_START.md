# Quick start (Windows PowerShell)

Extract the ZIP. Open three PowerShell terminals in the extracted `JotnoHealthcare` folder.

**Terminal 1 — ML service**
```powershell
Set-ExecutionPolicy -Scope Process Bypass
.\SETUP-ML-WINDOWS.ps1
.\ml-service\.venv\Scripts\python.exe .\ml-service\app.py
```

**Terminal 2 — Laravel API**
```powershell
cd backend
composer install
Copy-Item .env.example .env
New-Item -ItemType Directory -Force bootstrap\cache,storage\framework\cache\data,storage\framework\sessions,storage\framework\views,storage\framework\testing,storage\logs | Out-Null
New-Item -ItemType File -Force database\database.sqlite | Out-Null
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8000
```
Use `migrate:fresh --seed` only for first setup or when you intentionally want to erase and recreate the local demo database.

**Terminal 3 — Vue app**
```powershell
cd frontend
Copy-Item .env.example .env
npm install
npm run dev
```
Open `http://localhost:5173`. Demo password for all seeded accounts: `password`. The seeder includes multiple fictional doctors, specialists, patients and caregivers, plus sample workflow records. See `README.md` for demo login emails. All sample health data is synthetic and for UI testing only.
