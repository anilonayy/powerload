import { ref } from 'vue';
import axios from '@/plugins/appAxios';
import { queryStringBuilder } from '@/utils/helpers'


export default function useWorkoutHistory()  {
    const workoutHistories = ref([]);
    const loaded = ref(false);
    const errors = ref({});

    const getWorkoutHistories = async (config) => {
        try {
            const response = await axios.get(`/v1/workout-logs${ queryStringBuilder(config) }`);
            workoutHistories.value = response.data;

            loaded.value = true;
        } catch(error) {
            loaded.value = false;
            errors.value = error.errors;
        }

    }

    return { workoutHistories, loaded, errors, getWorkoutHistories };
}