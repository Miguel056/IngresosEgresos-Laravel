<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    documento: String,
    url: String,
});
</script>
<template>
    <Head title="Revisar documento" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documento: {{ documento }}
            </h2>
        </template>
        <div class="ml-5">
            <Link
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                :href="route('fin.read.egresos')"
            >
                Regresar
            </Link>
        </div>
        <div
            class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="sm:max-w-md sm:rounded-lg overflow-hidden shadow-md bg-white py-4 px-6 w-full"
            >
                <img :src="url" alt="Comprobante de egresos como imagen" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
