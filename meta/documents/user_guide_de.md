# Produktinformationen

Mit diesem Plugin ermöglichst du es deinen Kund:innen, ab einem bestimmten Warenkorbwert eine Gratiszugabe zu erhalten, die automatisch in den Warenkorb gelegt und auch dort angezeigt wird. Die Gratiszugabe kann als Variante angelegt und ab einem Warenkorbwert (Brutto) zugewiesen werden.

## Features

<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Einfache Einrichtung<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Darstellung von Gratiszugaben in Warenkorb(-vorschau) und Kasse<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Auch mehrere Gratiszugaben in Abhängigkeit zu einer Preisstaffelung sind möglich<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Visualisierung des Fehlbetrags bis zum Erreichen der nächsten Gratiszugabe<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Individuelle und lokalisierbare Texte für Fehlbetrag und Erfolg<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Aussehen der Fortschrittsanzeige kann angepasst werden<br> 
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Gutscheine werden in der Berechnung berücksichtigt<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Anzeige für Lieferländer ohne Gratiszugaben ausblenden

## Installationsanleitung

Für die Anzeige der Gratiszugabe musst du die entsprechenden Werte in der Plugin-Konfiguration hinterlegen.

1. Öffne das Menü **Plugins » Plugin-Set-Übersicht**.
2. Wähle das gewünschte Plugin-Set aus.
3. Klicke auf **Gratiszugabe im Warenkorb anzeigen**.<br>→ Eine neue Ansicht öffnet sich.
4. Wähle den Bereich **Allgemein** aus der Liste.
5. Trage deinen gewünschten _Warenkorbwert (Brutto)_ und die _Varianten-ID_ ein.
6. Aktiviere die Checkbox **Aktiv**, damit die Gratiszugabe angezeigt wird
7. **Speichere** die Einstellungen.

<div class="alert alert-info" role="alert">
    Achte darauf, dass bei der zu verknüpfenden Variante ein Variantenname und eine Bildverknüpfung hinterlegt ist.
    Andernfalls wird deine Gratiszugabe mit Dummy-Werten ausgegeben!
</div>

Hinweis: Verwende die Checkbox **Aktiv**, um die Plugin-Ausgabe temporär abzuschalten ohne die Container-Verknüpfungen zu ändern oder das Plugin im Plugin-Set zu deaktivieren.

Danach die Container-Verknüpfungen anlegen, so dass die Gratiszugabe auch im Frontend deines plentyShop angezeigt wird:

1. Wechsel zum Untermenü **Container-Verknüpfungen**.
2. Verknüpfe den Inhalt **Display Goodie after Basket List** mit dem Container **Ceres::Script.AfterScriptsLoaded**
3. Verknüpfe den Inhalt **Display Progress Bar to reach Goodie** mit dem Container **Ceres::Basket.BeforeBasketTotals** zur Anzeige im Warenkorb (_Shopping cart: Before basket totals_)
4. Verknüpfe den Inhalt **Display Progress Bar to reach Goodie** mit dem Container **Ceres::BasketPreview.BeforeBasketTotals** zur Anzeige in der Warenkorbvorschau (_Shopping cart preview: Before basket totals_)
5. Verknüpfe den Inhalt **Display Progress Bar to reach Goodie** mit dem Container **Ceres::Checkout.BeforeBasketTotals** zur Anzeige in der Kasse (_Checkout: Before basket totals_)

### Staffelung / Mehrere Gratiszugaben

Ab sofort ist auch eine Staffelung nach Preisen und entsprechenden Gratiszugaben möglich. Nachstehend mal als einfaches Beispiel:
 
    50 Euro   = Produkt A
    100 Euro  = Produkt A + Produkt B
    200 Euro  = Produkt A + Produkt B + Produkt C

Hinterlege dazu in der Plugin-Konfiguration die entsprechenden Warenwerte und Varianten-IDs in den optionalen Bereichen **Staffel 1** und **Staffel 2**. Wenn du nur zwei Staffeln anbieten möchtest, so kannst du einfach die Eingabefelder für **Staffel 2** leer lassen. Eine Beispiel-Konfiguration für die maximale Ausprägung findest du in den Vorschaubildern des Plugins.

