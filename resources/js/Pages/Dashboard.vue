<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    orders: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Inventory System
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Orders</h3>
                    <table class="min-w-full text-left border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Order #</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Customer</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="order in orders"
                                :key="order.id"
                                class="border-t"
                            >
                                <td class="px-4 py-2">{{ order.number }}</td>
                                <td class="px-4 py-2">{{ order.date }}</td>
                                <td class="px-4 py-2">
                                    {{ order.customer.name }}
                                </td>
                                <td class="px-4 py-2">
                                    <Link
                                        :href="`/orders/${order.id}`"
                                        class="text-blue-600 hover:underline"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
