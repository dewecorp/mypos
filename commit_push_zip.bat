@echo off
setlocal
set SCRIPT_DIR=%~dp0
set PS1=%SCRIPT_DIR%tools\commit_push_zip.ps1
set MSG=%~1
set BR=%~2
powershell -ExecutionPolicy Bypass -File "%PS1%" -Message "%MSG%" -Branch "%BR%" -Remote "https://github.com/dewecorp/mypos"
endlocal
