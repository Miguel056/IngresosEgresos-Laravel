<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    totales: Array,
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
    <Head title="Totales" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Finanzas del mes
                {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}
                a la fecha: {{ new Date().getDate() }}
                {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}
            </h2>
        </template>
        <div v-if="totales.length >= 1">
            <div
                v-for="totals in totales"
                class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
            >
                <div
                    class="bg-white shadow-md overflow-hidden sm:rounded-lg py-2 px-6"
                >
                    <div
                        class="grid grid-cols-3 flex flex-col sm:justify-center items-center"
                    >
                        <div>
                            <h1>Cuenta de {{ $page.props.auth.user.name }}</h1>
                        </div>
                        <div></div>
                        <div>
                            <h2>{{ formatearMonto(totals.total) }}</h2>
                        </div>
                        <div class="col-span-2"></div>
                        <div><h3>Saldo disponible</h3></div>
                    </div>
                </div>
            </div>

            <div
                v-for="totals in totales"
                class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
            >
                <div
                    class="bg-white shadow-md overflow-hidden sm:rounded-lg py-2 px-6"
                >
                    <div
                        class="grid grid-cols-3 flex flex-col sm:justify-center items-center"
                    >
                        <div><h1>Tus ingresos</h1></div>
                        <div></div>
                        <div><h2>Tus egresos</h2></div>
                        <div>{{ formatearMonto(totals.total_ingreso) }}</div>
                        <div></div>
                        <div>
                            <h3>{{ formatearMonto(totals.total_egreso) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-for="totals in totales"
                class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
            >
                <div
                    v-if="totals.total == 0"
                    class="bg-white shadow-md overflow-hidden sm:rounded-lg py-2 px-6 border-2 border-stone-950"
                >
                    <div class="flex flex-col sm:justify-center items-center">
                        <p
                            class="mb-3 text-lg text-gray-500 md:text-xl dark:text-black"
                        >
                            Su saldo es 0, sus ingresos e egresos están en
                            equilibrio
                        </p>
                    </div>
                </div>
                <div
                    v-else-if="totals.total < 0"
                    class="bg-white shadow-md overflow-hidden sm:rounded-lg py-2 px-6 border-2 border-rose-500"
                >
                    <div class="flex flex-col sm:justify-center items-center">
                        <p
                            class="mb-3 text-lg text-gray-500 md:text-xl dark:text-black"
                        >
                            Atención, su saldo es negativo, revise sus registros
                        </p>
                    </div>
                </div>
                <div
                    v-else
                    class="bg-white shadow-md overflow-hidden sm:rounded-lg py-2 px-6 border-2 border-green-600"
                >
                    <div class="flex flex-col sm:justify-center items-center">
                        <p
                            class="mb-3 text-lg text-gray-500 md:text-xl dark:text-black"
                        >
                            Felicidades, su saldo es positivo, siga así
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <p class="mb-3 text-lg text-gray-500 md:text-xl dark:text-black">No hay información registrada para el periodo de: {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
