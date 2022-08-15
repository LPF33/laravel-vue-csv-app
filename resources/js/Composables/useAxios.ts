import { ref, shallowRef } from "vue";
import axios from "axios";

export default function useAxios<T>(method: "get" | "post") {
    const responseError = ref(false);
    const responseData = shallowRef<T | null>(null);

    async function fireAxios(url: string, data: T) {
        responseData.value = null;
        responseError.value = false;
        try {
            const axiosResponse = await axios({ method, url, data });
            if (axiosResponse.status === 200 && axiosResponse.data.ok) {
                responseData.value = data;
            } else if (
                axiosResponse.status === 200 &&
                axiosResponse.data.error
            ) {
                responseError.value = true;
            } else {
                responseError.value = true;
            }
        } catch (error) {
            responseError.value = true;
        }
    }

    return { responseData, responseError, fireAxios };
}
