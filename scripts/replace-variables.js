const fs = require('fs');
const path = require('path');

const config = require('./project-config.json');

// Liste aller zu scannenden Dateien
function getAllFiles(dir, files = []) {
    const ignoredDirs = [".git", "node_modules"];
    const ignoredFiles = ["README*.*", "LICENSE", "init.*", "package.json", "package-lock.json"];

    fs.readdirSync(dir).forEach((file) => {
        const fullPath = path.join(dir, file);

        if (fs.statSync(fullPath).isDirectory()) {
            if (!ignoredDirs.includes(file)) {
                getAllFiles(fullPath, files);
            }
        } else {
            ignoredFiles.forEach(ignoredFile => {
                if (!file.toLowerCase().includes(ignoredFile.toLowerCase())) {
                    files.push(fullPath);
                }
            })
        }
    });

    return files;
}


function escapeRegExp(string) {
  return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function replaceVariables(filePath, variables) {
  let content = fs.readFileSync(filePath, 'utf8');
  let modified = false;

  for (const [key, value] of Object.entries(variables)) {
    const placeholder = `{{${key}}}`;
    const regex = new RegExp(escapeRegExp(placeholder), 'g');

    if (regex.test(content)) {
      content = content.replace(regex, value);
      modified = true;
    }
  }

  if (modified) {
    fs.writeFileSync(filePath, content, 'utf8');
    console.log(`✅ Ersetzt in: ${filePath}`);
  }
}

const files = getAllFiles(path.resolve('.'));
files.forEach(file => replaceVariables(file, config));
