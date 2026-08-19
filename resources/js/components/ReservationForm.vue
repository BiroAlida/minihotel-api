<script setup>
import { onMounted, ref } from 'vue';
import { createReservation } from '../api/reservations';
import { getGuests } from '../api/guests';
import { getRooms } from '../api/rooms';

const emit = defineEmits(['created', 'cancel']);

const form = ref({
    guest_id: '',
    room_id: '',
    check_in: '',
    check_out: '',
});

const guests = ref([]);
const rooms = ref([]);

const loading = ref(false);
const loadingOptions = ref(true);
const error = ref(null);

async function loadOptions() {
    loadingOptions.value = true;
    error.value = null;

    try {
         const [guestsResponse, roomsResponse] = await Promise.all([
            getGuests(),
            getRooms(),
        ]);

        guests.value = guestsResponse.data;
        rooms.value = roomsResponse.data;

    } catch (err) {
        error.value = err;
    } finally {
        loadingOptions.value = false;
    }
}

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

onMounted(() => {
    loadOptions();
});

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

                <select
                    id="guest_id"
                    v-model="form.guest_id"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2"
                >
                    <option value="" disabled>
                        Select a guest
                    </option>

                    <option
                        v-for="guest in guests"
                        :key="guest.id"
                        :value="guest.id"
                    >
                        {{ guest.first_name }} {{ guest.last_name }}
                    </option>
                </select>
            </div>

            <div>
                <label
                    for="room_id"
                    class="mb-1 block text-sm font-medium text-gray-700"
                >
                    Room ID
                </label>

                <select
                    id="room_id"
                    v-model="form.room_id"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2"
                >
                    <option value="" disabled>
                        Select a room
                    </option>

                    <option
                        v-for="room in rooms"
                        :key="room.id"
                        :value="room.id"
                    >
                        Room {{ room.number }}
                    </option>
                </select>
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