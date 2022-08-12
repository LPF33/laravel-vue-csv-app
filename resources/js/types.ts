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

export type TFormError = Omit<
    IArticle,
    | "Ärmel"
    | "Bein"
    | "Kragen"
    | "Herstellung"
    | "Taschenart"
    | "Grammatur"
    | "Ursprungsland"
    | "Bildname"
>;

export interface AxiosReponse {
    header: HeaderTuple;
    body: IArticle[];
}

export type TToggleMenu = "table" | "chart" | "add";
