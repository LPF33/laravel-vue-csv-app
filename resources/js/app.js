import "./bootstrap";

import { createApp } from "vue";

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

/* import specific icons */
import {
    faTableList,
    faChartColumn,
    faFileCsv,
    faFileCirclePlus,
    faDownload,
    faFilter,
    faFloppyDisk,
} from "@fortawesome/free-solid-svg-icons";

/* add icons to the library */
library.add(
    faTableList,
    faChartColumn,
    faFileCsv,
    faFileCirclePlus,
    faDownload,
    faFilter,
    faFloppyDisk
);

import App from "./App.vue";

createApp(App).component("font-awesome-icon", FontAwesomeIcon).mount("#app");
