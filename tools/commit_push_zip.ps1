param(
  [string]$Message = "Update",
  [string]$Branch = "main",
  [string]$Remote = "https://github.com/dewecorp/mypos"
)
Set-Location -Path (Split-Path -Parent $PSCommandPath) | Out-Null
Set-Location -Path ".." | Out-Null
git remote set-url origin $Remote
git add -A
git commit -m $Message
git push origin $Branch
$ts = Get-Date -Format "yyyyMMdd-HHmmss"
$zip = "mypos-$ts.zip"
Compress-Archive -Path ".\*" -DestinationPath ".\$zip" -Force
Write-Host "Committed and pushed to $Remote ($Branch). Zip created: $zip"
