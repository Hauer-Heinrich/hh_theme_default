### PowerShell Script
### Simple search and Replace strings
### Replaces folloing strings:
### {{EXTENSION_KEY}}            with e. g. your input like: hh_theme_default
### {{EXTENSION_VENDOR}}         with e. g. HauerHeinrich
### {{EXTENSION_NAMESPACE}}      with e. g. HhThemeDefault
### {{EXTENSION_NAMESPACE_ES6}}  with e. g. {{EXTENSION_NAMESPACE_ES6}}
### {{EXTENSION_DOMAIN_NAME}}    with e. g. your input like: my-domain
### {{EXTENSION_DOMAIN_TLD}}     with e. g. your input like: com
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
str_search_replace -searchString "{{EXTENSION_KEY}}" -replaceString $extensionKey
Write-Host "Extension key replacement: done." -ForegroundColor DarkGreen

### Replace Vendor
$extensionVendor = Read-Host -Prompt 'Input your TYPO3 extension vendor (e. g. HauerHeinrich)'
str_search_replace -searchString "{{EXTENSION_VENDOR}}" -replaceString $extensionVendor
Write-Host "Extension vendor replacement: done." -ForegroundColor DarkGreen

### Replace NameSpace
$extensionNameSpace = (Get-Culture).TextInfo.ToTitleCase($extensionKey).replace('_', '')
Write-Host $extensionNameSpace
str_search_replace -searchString "{{EXTENSION_NAMESPACE}}" -replaceString $extensionNameSpace
Write-Host "Extension namespace replacement: done ($extensionNameSpace)." -ForegroundColor DarkGreen

### Replace NameSpace ES6
$extensionNameSpaceEs6 = $extensionKey.replace('_', '-')
Write-Host $extensionNameSpaceEs6
str_search_replace -searchString "{{EXTENSION_NAMESPACE_ES6}}" -replaceString $extensionNameSpaceEs6
Write-Host "Extension namespace ES6 replacement: done ($extensionNameSpaceEs6)." -ForegroundColor DarkGreen

### Replace extension name
$extensionName = (Get-Culture).TextInfo.ToLower($extensionKey).replace('_', '')
Write-Host $extensionName
str_search_replace -searchString "{{EXTENSION_NAME}}" -replaceString $extensionName
Write-Host "Extension name replacement: done ($extensionName)." -ForegroundColor DarkGreen

### Replace | Set domain names
$domainName = Read-Host -Prompt 'Input your domain name (e. g. my-domain) WITHOUT TLD!'
$domainTld = Read-Host -Prompt 'Input your domain TLD (e. g. com or de)'
str_search_replace -searchString "{{EXTENSION_DOMAIN_NAME}}" -replaceString $domainName
Write-Host "Domain name replacement: done ($domainName)." -ForegroundColor DarkGreen
str_search_replace -searchString "{{EXTENSION_DOMAIN_TLD}}" -replaceString $domainTld
Write-Host "Domain TLD replacement: done ($domainTld)." -ForegroundColor DarkGreen
