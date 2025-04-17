<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    customers: Array,
});

const form = useForm({
    number: "",
    date: "",
    customer_id: "",
    items: [],
});

const selectedProductName = ref("");
const selectedProductPrice = ref(0);
const selectedQuantity = ref(1);

function addItem() {
    if (!selectedProductName.value || !selectedProductPrice.value) return;

    const productId = form.items.length + 1;

    form.items.push({
        product_id: productId,
        product_name: selectedProductName.value,
        product_price: parseFloat(selectedProductPrice.value),
        quantity: selectedQuantity.value,
    });

    selectedProductName.value = "";
    selectedProductPrice.value = 0;
    selectedQuantity.value = 1;
}

function removeItem(index) {
    form.items.splice(index, 1);
}

const subtotal = computed(() =>
    form.items.reduce(
        (total, item) => total + item.product_price * item.quantity,
        0
    )
);

function submit() {
    console.log("Datos enviados: ", form);

    form.post("/orders", {
        onSuccess: () => {
            alert("Orden creada con éxito");
        },
        onError: (errors) => {
            alert("Hubo un error al crear la orden");
            console.error(errors);
        },
    });
}

function cancel() {
    alert("Orden cancelada");
}
</script>

<template>
    <Head title="Crear Orden" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-sm font-medium"
                                >Order Number</label
                            >
                            <input
                                v-model="form.number"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium"
                                >Date</label
                            >
                            <input
                                type="date"
                                v-model="form.date"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium"
                                >Customer</label
                            >
                            <select
                                v-model="form.customer_id"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="" disabled>
                                    Select a client
                                </option>
                                <option
                                    v-for="customer in props.customers"
                                    :key="customer.id"
                                    :value="customer.id"
                                >
                                    {{ customer.name }} ({{ customer.email }})
                                </option>
                            </select>
                        </div>

                        <div class="mb-6 border p-4 rounded">
                            <h3 class="font-semibold mb-2">Add Products</h3>
                            <div class="flex gap-2 mb-4">
                                <input
                                    v-model="selectedProductName"
                                    placeholder="Product Name"
                                    class="border-gray-300 rounded-md w-1/2"
                                />
                                <input
                                    v-model="selectedProductPrice"
                                    type="number"
                                    step="0.01"
                                    placeholder="Precio del Producto"
                                    class="border-gray-300 rounded-md w-1/4"
                                />
                                <input
                                    type="number"
                                    min="1"
                                    v-model="selectedQuantity"
                                    placeholder="Cantidad"
                                    class="w-20 border-gray-300 rounded-md"
                                />
                                <button
                                    type="button"
                                    @click="addItem"
                                    class="bg-green-600 text-white px-3 py-1 rounded"
                                >
                                    Add
                                </button>
                            </div>

                            <table class="w-full text-sm mt-4 border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-left">Product</th>
                                        <th class="p-2 text-center">Price</th>
                                        <th class="p-2 text-center">Amount</th>
                                        <th class="p-2 text-center">Total</th>
                                        <th class="p-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in form.items"
                                        :key="index"
                                        class="border-b"
                                    >
                                        <td class="p-2">
                                            {{ item.product_name }}
                                        </td>
                                        <td class="p-2 text-center">
                                            ${{ item.product_price }}
                                        </td>
                                        <td class="p-2 text-center">
                                            <input
                                                type="number"
                                                min="1"
                                                v-model.number="item.quantity"
                                                class="w-16 border-gray-300 rounded-md text-center"
                                            />
                                        </td>
                                        <td class="p-2 text-center">
                                            ${{
                                                (
                                                    item.product_price *
                                                    item.quantity
                                                ).toFixed(2)
                                            }}
                                        </td>
                                        <td class="p-2 text-center">
                                            <button
                                                type="button"
                                                @click="removeItem(index)"
                                                class="text-red-600 hover:underline"
                                            >
                                                Eliminate
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <p
                                v-if="!form.items.length"
                                class="text-sm text-gray-500 mt-2"
                            >
                                There are no products added.
                            </p>
                        </div>

                        <!-- Subtotal -->
                        <div class="mb-6">
                            <p class="text-lg font-semibold">
                                Subtotal: ${{ subtotal.toFixed(2) }}
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded"
                            >
                                Create Order
                            </button>
                            <button
                                type="button"
                                @click="cancel"
                                class="bg-gray-400 text-white px-4 py-2 rounded"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
