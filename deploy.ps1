# OctaBit ERP Deployment Script
# 
# Pattern: Releases (timestamped folders) with symlink for rollback support
# Path: domains/octabit.tech/releases/YYYYMMDDHHIISS
# Symlink: domains/octabit.tech/laravel_app -> releases/YYYYMMDDHHIISS

param (
    [string]$sshUser = "u688664394",
    [string]$sshHost = "147.93.64.215",
    [int]$sshPort = 65002,
    [string]$remoteBaseDir = "domains/octabit.tech",
    [switch]$skipBuild = $false
)

$timestamp = Get-Date -Format "yyyyMMddHHmmss"
$releaseName = "release-$timestamp"
$zipFile = "$releaseName.zip"
$remoteReleaseDir = "${remoteBaseDir}/releases/${releaseName}"
$remoteSymlink = "${remoteBaseDir}/laravel_app"

Write-Host "Starting deployment of ${releaseName}..." -ForegroundColor Cyan

# 1. Build Assets
if (-not $skipBuild) {
    Write-Host "Building assets..." -ForegroundColor Yellow
    npm run build
    if ($LASTEXITCODE -ne 0) {
        Write-Error "Asset build failed!"
        exit 1
    }
}

# 2. Prepare Zip
Write-Host "Zipping application..." -ForegroundColor Yellow

if (Test-Path $zipFile) { Remove-Item $zipFile }

# Use tar for zipping as it's usually available and handles symlinks/permissions better
tar --exclude-vcs --exclude='node_modules' --exclude='storage/logs/*' --exclude='public_html' --exclude='.env' --exclude='deploy.ps1' --exclude='rollback.ps1' -acvf $zipFile .

# 3. Upload to Server
Write-Host "Uploading to server..." -ForegroundColor Yellow
$remoteDest = "${sshUser}@${sshHost}:${remoteBaseDir}/"
scp -P $sshPort $zipFile $remoteDest

# 4. Extract and Setup
Write-Host "Setting up release on server..." -ForegroundColor Yellow
$sshCommands = @(
    "mkdir -p ${remoteReleaseDir}",
    "unzip -o ${remoteBaseDir}/${zipFile} -d ${remoteReleaseDir}",
    "rm ${remoteBaseDir}/${zipFile}",
    "cp ${remoteBaseDir}/.env ${remoteReleaseDir}/.env",
    "cd ${remoteReleaseDir} && php artisan optimize:clear",
    "cd ${remoteReleaseDir} && php artisan migrate --force",
    "ln -sfn releases/${releaseName} ${remoteSymlink}",
    "echo 'Symlink updated to ${releaseName}'",
    "ls -dt ${remoteBaseDir}/releases/* | tail -n +6 | xargs rm -rf"
)

$allCommands = $sshCommands -join " && "
ssh -p $sshPort "${sshUser}@${sshHost}" $allCommands

Write-Host "Deployment completed successfully!" -ForegroundColor Green
Write-Host "Current release: ${releaseName}"
Write-Host "If you need to rollback, run: .\rollback.ps1"
