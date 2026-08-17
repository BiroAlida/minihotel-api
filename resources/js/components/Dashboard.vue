<script setup>
import { onMounted, ref } from 'vue'

const rooms = ref([])
const loading = ref(true)
const error = ref(null)

async function fetchRooms() {
    try {
        const response = await fetch('/api/rooms')

        if (!response.ok) {
            throw new Error('Failed to fetch rooms')
        }

        const data = await response.json()
        rooms.value = data.data

    } catch (err) {
        error.value = err.message
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchRooms()
})
</script>

<template>
    <div>
        <h1>MiniHotel Dashboard</h1>

        <p v-if="loading">
            Loading rooms...
        </p>

        <p v-else-if="error">
            Error: {{ error }}
        </p>

        <div v-else>
            <p>
                Rooms: {{ rooms.length }}
            </p>

            <ul>
                <li
                    v-for="room in rooms"
                    :key="room.id"
                >
                    Room {{ room.number }}
                    —
                    {{ room.status }}
                </li>
            </ul>
        </div>
    </div>
</template>