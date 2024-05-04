<script setup>
import { Head, useForm } from "@inertiajs/vue3";
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
                                <option value="january" selected>Enero</option>
                                <option value="february">Febrero</option>
                                <option value="march">Marzo</option>
                                <option value="april">Abril</option>
                                <option value="may">Mayo</option>
                                <option value="june">Junio</option>
                                <option value="july">Julio</option>
                                <option value="august">Agosto</option>
                                <option value="september">Septiembre</option>
                                <option value="october">Octubre</option>
                                <option value="november">Noviembre</option>
                                <option value="december">Diciembre</option>
                            </select>
                        </div>
                        <div class="mt-4">
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
                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Buscar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