<div class="alert alert-info" role="alert">
    Vergiss nicht, die Filter deiner Ereignisaktion zum Hinzufügen der Gratiszugabe(n) ebenfalls auf die gewünschten Werte anzupassen!
</div>

### Lieferländer ohne Gratiszugaben ausschließen

Bietest du in einem oder mehreren Lieferländern keine Gratiszugaben an, kannst du diese über die Plugin-Konfiguration ausschließen und somit die Ausgabe verhindern.

Öffne dazu die Plugin-Konfiguration und trage im Bereich **Allgemein** im Feld **Ausgenommene Lieferländer** eine kommaseparierte Liste von verbotenen Lieferländern ein, z.B. _3,12_ für Belgien und United Kingdom.

    1=Deutschland
    2=Österreich
    ...
    
Eine vollständige Liste aller Lieferland-IDs findest du unter **Einrichtung » Aufträge » Versand » Optionen** im Tab **Lieferländer**.

<div class="alert alert-info" role="alert">
    Vergiss nicht, die Filter deiner Ereignisaktion zum Hinzufügen der Gratiszugabe(n) ebenfalls auf die gewünschten Werte anzupassen!
</div>

### Individualisierung

Im Menü **CMS » Mehrsprachigkeit** kannst du die Texte unterhalb der Fortschrittsanzeige anpassen. **Speichere** nach der Anpassung und vergiss nicht auf **Veröffentlichen** zu drücken.

| Schlüssel                          | Beschreibung  |
|------------------------------------|---------------|
| MessageMissing | Text bei Nichterreichen des Warenkorbwerts, folgende Platzhalter stehen zur Verfügung: `:amount` für den fehlenden Betrag und `:currency` für die Währung. |
| MessageGoal | Text bei Erreichen des Warenkorbwerts, d.h. sobald die Gratiszugabe hinzugefügt ist |
| MessageInterim | Text bis zum Erreichen der nächsten Gratiszugabe(n), nur relevant bei Staffelungen |
| MessageAdditional | Text-Platzhalter zur Erklärung deiner Sonderaktion oder Bedingungen für die Gratiszugabe |

Tabelle 1: Konfigurationsoptionen Individualisierung

Das Aussehen der Fortschrittsanzeige lässt sich im Bereich **Individualisierung** in der **Plugin-Konfiguration** anpassen.

| Einstellung                        | Beschreibung  |
|------------------------------------|---------------|
| CSS-Klasse für Fehlbetrag | Diese Bootstrap-Klasse erhält deine Fortschrittsanzeige und der Text als Hintergrundfarbe, solange die Gratiszugabe noch nicht hinzugefügt wurde.<br>Wähle Eigene um dies mit deinem Theme zu überschreiben. |
| CSS-Klasse für Erfolg | Diese Bootstrap-Klasse erhält deine Fortschrittsanzeige und der Text als Hintergrundfarbe, sobald die Gratiszugabe hinzugefügt wurde.<br>Wähle Eigene um dies mit deinem Theme zu überschreiben. |
| Textabstand vergrößern | Erlaubt den Abstand von Text zu Fortschrittsanzeige anzuheben. |
| Fortschrittsanzeige gestreift | Fügt der Fortschrittsanzeige die Bootstrap-Klasse .progress-bar-striped hinzu. |
| Vorschaubilder unter der Fortschrittsanzeige | Sollen Thumbnails der Gratiszugabe(n) als zusätzliche Information dargestellt werden? |

Tabelle 2: Plugin-Konfiguration Individualisierung

### Ereignisaktion einrichten

Wie du die Gratiszugabe nach der Auftragsanlage automatisch anhängst ist im **[Handbuch](https://knowledge.plentymarkets.com/de-de/manual/main/artikel/gratiszugaben.html)** beschrieben.

<div class="alert alert-warning" role="alert">
    Achte darauf, dass du für das Plugin und die Ereignisaktion identische Werte hinsichtlich Varianten-ID und Warenkorbwert einrichtest!
</div>


<sub><sup>Jeder einzelne Kauf hilft bei der ständigen Weiterentwicklung und der Umsetzung von Userwünschen. Vielen Dank!</sup></sub>
