<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VuePdfApp from "vue3-pdf-app";
import "vue3-pdf-app/dist/icons/main.css";
//import pdf from "vue-pdf";
//import { onMounted, ref } from "vue";

//const numPages = ref();
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
        <div class="mt-5">
            <vue-pdf-app style="height: 100vh" :pdf="url"></vue-pdf-app>
        </div>
    </AuthenticatedLayout>
</template>
