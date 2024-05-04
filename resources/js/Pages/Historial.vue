<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import html2pdf from "html2pdf.js";
defineProps({
    ingresos: Array,
    egresos: Array,
    mes: String,
    year: String,
    totales: Array,
});
const formatearMonto = (monto) => {
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    });
    return formatter.format(monto);
};

const PDF = () => {
    let element = document.getElementById("pdf");
    let opt = {
        margin: 1,
        filename: "Historial.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 3 },
        jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
    };
    html2pdf().from(element).set(opt).save();
};
</script>
<template>
    <Head title="Historial" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Historial de Ingresos y Egresos
            </h2>
        </template>
        <div v-if="egresos.length >= 1 && ingresos.length >= 1">
            <div class="mt-4 flex flex-col sm:justify-center items-center">
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    @click="PDF()"
                >
                    Exportar PDF
                </button>
            </div>
            <div id="pdf">
                <div
                    v-for="totals in totales"
                    class="mt-4 mb-4 bg-white py-4 flex flex-col sm:justify-center items-center"
                >
                    <h2>
                        Ingresos del periodo {{ mes }} {{ year }}:
                        {{ formatearMonto(totals.total_ingreso) }}
                    </h2>
                </div>
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Fecha de registro
                            </th>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b" v-for="ingreso in ingresos">
                            <td class="px-6 py-4">
                                {{
                                    new Date(
                                        ingreso.registration_date + ",01:00:00"
                                    ).toLocaleString("default", {
                                        month: "long",
                                        year: "numeric",
                                        day: "numeric",
                                        timezone: "UTC",
                                    })
                                }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ingreso.description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ formatearMonto(ingreso.amount) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    v-for="totals in totales"
                    class="mt-4 mb-4 bg-white py-4 flex flex-col sm:justify-center items-center"
                >
                    <h2>
                        Egresos del periodo {{ mes }} {{ year }}:
                        {{ formatearMonto(totals.total_egreso) }}
                    </h2>
                </div>
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Fecha de registro
                            </th>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b" v-for="egreso in egresos">
                            <td class="px-6 py-4">
                                {{
                                    new Date(
                                        egreso.registration_date + ",01:00:00"
                                    ).toLocaleString("default", {
                                        month: "long",
                                        year: "numeric",
                                        day: "numeric",
                                        timezone: "UTC",
                                    })
                                }}
                            </td>
                            <td class="px-6 py-4">
                                {{ egreso.description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ formatearMonto(egreso.amount) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            v-else
            class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <p>No hay datos registrados para este periodo.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
