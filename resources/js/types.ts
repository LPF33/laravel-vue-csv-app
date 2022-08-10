export type HeaderTuple = [
    "Hauptartikelnr",
    "Artikelname",
    "Hersteller",
    "Beschreibung",
    "Materialangaben",
    "Geschlecht",
    "Produktart",
    "Ärmel",
    "Bein",
    "Kragen",
    "Herstellung",
    "Taschenart",
    "Grammatur",
    "Material",
    "Ursprungsland",
    "Bildname"
];

export interface IArticle {
    Hauptartikelnr: string;
    Artikelname: string;
    Hersteller: string;
    Beschreibung: string;
    Materialangaben: string;
    Geschlecht: string;
    Produktart: string;
    Ärmel: string;
    Bein: string;
    Kragen: string;
    Herstellung: string;
    Taschenart: string;
    Grammatur: string;
    Material: string;
    Ursprungsland: string;
    Bildname: string;
}

export interface AxiosReponse {
    header: HeaderTuple;
    body: IArticle[];
}

export type TToggleMenu = "table" | "chart";
