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

export async function createReservation(data) {
    const response = await fetch(`${API_URL}/reservations`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        body: JSON.stringify(data),
    });

    const result = await response.json();

    if (!response.ok) {
        throw {
            status: response.status,
            data: result,
        };
    }

    return result;
}
