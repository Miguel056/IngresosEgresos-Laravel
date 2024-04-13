<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    amount: 0,
    description: "",
    date: "",
    type: 0,
    file: null,
});

const submit = () => {
    form.post(route("fin.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>
<template>
    <Head title="Registro" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registro de Ingreso y Egreso del mes:
                {{ new Date().toLocaleString("default", { month: "long" }) }}
                {{ new Date().getFullYear() }}
            </h2>
        </template>

        <div
            class="mt-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
        >
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <div class="py-6">
                    <form
                        @submit.prevent="submit"
                        enctype="multipart/form-data"
                        method="POST"
                    >
                        <div>
                            <InputLabel
                                for="type"
                                value="Tipo: Ingreso/Egreso"
                            />
                            <select name="type" id="type" v-model="form.type">
                                <option value="0" selected>Ingreso</option>
                                <option value="1">Egreso</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="amount" value="Cantidad" />
                            <TextInput
                                id="amount"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.amount"
                                required
                                autofocus
                                autocomplete="amount"
                                name="amount"
                                step="0.01"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Descripción" />
                            <TextInput
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                                autofocus
                                autocomplete="description"
                                name="description"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="date" value="Fecha" />
                            <TextInput
                                id="date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                                autocomplete="date"
                                name="registration_date"
                            />
                        </div>

                        <div class="mt-4" v-if="form.type == 1">
                            <InputLabel
                                for="date"
                                value="Comprobante de egreso"
                            />
                            <input
                                id="file"
                                type="file"
                                class="mt-1 block w-full"
                                autofocus
                                name="file"
                                @input="form.file = $event.target.files[0]"
                                accept=".jpg, .jpeg, .png, .pdf, .gif, .tiff"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Registrar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
