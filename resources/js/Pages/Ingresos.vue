<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    ingresos: Array,
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
    <Head title="Ingresos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ingresos del mes:
                {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}
            </h2>
        </template>
        <div>
            <div v-if="ingresos.length >= 1">
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
            </div>
            <div
                v-else
                class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
            >
                <div
                    class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
                >
                    <p>No hay ingresos registrados para este periodo.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>