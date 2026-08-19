const API_URL = 'http://127.0.0.1:8000/api';

export async function getGuests() {
    const response = await fetch(`${API_URL}/guests`, { // http://127.0.0.1:8000/api/guests
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to load guests.');
    }

    return response.json();
}