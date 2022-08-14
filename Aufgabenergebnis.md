# Aufgabenergebnis

## Eingesetzte Technologien / Frameworks

Folgende Technologien / Frameworks setze ich in meinem Projekt ein:

- TypeScript / Vue.js 3
- PHP / Laravel 9

JavaScript beherrsche ich und stelle mich sehr gerne jeder Herausforderung. Allerdings bin ich ein Fan von Typisierung, da sich der Code noch besser strukturien als auch lesen lässt. Auch wenn sich durch die dynamische Typisierung von JavaScript Anwendungn schneller, "unkomplizierter" bauen lassen, bei wachsender Codebasis als auch bei einem größeren Entwicklerteam kann Typescript ein Gewinn sein. Daher wende ich TypeScript gerne an, um Typen zu spezifizieren und mögliche Fehlerquellen zur Laufzeit aufgezeigt zu bekommen. Man macht sich "mehr" Gedanken darüber, wie sieht das Objekt aus, welche Signatur hat jene Funktion, etc. TypeScript übertreibt es zwar auch, aber den Code halte ich für "sauberer". Mit Vue als auch React habe ich schon einige Apps gebaut. Beide Frameworks setze ich gerne ein, um SPA zu bauen. Bei Vue gefällt mir der Aufbau/die Verwendung von Single File Components, Template->Script->Style. Insbesondere durch die Composition API lassen sich nun auch wie in React "Custom Hooks" bzw. Composables erzeugen, um Code über Komponenten hinweg wiederzubenutzen. Der two-way data flow gefällt mir besser als one-way bei React, allerdings durch den Einsatz von State Management vernachlässigbar. Mit solch einem modernen Framework wie Vue lässt sich so eine Frontend-Anwendung besser strukturieren & realisieren. Nebenbei ist Vite als Bundler extrem schnell. Für die Verarbeitung der CSV habe ich nicht Node.js/Express.js benutzt sondern PHP, da ich diese Sprache gerade erlerne. So ist mir diese Aufgabe gerade nützlich, um Laravel als Webframework auszuprobieren, Web- als auch API-Routen zu bauen, die Schritte vom Development bis Deployment zu durchleben, was muss ich wie konfigurieren, welche Möglichkeiten bietet Laravel.

## Eingesetzte 3rd Party Libraries

Ich setze in meinem Projekt die folgenden 3rd Party Libraries ein:

Name | Begründung
--- | ---
[axios.js](https://axios-http.com/docs/intro/) | Automatische Umwandlung von JSON, einfache Handhabung, eingebauter XSRF Schutz
[Chart.js](https://vue-chartjs.org/) | Leichtgewichtige Library, womit einfache Diagramme mit wenig Konfiguration erstellt werden können.
[fontawesome](https://fontawesome.com/icons) | Große Auswahl an Icons und schnelle Einbettung in Vue

---

## Installation / Ausführen des Projektes

Folgende Komponenten müssen lokal installiert sein:

- [nodejs](https://nodejs.org/en/) v16.13.1
- [PHP](https://dotnet.microsoft.com/download) v8
- [Composer](https://getcomposer.org/) v2.3.10

Um das Projekt lokal auszuführen, folgendes in der Commandline / Bash eingeben:

```console
$ git clone git@github.com:LPF33/laravel-vue-csv-app.git
$ cd laravel-vue-csv-app
$ npm install
$ composer install
$ composer run-script post-root-package-install & composer run-script post-create-project-cmd
$ npm run build
$ php artisan serve
```
---

## Bereitstellung

- [Github](https://github.com/LPF33/laravel-vue-csv-app) Repository
- [Heroku](https://laravel-vue3-csv.herokuapp.com/) Demo des Projektes