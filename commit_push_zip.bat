@echo off
setlocal
set SCRIPT_DIR=%~dp0
powershell -ExecutionPolicy Bypass -File "%SCRIPT_DIR%tools\commit_push_zip.ps1" -Message "%~1" -Branch "%~2" -Remote "https://github.com/dewecorp/mypos"
endlocal
