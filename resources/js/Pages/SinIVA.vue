<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
defineProps({
    egresos: Array,
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
    <Head title="Egresos sin IVA" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Egresos del mes sin IVA:
                {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}
            </h2>
        </template>
        <div>
            <div v-if="egresos.length >= 1">
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Fecha de registro
                            </th>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3">Monto sin IVA</th>
                            <th scope="col" class="px-6 py-3">IVA</th>
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
                                {{ formatearMonto(egreso.amount / 1.16) }}
                            </td>
                            <td class="px-6 py-4">
                                {{
                                    formatearMonto(
                                        egreso.amount - egreso.amount / 1.16
                                    )
                                }}
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
                    <p>No hay egresos registrados para este periodo.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
