param(
  [string]$Message,
  [string]$Branch,
  [string]$Remote = "https://github.com/dewecorp/mypos"
)

$repoRoot = Resolve-Path (Join-Path (Split-Path -Parent $PSCommandPath) "..")
Set-Location -Path $repoRoot | Out-Null

try {
  git rev-parse --is-inside-work-tree | Out-Null
} catch {
  Write-Host "Directory is not a git repository." -ForegroundColor Red
  exit 1
}

# Ensure origin remote
if ($Remote) {
  git remote set-url origin $Remote | Out-Null
}

# Detect current branch if not provided
if (-not $Branch -or $Branch -eq "") {
  $Branch = git rev-parse --abbrev-ref HEAD
}
if (-not $Branch -or $Branch -eq "") { $Branch = "main" }

# Ask for commit message if not provided
if (-not $Message -or $Message -eq "") {
  $Message = Read-Host "Masukkan pesan commit"
  if (-not $Message -or $Message -eq "") {
    $Message = "Update " + (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
  }
}

# Stage, commit, rebase-pull, push
git add -A
git commit -m "$Message"
git fetch origin $Branch
git pull --rebase origin $Branch
git push -u origin $Branch

# Zip artifact with timestamp
$ts = Get-Date -Format "yyyyMMdd-HHmmss"
$zip = "mypos-$ts.zip"
Compress-Archive -Path ".\*" -DestinationPath ".\$zip" -Force
Write-Host "Committed: $Message" -ForegroundColor Green
Write-Host "Pushed to $Remote ($Branch). Zip created: $zip" -ForegroundColor Green
