import axios from '@/utils/appAxios';

export const getAllExercises = async () => await axios.get('v1/exercises');