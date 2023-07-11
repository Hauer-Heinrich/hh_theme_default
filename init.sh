#!/bin/bash

set -e

if [[ ! -f ".env" ]]; then
    cp .env.example .env
    echo "ERROR: Please adjust your .env file first!! Then re-run the command again."
    exit 1
fi

source ./.env

EXTENSION_NAME="$(echo "$EXTENSION_KEY" | sed -E 's/_//g')"
EXTENSION_NAMESPACE="$(echo "$EXTENSION_KEY" | sed -E 's/(^|\\<|_)([[:alnum:]])/\U\2/g')"
EXTENSION_NAMESPACE_ES6="$(echo "$EXTENSION_KEY" | sed -E 's/_/-/g')"

echo "Extension file: .env"
echo "EXTENSION_KEY: $EXTENSION_KEY"
echo "EXTENSION_NAME: $EXTENSION_NAME"
echo "EXTENSION_NAMESPACE: $EXTENSION_NAMESPACE"
echo "EXTENSION_NAMESPACE_ES6: $EXTENSION_NAMESPACE_ES6"
echo "EXTENSION_DOMAIN_NAME: $EXTENSION_DOMAIN_NAME"
echo "EXTENSION_DOMAIN_TLD: $EXTENSION_DOMAIN_TLD"

if [[ -n "$EXTENSION_KEY" && -n "$EXTENSION_NAME" && -n "$EXTENSION_NAMESPACE" && -n "$EXTENSION_NAMESPACE_ES6" && -n "$EXTENSION_DOMAIN_NAME" && -n "$EXTENSION_DOMAIN_TLD" ]]; then
    while read file; do
        sed -Ei 's/\{\{EXTENSION_KEY\}\}/'"$EXTENSION_KEY"'/g' "$file"
        sed -Ei 's/\{\{EXTENSION_NAME\}\}/'"$EXTENSION_NAME"'/g' "$file"
        sed -Ei 's/\{\{EXTENSION_NAMESPACE\}\}/'"$EXTENSION_NAMESPACE"'/g' "$file"
        sed -Ei 's/\{\{EXTENSION_NAMESPACE_ES6\}\}/'"$EXTENSION_NAMESPACE_ES6"'/g' "$file"
        sed -Ei 's/\{\{EXTENSION_DOMAIN_NAME\}\}/'"$EXTENSION_DOMAIN_NAME"'/g' "$file"
        sed -Ei 's/\{\{EXTENSION_DOMAIN_TLD\}\}/'"$EXTENSION_DOMAIN_TLD"'/g' "$file"
    done <<< "$(find . -not -path '*/\.*' -type f -iregex '.*\.\(php\|xml\|yaml\|yml\|tsconfig\|typoscript\|html\|css\|js\|json\)$')"
else
    echo "ERROR: Some Extension Variables are empty or invalid."
fi
