<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    order: Object,
});
</script>

<template>
    <Head title="Order Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Order #{{ order.number }}
            </h2>
        </template>

        <div class="py-6 max-w-4xl mx-auto">
            <div class="mb-4">
                <p><strong>Date:</strong> {{ order.date }}</p>
                <p><strong>Customer:</strong> {{ order.customer.name }}</p>
            </div>

            <div class="border rounded p-6 bg-white shadow">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">
                    Products
                </h3>

                <table
                    class="w-full table-auto text-left text-sm text-gray-700"
                >
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Product</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in order.items"
                            :key="item.id"
                            class="border-b hover:bg-gray-50"
                        >
                            <td class="px-4 py-2">{{ item.product.name }}</td>
                            <td class="px-4 py-2">{{ item.quantity }}</td>
                            <td class="px-4 py-2">
                                ${{ item.price.toFixed(2) }}
                            </td>
                            <td class="px-4 py-2">
                                ${{ (item.quantity * item.price).toFixed(2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
