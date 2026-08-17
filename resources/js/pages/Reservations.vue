<script setup>
import { onMounted, ref } from 'vue';
import { getReservations } from '../api/reservations';

const reservations = ref([]);
const loading = ref(true);
const error = ref(null);

async function loadReservations() {
    loading.value = true;
    error.value = null;

    try {
        const response = await getReservations();

        reservations.value = response.data;
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    loadReservations();
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Reservations
                </h1>

                <p class="mt-2 text-gray-600">
                    Manage hotel reservations.
                </p>
            </div>

            <div
                v-if="loading"
                class="rounded-lg bg-white p-6 shadow"
            >
                Loading reservations...
            </div>

            <div
                v-else-if="error"
                class="rounded-lg bg-red-50 p-6 text-red-700"
            >
                {{ error }}
            </div>

            <div
                v-else
                class="overflow-hidden rounded-lg bg-white shadow"
            >
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                Room
                            </th>

                            <th class="px-6 py-4 text-left">
                                Guest
                            </th>

                            <th class="px-6 py-4 text-left">
                                Check-in
                            </th>

                            <th class="px-6 py-4 text-left">
                                Check-out
                            </th>

                            <th class="px-6 py-4 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="reservation in reservations"
                            :key="reservation.id"
                            class="border-t"
                        >
                            <td class="px-6 py-4">
                                {{ reservation.room.number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ reservation.guest.first_name }}
                                {{ reservation.guest.last_name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ reservation.check_in }}
                            </td>

                            <td class="px-6 py-4">
                                {{ reservation.check_out }}
                            </td>

                            <td class="px-6 py-4">
                                {{ reservation.status }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>