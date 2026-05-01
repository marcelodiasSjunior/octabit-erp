# OctaBit ERP Rollback Script
# 
# Reverts the 'laravel_app' symlink to the previous release in the releases/ directory.

param (
    [string]$sshUser = "u688664394",
    [string]$sshHost = "147.93.64.215",
    [int]$sshPort = 65002,
    [string]$remoteBaseDir = "domains/octabit.tech"
)

Write-Host "⏪ Starting rollback..." -ForegroundColor Cyan

$sshCommands = @(
    "cd $remoteBaseDir",
    "CURRENT=\$(readlink laravel_app)",
    "PREVIOUS=\$(ls -dt releases/* | grep -v \$CURRENT | head -n 1)",
    "if [ -z \"\$PREVIOUS\" ]; then echo '❌ No previous release found!'; exit 1; fi",
    "ln -sfn \$PREVIOUS laravel_app",
    "echo \"✅ Rolled back from \$CURRENT to \$PREVIOUS\"",
    "cd laravel_app && php artisan optimize:clear",
    "echo '✨ Cache cleared'"
)

$allCommands = $sshCommands -join " && "
ssh -p $sshPort "$sshUser@$sshHost" $allCommands

if ($LASTEXITCODE -eq 0) {
    Write-Host "🎉 Rollback completed successfully!" -ForegroundColor Green
} else {
    Write-Error "Rollback failed!"
}
