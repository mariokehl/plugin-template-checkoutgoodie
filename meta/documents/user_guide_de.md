# Produktinformationen

Mit diesem Plugin ermöglichst du es deinen Kund:innen, ab einem bestimmten Warenkorbwert eine Gratiszugabe zu erhalten, die automatisch in den Warenkorb gelegt und auch dort angezeigt wird. Die Gratiszugabe kann als Variante angelegt und ab einem Warenkorbwert (Brutto) zugewiesen werden.

## Installationsanleitung

Für die Anzeige der Gratiszugabe musst du die entsprechenden Werte in der Plugin-Konfiguration hinterlegen.

1. Öffne das Menü **Plugins » Plugin-Set-Übersicht**.
2. Wähle das gewünschte Plugin-Set aus.
3. Klicke auf **Gratiszugabe im Warenkorb anzeigen**.<br>→ Eine neue Ansicht öffnet sich.
4. Wähle den Bereich **Allgemein** aus der Liste.
5. Trage deinen gewünschten Warenkorbwert (Brutto) und die Varianten-ID ein.
6. **Speichere** die Einstellungen.

Danach die Container-Verknüpfungen anlegen, so dass die Gratiszugabe auch im Frontend deines plentyShop angezeigt wird:

1. Wechsel zum Untermenü **Container-Verknüpfungen**.
2. Verknüpfe den Inhalt **Display goodie after basket list** mit dem Container **Ceres::Script.AfterScriptsLoaded**
3. Verknüpfe den Inhalt **Display progress bar to reach goodie** mit dem Container **Ceres::Basket.BeforeBasketTotals** zur Anzeige im Warenkorb
4. Verknüpfe den Inhalt **Display progress bar to reach goodie** mit dem Container **Ceres::BasketPreview.BeforeBasketTotals** zur Anzeige in der Warenkorbvorschau
5. Verknüpfe den Inhalt **Display progress bar to reach goodie** mit dem Container **Ceres::Checkout.BeforeBasketTotals** zur Anzeige in der Kasse

### Ereignisaktion einrichten

Wie du die Gratiszugabe nach der Auftragsanlage automatisch anhängst ist im **[Handbuch](https://knowledge.plentymarkets.com/de-de/manual/main/artikel/gratiszugaben.html)** beschrieben.

<div class="alert alert-warning" role="alert">
    Achte darauf, dass du für das Plugin und die Ereignisaktion identische Werte hinsichtlich Varianten-ID und Warenkorbwert einrichtest!
</div>


<sub><sup>Jeder einzelne Kauf hilft bei der ständigen Weiterentwicklung und der Umsetzung von Userwünschen. Vielen Dank!</sup></sub>
