# Produktinformationen

Mit diesem Plugin ermöglichst du es deinen Kund:innen, ab einem bestimmten Warenkorbwert eine Gratiszugabe zu erhalten, die automatisch in den Warenkorb gelegt und auch dort angezeigt wird. Die Gratiszugabe kann als Variante angelegt und ab einem Warenkorbwert (Brutto) zugewiesen werden.

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

### Individualisierung

| Einstellung                        | Beschreibung |
|------------------------------------|---------------|
| Nachricht Nichterreichen Warenwert | Text bei Nichterreichen des Warenkorbwert, folgende Platzhalter stehen zur Verfügung: `:amount` für den fehlenden Betrag und `:currency` für die Währung. |
| Nachricht Warenwert erreicht       | Text bei Erreichen des Warenkorbwert, d.h. sobald die Gratiszugabe hinzugefügt ist |

Tabelle 1: Konfigurationsoptionen Individualisierung

### Ereignisaktion einrichten

Wie du die Gratiszugabe nach der Auftragsanlage automatisch anhängst ist im **[Handbuch](https://knowledge.plentymarkets.com/de-de/manual/main/artikel/gratiszugaben.html)** beschrieben.

<div class="alert alert-warning" role="alert">
    Achte darauf, dass du für das Plugin und die Ereignisaktion identische Werte hinsichtlich Varianten-ID und Warenkorbwert einrichtest!
</div>


<sub><sup>Jeder einzelne Kauf hilft bei der ständigen Weiterentwicklung und der Umsetzung von Userwünschen. Vielen Dank!</sup></sub>
