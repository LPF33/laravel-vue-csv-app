export type THeader = string[];
export interface IRowData {
    [key: string]: string;
}
export interface AxiosReponse {
    header: THeader;
    body: IRowData[];
    error?: string;
}

export type TToggleMenu = "table" | "chart" | "add" | "upload";

export interface IUpdateValueEmit {
    rowIndex: number;
    columnName: keyof IRowData;
    columnData: string;
}

export interface IDataRowIndex {
    index: number;
    data: IRowData;
}

export type TFilterChart =
    | "Geschlecht"
    | "Hersteller"
    | "Herstellung"
    | "Material"
    | "Ursprungsland";

export interface TEmbedAddDataSFCProps {
    open: boolean;
    index: number;
    data: IRowData | undefined;
}

export type TVueEmit = (event: string, ...args: unknown[]) => void;
