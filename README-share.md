# Share Button Script

Ein flexibles, barrierefreies JavaScript für „Teilen“-Buttons mit Unterstützung für:

* Web Share API (native Share-Funktion auf Mobilgeräten)
* Clipboard-Fallback (Link kopieren)
* Toast-Feedback (visuell + Screenreader)
* Mehrstufige Konfiguration (Fallback, global, pro Button, data-Attribute)

---

## ✨ Features

* ♿ Barrierefrei (`aria-live`, keine Fokusprobleme)
* 🔧 Konfigurierbar auf mehreren Ebenen
* 🔗 Dynamische URL-Erweiterung (Anchor + Query-Parameter)
* 🌍 Lokalisierbare Texte (`locallang`)
* 🧩 Wiederverwendbar für beliebig viele Buttons

---

## 🧠 Konfigurations-Priorität

```text
data-Attribute > Button Config > Global Config > JS Fallback
```

---

## 📦 Installation

### 1. Button einfügen

```html
<button class="link-share">
  Teilen
</button>
```

---

### 2. Toast-Element hinzufügen

```html
<div id="toast" role="status" aria-live="polite"></div>
```

---

### 3. Script einbinden

Das JavaScript (siehe unten) auf der Seite einfügen.

---

## 🌍 Globale Konfiguration (optional)

```html
<script id="share-global-config" type="application/json">
{
  "text": "Schau dir das mal an",
  "shareParams": { "utm_source": "newsletter" },
  "locallang": {
    "shareSuccess": "Link wurde geteilt.",
    "shareAborted": "Teilen abgebrochen.",
    "linkCopied": "Link wurde kopiert!",
    "linkCopyError": "Kopieren fehlgeschlagen."
  }
}
</script>
```

---

## 🔘 Button-Konfiguration (optional)

```html
<button class="link-share" data-share-config="share-1">
  Artikel teilen
</button>

<script id="share-1" type="application/json">
{
  "title": "Mein Artikel",
  "url": "https://example.com/artikel"
}
</script>
```

---

## ⚡ Data-Attribute (höchste Priorität)

```html
<button
  class="link-share"
  data-share-title="Quick Share"
  data-share-url="https://example.com"
  data-share-anchor="section1"
  data-share-params='{"ref":"social"}'>
  Teilen
</button>
```

### Unterstützte Attribute

| Attribut            | Beschreibung             |
| ------------------- | ------------------------ |
| `data-share-title`  | Titel                    |
| `data-share-text`   | Text                     |
| `data-share-url`    | URL                      |
| `data-share-anchor` | Anchor (`#section`)      |
| `data-share-params` | JSON für Query-Parameter |

---

## 🔗 URL-Erweiterung

### Anchor (empfohlen)

```html
<button data-share-anchor="pricing">
```

→ Ergebnis:

```
https://example.com#pricing
```

---

### Query-Parameter

```html
<button data-share-params='{"utm_campaign":"spring"}'>
```

→ Ergebnis:

```
https://example.com?utm_campaign=spring
```

---

## 🌍 Lokalisierung (`locallang`)

```json
{
  "locallang": {
    "shareSuccess": "Erfolgreich geteilt",
    "linkCopied": "Kopiert!"
  }
}
```

### Verfügbare Keys

| Key             | Beschreibung         |
| --------------- | -------------------- |
| `shareSuccess`  | Erfolgreiches Teilen |
| `shareAborted`  | Abbruch              |
| `linkCopied`    | Kopieren erfolgreich |
| `linkCopyError` | Fehler beim Kopieren |

---

## ♿ Barrierefreiheit

* `role="status"` + `aria-live="polite"` für Screenreader
* Native `<button>` Elemente
* Kein Fokusverlust
* Funktioniert ohne Maus (Keyboard)

---

## ⚠️ Hinweise

### JSON muss valide sein

❌ Falsch:

```json
{ title: "Test" }
```

✅ Richtig:

```json
{ "title": "Test" }
```

---

### Browser-Support

| Feature       | Support         |
| ------------- | --------------- |
| Web Share API | Mobile Browser  |
| Clipboard API | Moderne Browser |
| Fallback      | Immer vorhanden |

---

## 🚀 Beispiel (komplett)

```html
<button
  class="link-share"
  data-share-title="Cooler Abschnitt"
  data-share-anchor="features">
  Teilen
</button>

<div id="toast" role="status" aria-live="polite"></div>
```

## 📄 Lizenz

Frei verwendbar 👍
