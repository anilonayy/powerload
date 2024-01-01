import axios from '@/utils/appAxios';

const getAllExercises = async () => await axios.get('v1/exercises');

export default {
    getAllExercises
}