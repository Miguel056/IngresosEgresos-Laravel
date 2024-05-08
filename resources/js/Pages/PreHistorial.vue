<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const form = useForm({
    month: "",
    year: "",
});

const submit = () => {
    form.post(route("see.historia"), {
        onSuccess: () => form.reset,
    });
};
const getYear = (year) => {
    return parseInt(year, 10);
};
const mes = new Date().getMonth();
const yearA = new Date().getFullYear();
</script>
<template>
    <Head title="Historial" />
    <AuthenticatedLayout>
        <template #header>
            <h2>Historial de Ingresos y Egresos</h2>
        </template>
        <div
            class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <div class="py-6">
                    <form @submit.prevent="submit" method="POST">
                        <div>
                            <InputLabel
                                for="year"
                                value="Ingrese el año a buscar"
                            />
                            <TextInput
                                id="year"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.year"
                                name="year"
                                required
                            />
                        </div>
                        <div class="mt-4">
                            <InputLabel
                                for="month"
                                value="Ingrese el mes a buscar"
                            />
                            <select
                                name="month"
                                id="month"
                                v-model="form.month"
                                class="mt-1 block w-full"
                                required
                            >
                                <option
                                    value="january"
                                    v-if="0 < mes || getYear(form.year) < yearA"
                                >
                                    Enero
                                </option>
                                <option
                                    value="february"
                                    v-if="1 < mes || getYear(form.year) < yearA"
                                >
                                    Febrero
                                </option>
                                <option
                                    value="march"
                                    v-if="2 < mes || getYear(form.year) < yearA"
                                >
                                    Marzo
                                </option>
                                <option
                                    value="april"
                                    v-if="3 < mes || getYear(form.year) < yearA"
                                >
                                    Abril
                                </option>
                                <option
                                    value="may"
                                    v-if="4 < mes || getYear(form.year) < yearA"
                                >
                                    Mayo
                                </option>
                                <option
                                    value="june"
                                    v-if="5 < mes || getYear(form.year) < yearA"
                                >
                                    Junio
                                </option>
                                <option
                                    value="july"
                                    v-if="6 < mes || getYear(form.year) < yearA"
                                >
                                    Julio
                                </option>
                                <option
                                    value="august"
                                    v-if="7 < mes || getYear(form.year) < yearA"
                                >
                                    Agosto
                                </option>
                                <option
                                    value="september"
                                    v-if="8 < mes || getYear(form.year) < yearA"
                                >
                                    Septiembre
                                </option>
                                <option
                                    value="october"
                                    v-if="9 < mes || getYear(form.year) < yearA"
                                >
                                    Octubre
                                </option>
                                <option
                                    value="november"
                                    v-if="
                                        10 < mes || getYear(form.year) < yearA
                                    "
                                >
                                    Noviembre
                                </option>
                                <option
                                    value="december"
                                    v-if="
                                        11 < mes || getYear(form.year) < yearA
                                    "
                                >
                                    Diciembre
                                </option>
                            </select>
                        </div>
                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Buscar
                            </PrimaryButton>
                            <Link :href="route('see.actual')">
                                <button
                                    class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                >
                                    Mes actual
                                </button>
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
