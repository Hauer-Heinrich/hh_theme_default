#!/bin/bash
set -euo pipefail

#############################################
# Colors
#############################################
print_in_color() {
  local color="$1"
  shift
  if [[ -z ${NO_COLOR+x} ]]; then
    printf "%b%b\e[0m\n" "$color" "$*"
  else
    printf "%b\n" "$*"
  fi
}

red()    { print_in_color "\e[31m" "$*"; }
green()  { print_in_color "\e[32m" "$*"; }
yellow() { print_in_color "\e[33m" "$*"; }
blue()   { print_in_color "\e[34m" "$*"; }

#############################################
# Extension Meta
#############################################
EXTENSION_KEY="$(basename "$PWD")"

# hh_theme_birkl → hhthemebirkl
EXTENSION_NAME="$(echo "$EXTENSION_KEY" | tr -d '_')"

# UpperCamelCase Namespace (Bash-native, macOS & Linux safe)
EXTENSION_NAMESPACE=""
for part in ${EXTENSION_KEY//_/ }; do
    first=$(echo "${part:0:1}" | tr '[:lower:]' '[:upper:]')
    rest="${part:1}"
    EXTENSION_NAMESPACE+="$first$rest"
done

# hh_theme_birkl → hh-theme-birkl
EXTENSION_NAMESPACE_ES6="$(echo "$EXTENSION_KEY" | tr '_' '-')"

if [[ "$EXTENSION_KEY" == "{{EXTENSION_KEY}}" ]]; then
    yellow "Consider renaming the folder \"$EXTENSION_KEY\" if you want a custom namespace."
    read -p "Are you sure to proceed anyway (y/n)? " CONFIRMATION
    [[ "$CONFIRMATION" =~ ^[Yy]$ ]] || exit 1
fi

read -p "Enter a vendor name (e.g. HauerHeinrich): " EXTENSION_VENDOR
read -p "Enter a fully qualified domain name (e.g. example.com): " EXTENSION_DOMAIN

EXTENSION_DOMAIN_NAME="${EXTENSION_DOMAIN%.*}"
EXTENSION_DOMAIN_TLD="${EXTENSION_DOMAIN##*.}"
EXTENSION_VENDOR_ES6="$(echo "$EXTENSION_VENDOR" | tr '[:upper:]' '[:lower:]')"

#############################################
# Show config
#############################################
echo
blue "Configuration:"
echo "EXTENSION_KEY:           $EXTENSION_KEY"
echo "EXTENSION_VENDOR:        $EXTENSION_VENDOR"
echo "EXTENSION_NAME:          $EXTENSION_NAME"
echo "EXTENSION_NAMESPACE:     $EXTENSION_NAMESPACE"
echo "EXTENSION_VENDOR_ES6:    $EXTENSION_VENDOR_ES6"
echo "EXTENSION_NAMESPACE_ES6: $EXTENSION_NAMESPACE_ES6"
echo "EXTENSION_DOMAIN_NAME:   $EXTENSION_DOMAIN_NAME"
echo "EXTENSION_DOMAIN_TLD:    $EXTENSION_DOMAIN_TLD"
echo

read -p "Proceed with this configuration (y/n)? " CONFIRMATION
[[ "$CONFIRMATION" =~ ^[Yy]$ ]] || exit 1

#############################################
# Safety check
#############################################
for var in EXTENSION_KEY EXTENSION_VENDOR EXTENSION_NAME EXTENSION_NAMESPACE EXTENSION_NAMESPACE_ES6 EXTENSION_DOMAIN_NAME EXTENSION_DOMAIN_TLD; do
    if [[ -z "${!var}" ]]; then
        red "ERROR: $var is empty"
        exit 1
    fi
done

#############################################
# Replace placeholders
#############################################
green "Replacing placeholders..."

find . -type f \
    -not -path '*/\.*' \
    \( \
      -iname "*.php" -o \
      -iname "*.xml" -o \
      -iname "*.yaml" -o \
      -iname "*.yml" -o \
      -iname "*.tsconfig" -o \
      -iname "*.typoscript" -o \
      -iname "*.html" -o \
      -iname "*.css" -o \
      -iname "*.js" -o \
      -iname "*.json" -o \
      -iname "*.xlf" -o \
      -iname "*.txt" -o \
      -iname "*.code-workspace" \
    \) \
| while IFS= read -r file; do

    perl -0777 -pi -e "
        s/\{\{EXTENSION_KEY\}\}/$EXTENSION_KEY/g;
        s/\{\{EXTENSION_VENDOR\}\}/$EXTENSION_VENDOR/g;
        s/\{\{EXTENSION_NAME\}\}/$EXTENSION_NAME/g;
        s/\{\{EXTENSION_NAMESPACE\}\}/$EXTENSION_NAMESPACE/g;
        s/\{\{EXTENSION_VENDOR_ES6\}\}/$EXTENSION_VENDOR_ES6/g;
        s/\{\{EXTENSION_NAMESPACE_ES6\}\}/$EXTENSION_NAMESPACE_ES6/g;
        s/\{\{EXTENSION_DOMAIN_NAME\}\}/$EXTENSION_DOMAIN_NAME/g;
        s/\{\{EXTENSION_DOMAIN_TLD\}\}/$EXTENSION_DOMAIN_TLD/g;
    " "$file"

done

#############################################
# Done
#############################################
green "✔ All placeholders replaced successfully."
