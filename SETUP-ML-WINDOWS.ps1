$ErrorActionPreference = "Stop"
$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$MlDir = Join-Path $ProjectRoot "ml-service"
$VenvDir = Join-Path $MlDir ".venv"
$TempDir = Join-Path $ProjectRoot ".temp"
$PipCache = Join-Path $ProjectRoot ".pip-cache"

New-Item -ItemType Directory -Force -Path $TempDir, $PipCache | Out-Null
$env:TEMP = $TempDir
$env:TMP = $TempDir
$env:PIP_CACHE_DIR = $PipCache

if (-not (Test-Path (Join-Path $MlDir "requirements.txt"))) {
    throw "Cannot find ml-service/requirements.txt. Run this script from the extracted project folder."
}

if (Test-Path $VenvDir) {
    Remove-Item $VenvDir -Recurse -Force
}

Write-Host "Creating virtual environment inside ml-service..." -ForegroundColor Cyan
py -3.12 -m venv --without-pip $VenvDir
$Python = Join-Path $VenvDir "Scripts\python.exe"
if (-not (Test-Path $Python)) { throw "Virtual environment Python was not created. Check Python 3.12 installation." }

Write-Host "Installing pip..." -ForegroundColor Cyan
& $Python -m ensurepip --upgrade
if ($LASTEXITCODE -ne 0) { throw "ensurepip failed. Check free disk space and the Python installation." }

Write-Host "Installing ML service packages..." -ForegroundColor Cyan
& $Python -m pip install --upgrade pip
if ($LASTEXITCODE -ne 0) { throw "Could not upgrade pip." }
& $Python -m pip install -r (Join-Path $MlDir "requirements.txt")
if ($LASTEXITCODE -ne 0) { throw "Package installation failed. Copy the full error output for troubleshooting." }

Write-Host "ML environment setup completed successfully." -ForegroundColor Green
Write-Host "Start the service with: .\ml-service\.venv\Scripts\python.exe .\ml-service\app.py"
