export const useFetchData = async (endpoint) => {
    const response = await fetch(`${import.meta.env.VITE_API_URL}${endpoint}`);
    const data = await response.json();
    return data
}