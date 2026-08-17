const API_URL = 'http://127.0.0.1:8000/api';

export async function getReservations() {
    const response = await fetch(`${API_URL}/reservations`, {
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to load reservations.');
    }

    return response.json();
}