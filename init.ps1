### PowerShell Script
### Simple search and Replace strings
### Replaces folloing strings:
### hh_theme_default            with e. g. your input like: hh_theme_default
### HauerHeinrich         with e. g. HauerHeinrich
### HhThemeDefault      with e. g. HhThemeDefault
### hh-theme-default  with e. g. hh-theme-default
### test-theme-default    with e. g. your input like: my-domain
### com     with e. g. your input like: com
###
### if you are in the root path of your new extension, run powershell ".\init.ps1"

function str_search_replace
{
    param (
        [string]$searchString,
        [string]$replaceString
    )

    $configFiles = Get-ChildItem . -Include '*.typoscript', '*.tsconfig', '*.php', '*.html', '*.scss', '*.css', '*.js', '*.sql', '*.json', '*.md', '*.config', '*.yaml', '*.xml', '*.xlf', '*.txt', '*.code-workspace' -rec

    foreach ($file in $configFiles)
    {
        # Write-Host $file
        (Get-Content $file.PSPath) |
        Foreach-Object { $_ -replace $searchString, $replaceString } |
        Set-Content $file.PSPath
    }
}

### Replace Extension Key
$extensionKey = Read-Host -Prompt 'Input your TYPO3 extension key (e. g. hh_theme_default)'
str_search_replace -searchString "hh_theme_default" -replaceString $extensionKey
Write-Host "Extension key replacement: done." -ForegroundColor DarkGreen

### Replace Vendor
$extensionVendor = Read-Host -Prompt 'Input your TYPO3 extension vendor (e. g. HauerHeinrich)'
str_search_replace -searchString "HauerHeinrich" -replaceString $extensionVendor
Write-Host "Extension vendor replacement: done." -ForegroundColor DarkGreen

### Replace NameSpace
$extensionNameSpace = (Get-Culture).TextInfo.ToTitleCase($extensionKey).replace('_', '')
Write-Host $extensionNameSpace
str_search_replace -searchString "HhThemeDefault" -replaceString $extensionNameSpace
Write-Host "Extension namespace replacement: done ($extensionNameSpace)." -ForegroundColor DarkGreen

### Replace NameSpace ES6
$extensionNameSpaceEs6 = $extensionKey.replace('_', '-')
Write-Host $extensionNameSpaceEs6
str_search_replace -searchString "hh-theme-default" -replaceString $extensionNameSpaceEs6
Write-Host "Extension namespace ES6 replacement: done ($extensionNameSpaceEs6)." -ForegroundColor DarkGreen

### Replace extension name
$extensionName = (Get-Culture).TextInfo.ToLower($extensionKey).replace('_', '')
Write-Host $extensionName
str_search_replace -searchString "hh_theme_default" -replaceString $extensionName
Write-Host "Extension name replacement: done ($extensionName)." -ForegroundColor DarkGreen

### Replace | Set domain names
$domainName = Read-Host -Prompt 'Input your domain name (e. g. my-domain) WITHOUT TLD!'
$domainTld = Read-Host -Prompt 'Input your domain TLD (e. g. com or de)'
str_search_replace -searchString "test-theme-default" -replaceString $domainName
Write-Host "Domain name replacement: done ($domainName)." -ForegroundColor DarkGreen
str_search_replace -searchString "com" -replaceString $domainTld
Write-Host "Domain TLD replacement: done ($domainTld)." -ForegroundColor DarkGreen
