#!/bin/bash

set -e

print_in_color() {
  local color="$1"
  shift
  if [[ -z ${NO_COLOR+x} ]]; then
    printf "$color%b\e[0m\n" "$*";
  else
    printf "%b\n" "$*";
  fi
}

red() { print_in_color "\e[31m" "$*"; }
green() { print_in_color "\e[32m" "$*"; }
yellow() { print_in_color "\e[33m" "$*"; }
blue() { print_in_color "\e[34m" "$*"; }

EXTENSION_KEY="$(basename "$PWD")"
EXTENSION_NAME="$(echo "$EXTENSION_KEY" | sed -E 's/_//g')"
EXTENSION_NAMESPACE="$(echo "$EXTENSION_KEY" | sed -E 's/(^|\\<|_)([[:alnum:]])/\U\2/g')"
EXTENSION_NAMESPACE_ES6="$(echo "$EXTENSION_KEY" | sed -E 's/_/-/g')"

if [[ "$EXTENSION_KEY" == "hh_theme_default" ]]; then
    printf "%s" "$(yellow "Consider renaming the folder \"$EXTENSION_KEY\" if you want a custom namespace. Are you sure to proceed anyway (y/n)? ")"
    read CONFIRMATION
    if [[ ! $CONFIRMATION =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

printf "%s" "Enter a vendor name (e.g. HauerHeinrich): "
read EXTENSION_VENDOR

printf "%s" "Enter a fully qualified domain name (e.g. example.com): "
read EXTENSION_DOMAIN

EXTENSION_DOMAIN_NAME="$(echo "$EXTENSION_DOMAIN" | sed -E 's/(.+)\.(.+)/\1/g')"
EXTENSION_DOMAIN_TLD="$(echo "$EXTENSION_DOMAIN" | sed -E 's/(.+)\.(.+)/\2/g')"

EXTENSION_VENDOR_ES6=$(echo "$EXTENSION_VENDOR" | tr '[:upper:]' '[:lower:]')

printf "\n"
echo "EXTENSION_KEY: $EXTENSION_KEY"
echo "EXTENSION_VENDOR: $EXTENSION_VENDOR"
echo "EXTENSION_NAME: $EXTENSION_NAME"
echo "EXTENSION_NAMESPACE: $EXTENSION_NAMESPACE"
echo "EXTENSION_VENDOR_ES6: $EXTENSION_VENDOR_ES6"
echo "EXTENSION_NAMESPACE_ES6: $EXTENSION_NAMESPACE_ES6"
echo "EXTENSION_DOMAIN_NAME: $EXTENSION_DOMAIN_NAME"
echo "EXTENSION_DOMAIN_TLD: $EXTENSION_DOMAIN_TLD"
printf "\n"

printf "%s" "$(yellow "The configuration above will be used to setup your theme. Are you sure to proceed (y/n)? ")"
read CONFIRMATION
if [[ ! $CONFIRMATION =~ ^[Yy]$ ]]; then
    exit 1
fi

if [[ -n "$EXTENSION_KEY" && -n "$EXTENSION_VENDOR" && -n "$EXTENSION_NAME" && -n "$EXTENSION_NAMESPACE" && -n "$EXTENSION_NAMESPACE_ES6" && -n "$EXTENSION_DOMAIN_NAME" && -n "$EXTENSION_DOMAIN_TLD" ]]; then
    while read file; do
        perl -pi -w -e 's/\{\{EXTENSION_KEY\}\}/'"$EXTENSION_KEY"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_VENDOR\}\}/'"$EXTENSION_VENDOR"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_NAME\}\}/'"$EXTENSION_NAME"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_NAMESPACE\}\}/'"$EXTENSION_NAMESPACE"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_VENDOR_ES6\}\}/'"$EXTENSION_VENDOR_ES6"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_NAMESPACE_ES6\}\}/'"$EXTENSION_NAMESPACE_ES6"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_DOMAIN_NAME\}\}/'"$EXTENSION_DOMAIN_NAME"'/g;' "$file"
        perl -pi -w -e 's/\{\{EXTENSION_DOMAIN_TLD\}\}/'"$EXTENSION_DOMAIN_TLD"'/g;' "$file"

        # sed -Ei 's/\{\{EXTENSION_KEY\}\}/'"$EXTENSION_KEY"'/g' "$file"
        # sed -Ei 's/\{\{EXTENSION_NAME\}\}/'"$EXTENSION_NAME"'/g' "$file"
        # sed -Ei 's/\{\{EXTENSION_NAMESPACE\}\}/'"$EXTENSION_NAMESPACE"'/g' "$file"
        # sed -Ei 's/\{\{EXTENSION_NAMESPACE_ES6\}\}/'"$EXTENSION_NAMESPACE_ES6"'/g' "$file"
        # sed -Ei 's/\{\{EXTENSION_DOMAIN_NAME\}\}/'"$EXTENSION_DOMAIN_NAME"'/g' "$file"
        # sed -Ei 's/\{\{EXTENSION_DOMAIN_TLD\}\}/'"$EXTENSION_DOMAIN_TLD"'/g' "$file"
    done <<< "$(find . -not -path '*/\.*' -type f -iregex '.*\.\(php\|xml\|yaml\|yml\|tsconfig\|typoscript\|html\|css\|js\|json\|xlf\|txt\|code-workspace\)$')"
else
    echo "ERROR: Some Extension Variables are empty or invalid."
fi
