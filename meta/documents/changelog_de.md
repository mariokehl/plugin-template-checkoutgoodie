# Versionshinweise für "Gratiszugabe im Warenkorb anzeigen"

## v1.1.0 (09.01.2023)

### Hinzugefügt
- Es kann eine Staffelung von mehreren Gratiszugaben erfolgen, z.B. 50 Euro = Produkt A, 100 Euro = Produkt A + Produkt B, ... Du kannst bis zu 3 Staffeln verwenden
- Du hast nun die Möglichkeit über die Plugin-Konfiguration einzelne Lieferländer vom kostenlosen Versand auszuschließen und die Fortschrittsanzeige somit zu verbergen
- Das Aussehen der Fortschrittsanzeige erlaubt ab sofort vielfältige Individualisierungen: CSS-Klasse(n) für Fehlbetrag und Erfolg (legt die Hintergrundfarbe der Texte und der Fortschrittsanzeige fest), ggf. gestreifte Fortschrittsanzeige, Vorschaubilder + Tooltip der Gratiszugaben
- Unterhalb der Fortschrittsanzeige wurde ein Text-Platzhalter für einen Link oder Erklärung eingebaut

## v1.0.6 (17.11.2022)

### Geändert
- Die Nachrichten der Fortschrittsanzeige wurden in den Bereich **CMS » Mehrsprachigkeit** verschoben, so dass diese übersetzt werden können. Desweiteren kannst du dort nun Emojis oder HTML-Code verwenden

### TODO
- Passe ggf. die Übersetzungen für die Sektion **Individualisierung** des Plugins CheckoutGoodie im Bereich **CMS » Mehrsprachigkeit** an

## v1.0.5 (07.11.2022)

### Behoben
- Gutscheincodes wurden nicht korrekt beim Warenwert (Brutto) berücksichtigt. Dies konnte dazu führen, dass die Gratiszugabe im Frontend angezeigt, aber von der nachgelagerten Ereignisprozedur nicht dem Auftrag hinzugefügt wurde

## v1.0.4 (25.10.2022)

### Behoben
- Deutsche Umlaute in den hinterlegten Nachrichten der Plugin-Konfiguration konnten nicht korrekt angezeigt werden
- Die Fortschrittsanzeige wurde beim erstmaligen Öffnen der Warenkorbvorschau nicht aktualisiert

## v1.0.3 (17.10.2022)

### Geändert
- Die Installationsanleitung der Container-Verknüpfungen wurde aufgrund von User Feedback erweitert

## v1.0.2 (05.10.2022)

### Geändert
- Vorschaubilder des Plugins hinsichtlich Plugin-Konfiguration aktualisiert und die Hinweise der letzten Version korrigiert

## v1.0.1 (30.09.2022)

### Hinzugefügt
- Neue Checkbox **Aktiv** in der Plugin-Konfiguration für die Steuerung der Ausgabe
- Die Nachrichten über der Fortschrittsanzeige sind jetzt ebenfalls in der Konfiguration unter **Individualisierung** anpassbar

### TODO
- Überprüfe die Plugin-Konfiguration und setze den Schalter **Aktiv**, um die Ausgabe der Gratiszugabe zu aktivieren

## v1.0.0 (14.09.2022)

### Hinzugefügt
- Erstveröffentlichung
