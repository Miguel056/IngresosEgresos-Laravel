<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    ordenados: Array,
    mes: String,
    year: String,
});
const formatearMonto = (monto) => {
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    });
    return formatter.format(monto);
};
</script>
<template>
    <Head title="Rayado diario" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rayado diario del mes {{ mes }} {{ year }}
            </h2>
        </template>
        <div v-if="ordenados.length >= 1">
            <div class="mt-4 flex sm:justify-center items-center">
                <Link :href="route('see.historialB')">
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    >
                        Regresar
                    </button>
                </Link>
            </div>
            <div>
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">
                                Fecha de registro
                            </th>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3">Ingreso</th>
                            <th scope="col" class="px-6 py-3">Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b" v-for="(orden, i) in ordenados">
                            <td class="px-6 py-4">{{ i + 1 }}</td>
                            <td class="px-6 py-4">
                                {{
                                    new Date(
                                        orden.registration_date + ",01:00:00"
                                    ).toLocaleString("default", {
                                        month: "long",
                                        year: "numeric",
                                        day: "numeric",
                                        timezone: "UTC",
                                    })
                                }}
                            </td>
                            <td class="px-6 py-4">
                                {{ orden.description }}
                            </td>
                            <td class="px-6 py-4 text-lime-500">
                                <div v-if="orden.amount > 0">
                                    {{ formatearMonto(orden.amount) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-red-600">
                                <div v-if="orden.amount < 0">
                                    {{ formatearMonto(orden.amount) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            v-else
            class="mt-6 flex sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <p>No hay datos registrados para este periodo.</p>
                <Link :href="route('see.historialB')">
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    >
                        Regresar
                    </button>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
