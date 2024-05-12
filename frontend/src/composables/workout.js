import { ref } from 'vue';
import axios from '@/plugins/appAxios';
import { queryStringBuilder } from '@/utils/helpers';
import workoutService from '@/services/workoutService';

export default function useWorkout() {
  const workouts = ref([]);
  const loaded = ref(false);
  const errors = ref({});

  /**
   * @param {object} config
   */
  const getWorkouts = async (config) => {
    try {
      const response = await axios.get(`/v1/workouts${queryStringBuilder(config)}`);
      workouts.value = response.data;
      loaded.value = true;
    } catch (error) {
      errors.value = error.errors;
      loaded.value = false;
    }
  };

  /**
   * @param {object} config
   * @param {string} config.id
   * @param {?function} config.success
   * @param {?function} config.error
   * @returns {Promise<void>}
   */
  const removeWorkout = async (config) => {
    try {
      await workoutService.deleteWorkout(config.id);
      workouts.value.data = workouts.value.data.filter((workout) => workout.id !== config.id);

      config.success();
    } catch (error) {
      loaded.value = false;
      config.error(error);
    }
  };

  return { workouts, loaded, errors, getWorkouts, removeWorkout };
}
