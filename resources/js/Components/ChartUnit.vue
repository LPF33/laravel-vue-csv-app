<template>
    <div>
        <div id="csv-chart">
            <Pie
                :chart-data="chartData"
                :chart-options="chartOptions"
                :chart-id="chartId"
            />
        </div>
        <div id="chart-filter">
            <button
                v-for="(item, index) in filterValues"
                :key="index"
                @click="filter(item)"
                :class="{ active: activeFilter === item }"
            >
                <font-awesome-icon icon="fa-solid fa-filter" /> {{ item }}
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType, reactive, ref, toRefs, watch } from "vue";
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";
import { IArticle, TFilterChart } from "../types";

ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default defineComponent({
    name: "ChartUni",
    components: { Pie },
    props: {
        table: {
            type: Array as PropType<IArticle[]>,
            required: true,
        },
    },
    setup(props) {
        const filterValues = reactive<TFilterChart[]>([
            "Geschlecht",
            "Hersteller",
            "Herstellung",
            "Material",
            "Ursprungsland",
        ]);

        const activeFilter = ref("");

        const data = reactive({
            chartData: {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [
                            "#03045E",
                            "#023E8A",
                            "#0077B6",
                            "#0096C7",
                            "#00B4D8",
                            "#48CAE4",
                            "#90E0EF",
                            "#ADE8F4",
                            "#CAF0F8",
                            "#eaf2e3",
                            "#fce0ce",
                            "#faf3dd",
                            "#d9f3e2",
                            "#b8f2e6",
                            "#b3e6e3",
                            "#ff8995",
                            "#ff99eb",
                            "#fca1d9",
                            "#fefb6b",
                            "#a385e5",
                        ],
                        data: [],
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                color: "white",
                elements: {
                    arc: {
                        borderWidth: 0,
                    },
                },
            },
            chartId: "pie-chart",
        });

        function filter(str: TFilterChart) {
            activeFilter.value = str;
            const filteredArray = props.table.map((val) => {
                if (!val[str]) {
                    return "Keine Angabe";
                }
                return val[str];
            }) as string[];
            const labels = Array.from(new Set(filteredArray)) as string[];

            const dataValues = filteredArray.reduce((obj, item) => {
                if (Object.prototype.hasOwnProperty.call(obj, item)) {
                    obj[item]++;
                } else {
                    obj[item] = 0;
                }
                return obj;
            }, {} as { [key: string]: number });

            data.chartData.labels = labels as never[];
            data.chartData.datasets[0].data = Object.values(
                dataValues
            ) as never[];
        }

        watch(
            () => props.table,
            () => filter("Herstellung"),
            { immediate: true }
        );

        return { ...toRefs(data), filterValues, filter, activeFilter };
    },
});
</script>

<style scoped>
#chart-filter {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 0 5px;
}

#chart-filter button {
    color: var(--inactive-tab);
    background-color: transparent;
    padding: 5px;
    margin: 5px 0;
    cursor: pointer;
    font-size: 0.9rem;
    border-bottom: 2px solid transparent;
}

#chart-filter button.active {
    color: var(--active-tab);
    border-bottom: 2px solid var(--active-tab);
}

#csv-chart {
    margin: 0 auto;
    max-width: 400px;
}
</style>
