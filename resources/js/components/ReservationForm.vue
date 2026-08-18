<script setup>
import { ref } from 'vue';
import { createReservation } from '../api/reservations';

const emit = defineEmits(['created', 'cancel']);

const form = ref({
    guest_id: '',
    room_id: '',
    check_in: '',
    check_out: '',
});

const loading = ref(false);
const error = ref(null);

async function submit() {
    loading.value = true;
    error.value = null;

    try {
        const response = await createReservation({
            guest_id: Number(form.value.guest_id),
            room_id: Number(form.value.room_id),
            check_in: form.value.check_in,
            check_out: form.value.check_out,
        });

        emit('created', response.data);
    } catch (err) {
        error.value = err;
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="rounded-lg bg-white p-6 shadow">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">
                New Reservation
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Create a new hotel reservation.
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-5"
        >
            <div>
                <label
                    for="guest_id"
                    class="mb-1 block text-sm font-medium text-gray-700"
                >
                    Guest ID
                </label>

                <input
                    id="guest_id"
                    v-model="form.guest_id"
                    type="number"
                    min="1"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2"
                >
            </div>

            <div>
                <label
                    for="room_id"
                    class="mb-1 block text-sm font-medium text-gray-700"
                >
                    Room ID
                </label>

                <input
                    id="room_id"
                    v-model="form.room_id"
                    type="number"
                    min="1"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2"
                >
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label
                        for="check_in"
                        class="mb-1 block text-sm font-medium text-gray-700"
                    >
                        Check-in
                    </label>

                    <input
                        id="check_in"
                        v-model="form.check_in"
                        type="date"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2"
                    >
                </div>

                <div>
                    <label
                        for="check_out"
                        class="mb-1 block text-sm font-medium text-gray-700"
                    >
                        Check-out
                    </label>

                    <input
                        id="check_out"
                        v-model="form.check_out"
                        type="date"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2"
                    >
                </div>
            </div>

            <div
                v-if="error"
                class="rounded-md bg-red-50 p-4 text-sm text-red-700"
            >
                Something went wrong while creating the reservation.
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    @click="emit('cancel')"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    :disabled="loading"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ loading ? 'Creating...' : 'Create reservation' }}
                </button>
            </div>
        </form>
    </div>
</template>