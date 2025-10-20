# 🌐 ThemeFunctions JavaScript Plugin

Ein modulares JavaScript-Utility-Plugin mit integriertem **Pub/Sub-System**, **Sticky Events**, und einer einfachen Möglichkeit zur **zentralen Funktionsverwaltung** – perfekt für Webseiten und Projekte, bei denen Namenskonflikte vermieden und Funktionen von überall aus zentral verwaltet werden sollen.

---

## 🚀 Features

- ✅ Zentrale Funktionsregistrierung (`registerFunction`)
- ✅ Globale Funktionsausführung (`callFunction`)
- ✅ Integriertes **Pub/Sub-System**
- ✅ **Sticky Events** – auch späte Subscriber bekommen Events
- ✅ Keine Namenskonflikte durch globalen Namespace (`window.themeFunctions`)
- ✅ Erweiterbar und leichtgewichtig (~2 KB)

---

## 🔧 Installation

1. Plugin-Datei einbinden:

```html
<script src="themeFunctions.js"></script>
```

2. Direkt loslegen:
```javascript
themeFunctions.subscribe("ready", (plugin) => {
    plugin.registerFunction("log", (msg) => console.log(msg));
    plugin.callFunction("log", "Hallo Welt!");
});
```

## 📚 API-Dokumentation
Registriert eine neue benutzerdefinierte Funktion, die später global aufgerufen werden kann.

🌟 registerFunction(name, fn)
```javascript
themeFunctions.registerFunction("sayHello", () => alert("Hallo!"));
```

🌟 callFunction(name, ...args)
Führt eine registrierte Funktion aus.
```javascript
themeFunctions.callFunction("sayHello");
```

📡 subscribe(eventName, callback)
Abonniert ein Event. Funktioniert auch rückwirkend für Sticky-Events.
```javascript
themeFunctions.subscribe("ready", (plugin) => {
    console.log("Plugin ist bereit!");
});
```

📣 publish(eventName, data, sticky = false)
Veröffentlicht ein Event für Subscriber. Optional als Sticky, damit zukünftige Subscriber das Event ebenfalls erhalten.
```javascript
themeFunctions.publish("user:loaded", { userId: 123 }, true);
```

🧩 Core-Funktion: openLink(link, target)
Öffnet einen Link – wahlweise im selben Tab oder in einem neuen Fenster.
```javascript
themeFunctions.openLink("https://example.com", "_blank");
```

📁 Beispiel (HTML)
```html
<script src="themeFunctions.js"></script>
<script>
    themeFunctions.subscribe("ready", (plugin) => {
        plugin.registerFunction("showMessage", () => alert("Hallo aus dem Plugin!"));
        plugin.callFunction("showMessage");
    });
</script>
```

⚖️ Lizenz
GNU GENERAL PUBLIC LICENSE
