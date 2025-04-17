<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const form = useForm({
    name: "",
    email: "",
    phone: "",
});

function submit() {
    form.post("/customers", {
        onSuccess: () => {
            alert("Cliente creado exitosamente");

            form.reset();
        },
        onError: () => {
            alert("Hubo un error al agregar el cliente");
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Curtomer
            </h2>
        </template>

        <div class="pt-10">
            <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-4">Add Client</h2>
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Name</label>
                        <input
                            v-model="form.name"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            type="text"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Mail</label>
                        <input
                            v-model="form.email"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            type="email"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Phone</label>
                        <input
                            v-model="form.phone"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            type="text"
                            required
                        />
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            Create Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
