const API_URL = 'http://127.0.0.1:8000/api';

export async function getRooms() {
    const response = await fetch(`${API_URL}/rooms`, { // http://127.0.0.1:8000/api/rooms
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to load rooms.');
    }

    return response.json();
}